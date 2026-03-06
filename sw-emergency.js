/* sw-emergency.js */
const CACHE_NAME = "berg-emergency-v5";
const PROFILE_KEY = "/my-profile.php";

const CORE = [
  "/emergency/offline.html",
  "/manifest-emergency.webmanifest",
  "/assets/img/pwa/berg-emergency-192.png",
  "/assets/img/pwa/berg-emergency-512.png",
  "/assets/img/pwa/apple-touch-icon.png",
];

// Normalizacija (skini hash, zadrzi search)
function norm(u) {
  const url = new URL(u, self.location.origin);
  url.hash = "";
  return url.pathname + url.search;
}

async function safeAdd(cache, url) {
  try {
    const req = new Request(url, { cache: "reload" });
    const res = await fetch(req);
    if (res && res.ok && !res.redirected) {
      await cache.put(req, res.clone());
      return { url, ok: true };
    }
  } catch (_) {}
  return { url, ok: false };
}

async function notifyAllClients(payload) {
  const list = await self.clients.matchAll({ type: "window", includeUncontrolled: true });
  for (const c of list) {
    try { c.postMessage(payload); } catch (_) {}
  }
}

self.addEventListener("install", (event) => {
  event.waitUntil((async () => {
    const cache = await caches.open(CACHE_NAME);

    // BEST EFFORT: ne obaraj instalaciju ako jedan fajl fali
    await Promise.allSettled(CORE.map((u) => safeAdd(cache, u)));

    self.skipWaiting();
  })());
});

self.addEventListener("activate", (event) => {
  event.waitUntil((async () => {
    const keys = await caches.keys();
    await Promise.all(keys.map((k) => (k !== CACHE_NAME ? caches.delete(k) : null)));
    await self.clients.claim();
  })());
});

self.addEventListener("message", (event) => {
  const data = event.data || {};

  if (data.type === "CACHE_NOW") {
    event.waitUntil((async () => {
      const cache = await caches.open(CACHE_NAME);

      const urls = Array.isArray(data.urls) ? data.urls : [];
      let okCount = 0;
      let failCount = 0;

      // Uvek probaj i core (best effort)
      await Promise.allSettled(CORE.map((u) => safeAdd(cache, u)));

      for (const raw of urls) {
        const url = norm(raw);

        // Profile uvek čuvamo pod fiksnim ključem bez query string-a
        const isProfile = url.startsWith(PROFILE_KEY);

        try {
          const req = new Request(url, {
            credentials: "include",
            cache: "reload",
          });

          const res = await fetch(req);

          // Ne keširaj login redirect kao "profile"
          if (!res || !res.ok || res.redirected) {
            failCount++;
            continue;
          }

          if (isProfile) {
            await cache.put(new Request(PROFILE_KEY, { credentials: "include" }), res.clone());
          } else {
            await cache.put(req, res.clone());
          }

          okCount++;
        } catch (_) {
          failCount++;
        }
      }

      await notifyAllClients({ type: "CACHE_DONE", ok: true, okCount, failCount });
    })());
  }

  if (data.type === "CLEAR_EMERGENCY_CACHE") {
    event.waitUntil((async () => {
      await caches.delete(CACHE_NAME);
      const cache = await caches.open(CACHE_NAME);
      await Promise.allSettled(CORE.map((u) => safeAdd(cache, u)));
      await notifyAllClients({ type: "CACHE_CLEARED", ok: true });
    })());
  }
});

self.addEventListener("fetch", (event) => {
  const req = event.request;
  const url = new URL(req.url);

const isEmergency = url.pathname.startsWith("/emergency/");
const isAssets = url.pathname.startsWith("/assets/");
const isDocs =
  url.pathname.endsWith(".pdf") ||
  url.pathname.includes("download_alpenverein_card");

  // Navigacija na emergency profile: cache-first + network refresh
  if (req.mode === "navigate" && url.pathname === "/my-profile.php") {
    event.respondWith((async () => {
      const cache = await caches.open(CACHE_NAME);
      const cached = await cache.match(PROFILE_KEY);

      const network = fetch(req).then(async (res) => {
        if (res && res.ok && !res.redirected) {
          await cache.put(new Request(PROFILE_KEY, { credentials: "include" }), res.clone());
        }
        return res;
      }).catch(() => null);

      if (cached) {
        network.catch(() => {});
        return cached;
      }

      const net = await network;
      return net || (await cache.match("/emergency/offline.html")) || Response.error();
    })());
    return;
  }

  // Assets + emergency fajlovi: cache-first
  if (isEmergency || isAssets || isDocs) {
    event.respondWith((async () => {
      const cache = await caches.open(CACHE_NAME);
      const cached = await cache.match(req.url);
      if (cached) return cached;

      try {
        const res = await fetch(req);
        if (res && res.ok) await cache.put(req.url, res.clone());
        return res;
      } catch (_) {
        if (req.mode === "navigate") {
          return (await cache.match("/emergency/offline.html")) || Response.error();
        }
        return Response.error();
      }
    })());
  }
});
