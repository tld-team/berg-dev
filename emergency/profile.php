<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

$isUserLoggedIn = !empty($_SESSION['user_id']);

if (!$isUserLoggedIn) {
  header('Location: /login.php');
  exit;
}

// DB konekcija: zameni sa tvojim fajlom/varijablom
require_once 'db.php'; // očekujem da ovde dobiješ $mysqli (mysqli konekciju)

$userId = (int)$_SESSION['user_id'];

// CSRF
if (empty($_SESSION['csrf_emergency'])) {
  $_SESSION['csrf_emergency'] = bin2hex(random_bytes(16));
}
$csrf = $_SESSION['csrf_emergency'];

$flash = ''; // poruka posle update-a

// 1) Učitaj osnovne podatke user-a (ime/prezime + id)
$stmt = $mysqli->prepare("SELECT id, first_name, last_name FROM user WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
  // ako user_id u sesiji ne postoji u bazi
  header('Location: /logout.php');
  exit;
}

// 2) Update emergency podataka
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update_emergency') {
  $postedCsrf = (string)($_POST['csrf'] ?? '');
  if (!hash_equals($csrf, $postedCsrf)) {
    $flash = 'Security check failed. Please refresh the page.';
  } else {
    $blood = trim((string)($_POST['blood_group'] ?? ''));
    $allergies = trim((string)($_POST['allergies'] ?? ''));
    $chronic = trim((string)($_POST['chronic_conditions'] ?? ''));
    $meds = trim((string)($_POST['medications'] ?? ''));
    $prev = trim((string)($_POST['previous_surgeries'] ?? ''));
    $addr = trim((string)($_POST['address'] ?? ''));
    $ec1 = trim((string)($_POST['emergency_contact1'] ?? ''));
    $ec2 = trim((string)($_POST['emergency_contact2'] ?? ''));

    // opcionalno: ograničenja dužine za kontakte/krvnu grupu
    $blood = mb_substr($blood, 0, 10);
    $ec1 = mb_substr($ec1, 0, 255);
    $ec2 = mb_substr($ec2, 0, 255);

    $sql = "
      INSERT INTO user_emergency
        (user_id, blood_group, allergies, chronic_conditions, medications, previous_surgeries, address, emergency_contact1, emergency_contact2)
      VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?)
      ON DUPLICATE KEY UPDATE
        blood_group = VALUES(blood_group),
        allergies = VALUES(allergies),
        chronic_conditions = VALUES(chronic_conditions),
        medications = VALUES(medications),
        previous_surgeries = VALUES(previous_surgeries),
        address = VALUES(address),
        emergency_contact1 = VALUES(emergency_contact1),
        emergency_contact2 = VALUES(emergency_contact2)
    ";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param(
      "issssssss",
      $userId,
      $blood,
      $allergies,
      $chronic,
      $meds,
      $prev,
      $addr,
      $ec1,
      $ec2
    );
    $ok = $stmt->execute();
    $stmt->close();

    $flash = $ok ? 'Emergency ID card updated.' : 'Update failed. Please try again.';
  }
}

// 3) Učitaj emergency podatke (posle update-a ili inicijalno)
$stmt = $mysqli->prepare("SELECT * FROM user_emergency WHERE user_id = ? LIMIT 1");
$stmt->bind_param("i", $userId);
$stmt->execute();
$em = $stmt->get_result()->fetch_assoc() ?: [];
$stmt->close();

// 4) Izračunaj Emergency ID
$year = 2026; // ako hoćeš automatski: (int)date('Y')
$emergencyId = sprintf('#%04d-%d', $userId, $year);

$fullName = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
if ($fullName === '') $fullName = 'Member';




// opcionalno: za redirect nazad na istu stranicu posle logout-a
$currentUrl = (string)($_SERVER['REQUEST_URI'] ?? '/');
$logoutHref = 'https://www.bergmembership.com/logout.php?next=' . urlencode($currentUrl);
$loginHref  = 'https://www.bergmembership.com/login.php';

$authHref = $isUserLoggedIn ? $logoutHref : $loginHref;
$authText = $isUserLoggedIn ? 'Logout' : 'Login';

function h(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <base href="/">
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="author" content="https://is.gd/a33FWT" />
    <title>BERG Membership Program - My Profile</title>

    <meta name="description" content="BERG Membership Program - Benefits" />
    <meta name="keywords" content="BERG Membership Program - Benefits" />
    <meta name="robots" content="INDEX,FOLLOW" />
    <meta name="developer" content="Apis Development" />

    <!-- Mobile Specific Metas -->
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <!-- Favicons - Place favicon.ico in the root directory -->
    <link
      rel="apple-touch-icon"
      sizes="57x57"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="apple-touch-icon"
      sizes="60x60"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="apple-touch-icon"
      sizes="72x72"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="apple-touch-icon"
      sizes="76x76"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="apple-touch-icon"
      sizes="114x114"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="apple-touch-icon"
      sizes="120x120"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="apple-touch-icon"
      sizes="144x144"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="apple-touch-icon"
      sizes="152x152"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="apple-touch-icon"
      sizes="180x180"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="96x96"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <!-- <link rel="manifest" href="assets/img/favicons/manifest.json" /> -->
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta
      name="msapplication-TileImage"
      content="assets/img/favicons/ms-icon-144x144.png"
    />
    <meta name="theme-color" content="#fff" />
    <!--=================
	  Google Fonts
	================= -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
      rel="stylesheet"
    />
    <!--=================
	    All CSS File
	================= -->
    <!-- plugins -->
    <link rel="stylesheet" href="assets/css/plugins.css" />
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="manifest" href="/manifest-emergency.webmanifest">
    <link rel="apple-touch-icon" href="/assets/img/pwa/apple-touch-icon.png">
    <meta name="theme-color" content="#75754f">
    
    <style>
        .ma-pop[hidden]{display:none !important;}
.ma-pop{
  position: fixed !important;
  inset: 0 !important;
  z-index: 999999 !important;
}
.ma-pop__backdrop{
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,.55);
}

.ma-pop__dialog{
  position: absolute !important;
  left: 50% !important;
  top: 50% !important;
  transform: translate(-50%, -50%) !important;
  width: min(720px, calc(100vw - 32px)) !important;
  max-height: calc(100vh - 32px) !important;
  overflow: auto !important;
}

    </style>

  </head>

  <body class="vs-body">
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->
    <!--********************************
   		Code Start From Here 
	******************************** -->
    <!--=================
		Preloader
	=================-->
<?php require dirname(__DIR__) . '/header-en.php'; ?>
      <!--================= Header Area end =================-->

      <!--================= Breadcrumb Area start =================-->
      <section
        class="vs-breadcrumb"
        data-bg-src="./assets/img/berg-membership-courses.png"
      >
        <div class="container">
          <div class="row text-center">
            <div class="col-12">
              <div class="breadcrumb-content">
                <h1 class="breadcrumb-title">My Profile</h1>
              </div>
              <div class="breadcrumb-content">
                <h5 class="mt-4" style="color: white">
                  All you need for safe outdoor adventure — in one card.
                </h5>
              </div>
              <div class="breadcrumb-content">
                <p class="mt-4" style="color: white">
                  Explore what you get with BERG: worldwide rescue protection,
                  member savings, and practical access that supports your
                  outdoor lifestyle.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Breadcrumb Area end =================-->

      <!--================= MEMBER ACCESS / MY PROFILE (4 TILES + PANEL) start =================-->
    <section
    class="vs-tour-package space pb-5"
    id="member-access"
    data-bg-src="assets/img/bg/destination.png"
    >
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-12">
            <div class="title-area text-center">
            <span class="sec-subtitle fade-anim" data-direction="bottom">MY PROFILE</span>
            <h2 class="sec-title fade-anim" data-direction="top">
                Your emergency access, SOS and documents — in one place.
            </h2>
            </div>
        </div>
        </div>

        <div id="memberProfile" class="ma-wrap mt-30">

        <!-- II) 4 BIG TILES (2x2 on desktop AND phone) -->
        <div class="ma-tiles" role="tablist" aria-label="Emergency tabs">
            <!-- 1) SOS -->
            <button type="button" class="ma-tile ma-tile--sos is-active" data-key="sos" role="tab" aria-selected="true">
            <div class="ma-tile__badge">1</div>
            <div class="ma-tile__title">SOS</div>
            <div class="ma-tile__hint">Immediate rescue actions</div>
            </button>

            <!-- 2) MY EMERGENCY DOCUMENTS -->
            <button type="button" class="ma-tile ma-tile--strong" data-key="docs" role="tab" aria-selected="false">
            <div class="ma-tile__badge">2</div>
            <div class="ma-tile__title">MY EMERGENCY DOCUMENTS</div>
            <div class="ma-tile__hint">ID + insurance PDFs</div>
            </button>

            <!-- 3) Report Accident -->
            <button type="button" class="ma-tile" data-key="accident" role="tab" aria-selected="false">
            <div class="ma-tile__badge">3</div>
            <div class="ma-tile__title">REPORT ACCIDENT</div>
            <div class="ma-tile__hint">Steps & claim guidance</div>
            </button>

            <!-- 4) Helpline -->
            <button type="button" class="ma-tile" data-key="helpline" role="tab" aria-selected="false">
            <div class="ma-tile__badge">4</div>
            <div class="ma-tile__title">HELPLINE</div>
            <div class="ma-tile__hint">Activation & contacts</div>
            </button>
        </div>

        <!-- DETAILS PANEL (opens below tiles) -->
        <div class="ma-panel" id="maPanel" hidden>
            <div class="ma-panel__head">
            <h3 class="ma-panel__title" id="maPanelTitle">SOS</h3>

            <!-- X close -->
            <button type="button" class="ma-panel__close" id="maClosePanel" aria-label="Close">×</button>
            </div>

            <div class="ma-panel__body">
            <!-- SOS PANEL (TAB 1) - REPLACE ENTIRE BLOCK -->
            <div class="ma-section ma-sos" data-section="sos">
            <h4 class="ma-h4 ma-sos__h1">Need rescue now?</h4>

            <div class="ma-sos__actions">
                <a
                class="vs-btn style7 ma-sos__btn ma-sos__btn--primary"
                href="tel:112"
                id="btnCall112"
                >
                CALL 112 (EU emergency)
                </a>

                <button
                type="button"
                class="vs-btn style7 ma-sos__btn"
                id="btnLocalRescue"
                aria-expanded="true"
                aria-controls="maLocalRescueBox"
                >
                Local Mountain Rescue Numbers
                </button>
            </div>

            <div class="ma-sos__banner" role="note">
                “112 works in most European countries.”
            </div>

            <div class="ma-sos__mini" role="note">
                <div class="ma-sos__miniTitle">No signal?</div>
                <ul class="ma-sos__miniList">
                <li>Walk to higher ground or a ridge.</li>
                <li>Note wind direction and stay visible.</li>
                <li>If possible, send your location via SMS.</li>
                </ul>
            </div>

            <!-- LOCAL RESCUE LIST (VISIBLE BY DEFAULT) -->
            <div class="ma-card mt-20 ma-sos__local" id="maLocalRescueBox">
                <div class="ma-sos__localTop">
                <div>
                    <div class="ma-card__title ma-sos__localTitle">Local rescue numbers (offline list)</div>
                    <div class="ma-sos__sub" id="maRescueHint" aria-live="polite"></div>
                </div>

                <div class="ma-sos__cachePill" id="maCachePill" title="Offline cache status">
                    <span class="ma-sos__dot" aria-hidden="true"></span>
                    <span id="maCacheText">Not cached</span>
                </div>
                </div>

                <div class="ma-sos__tools mt-12">
                <div class="ma-sos__searchWrap">
                    <input
                    type="text"
                    class="form-control ma-input ma-sos__search"
                    id="maRescueSearch"
                    placeholder="Search by country, ISO, emergency or SAR (e.g. Serbia / SRB / 112)..."
                    autocomplete="off"
                    />
                    <div class="ma-sos__count" id="maRescueCount">Showing 0 results</div>
                </div>

                <div class="ma-sos__dlWrap">
                    <button type="button" class="vs-btn style7 ma-docs__btn" id="maDownloadCsv">
                    Download full list
                    </button>
                    <button type="button" class="vs-btn style7 ma-docs__btn" id="maDownloadPdf">
                    Download PDF
                    </button>
                    <button type="button" class="vs-btn style7 ma-docs__btn" id="maCacheList">
                    Cache list offline
                    </button>
                </div>
                </div>

                <div class="ma-rescue-table mt-14" role="table" aria-label="Emergency and SAR numbers by country">
                <div class="ma-rescue-head" role="rowgroup">
                    <div class="ma-rescue-row ma-rescue-row--head" role="row">
                    <div class="ma-rescue-cell" role="columnheader">ISO</div>
                    <div class="ma-rescue-cell" role="columnheader">Country</div>
                    <div class="ma-rescue-cell ma-rescue-cell--right" role="columnheader">Emergency</div>
                    <div class="ma-rescue-cell ma-rescue-cell--right" role="columnheader">SAR</div>
                    </div>
                </div>

                <!-- FIRST ~10 are visible; rest scrolls -->
                <div class="ma-rescue-body" id="maRescueList" role="rowgroup" tabindex="0"></div>

                <div class="ma-rescue-empty" id="maRescueEmpty" hidden>
                    No matches. Try a different keyword.
                </div>
                </div>

                <!-- SAR + data disclaimer -->
                <details class="ma-sos__disclaimer mt-16">
                <summary class="ma-sos__disclaimerSummary">SAR disclaimer & data accuracy</summary>

                <div class="ma-sos__disclaimerBody">
                    <p>
                    <strong>SAR number</strong> represents a specialised Search and Rescue service contact in countries where such a service has a dedicated phone number.
                    If a country does not have a separate SAR number, Search and Rescue is activated via the national emergency number (e.g. 112, 911, 999, 000).
                    </p>

                    <p><strong>Recommendation:</strong> always call the national emergency number first, especially when:</p>
                    <ul>
                    <li>there is a risk to life or health,</li>
                    <li>signal is limited,</li>
                    <li>it is unclear whether a local mountain unit exists,</li>
                    <li>the caller cannot share an exact location,</li>
                    <li>coordination with medical, police or fire services is required.</li>
                    </ul>

                    <p>
                    Use the SAR number only where it is officially defined and you are aware you are calling a specialised unit directly.
                    If you are unsure which number to call, use the national emergency number — it is the only service legally obliged to receive,
                    coordinate and forward the intervention to competent SAR teams.
                    </p>

                    <p class="mb-0">
                    All emergency and SAR contacts shown here are provided for informational purposes only. BERG and its technical partners do not guarantee full accuracy,
                    timeliness or completeness. Numbers may change due to regulations, jurisdictions, migrations and operational procedures.
                    BERG is not liable for inaccuracies, update delays, inability to place calls, network outages or consequences of relying on this information.
                    </p>
                </div>
                </details>

                <!-- Reference -->
                <div class="ma-sos__ref mt-16">
                <div class="ma-sos__refTitle">Reference / data source</div>
                <div class="ma-sos__refText">
                    Many emergency numbers are based on publicly available international records published by
                    <strong>ICAR – International Commission for Alpine Rescue</strong>.
                    You can download and verify the ICAR list here:
                    <a class="ma-link" href="https://www.alpine-rescue.org/articles/269--mountain-rescue-service-emergency-phone-numbers" target="_blank" rel="noopener">
                    Mountain Rescue Service Emergency Phone Numbers
                    </a>.
                    Direct PDF reference: <em>“International Emergency Telephone Codes”</em> (last public version: 31.12.2023).
                </div>
                </div>
            </div>

            <!-- STICKY BOTTOM BANNER (ALWAYS VISIBLE INSIDE TAB) -->
            <div class="ma-bottom-banner ma-bottom-banner--sticky mt-18" role="note">
                <div class="ma-bottom-banner__inner">
                <div class="ma-bottom-banner__text">
                    <div class="ma-bottom-banner__title">
                    Before repatriation or transfer, you must contact Europ Assistance otherwise a maximum of EUR 750 will be reimbursed.
                    </div>
                    <div class="ma-bottom-banner__meta">
                    <span class="ma-bottom-banner__brand">Europ Assistance</span>
                    <a class="ma-bottom-banner__phone" href="tel:+4312533798">+43/1/253 3798</a>
                    </div>
                </div>

                <a
                    class="vs-btn style7 ma-bottom-banner__btn"
                    href="https://alpenverein.sichermitknox.com/schadenmelden"
                    target="_blank"
                    rel="noopener"
                >
                    REPORT EMERGENCY
                </a>
                </div>
            </div>
            </div>
            <!-- /SOS PANEL -->



            <!-- DOCUMENTS PANEL (TAB 2) -->
            <div class="ma-section ma-docs" data-section="docs" hidden
                data-av-url="/assets/docs/alpenverein-card.pdf"
                data-brochure-url="/assets/docs/insurance-brochure.pdf">

            <h4 class="ma-h4 ma-docs__h1">My Emergency Documents</h4>

            <div class="ma-docs__grid">
                <!-- LEFT: SHOW THIS TO RESCUERS -->
                <div class="ma-card ma-docs__card">
                <div class="ma-card__title">SHOW THIS TO RESCUERS</div>
                <p class="ma-p ma-docs__p">
                    Quick access card + brochure. Cache these for offline use before your trip.
                </p>

                <div class="ma-docs__tools">
                    <div class="ma-docs__searchWrap">
                    <div class="ma-docs__cachePill" id="maDocsCachePill">
                        <span class="ma-docs__dot" id="maDocsCacheDot"></span>
                        <span id="maDocsCacheText">Not cached</span>
                    </div>
                    <div class="ma-docs__hint" id="maDocsHint" aria-live="polite"></div>
                    </div>

                    <div class="ma-docs__actions">
                    <button type="button" class="vs-btn style7 ma-docs__btn" id="btnShowAlpenvereinCard">
                        Show Alpenverein Card
                    </button>

                    <button type="button" class="vs-btn style7 ma-docs__btn" id="btnOpenBrochure">
                        Open Insurance Brochure 
                    </button>

                    <button type="button" class="vs-btn style7 ma-docs__btn ma-docs__btn--ghost" id="btnCacheDocs">
                        Cache Offline
                    </button>
                    </div>
                </div>

                <!-- Viewer (opens in the same tab) -->
                <div class="ma-docs__viewer" id="maDocsViewer" hidden>
                    <div class="ma-docs__viewerTop">
                    <div class="ma-docs__viewerTitle" id="maDocsViewerTitle">Document</div>
                    <button type="button" class="ma-docs__viewerClose" id="btnCloseDocsViewer" aria-label="Close">✕</button>
                    </div>

                    <div class="ma-docs__viewerBody">
                    <div class="ma-docs__viewerNotice" id="maDocsViewerNotice" hidden></div>

                    <!-- iframe for PDF display (works with cached blob too) -->
                    <iframe class="ma-docs__iframe" id="maDocsFrame" title="Document viewer"></iframe>

                    <div class="ma-docs__viewerFooter">
                        <button type="button" class="vs-btn style7 ma-docs__btn ma-docs__btn--ghost" id="btnDownloadCurrent">
                        Download
                        </button>
                    </div>
                    </div>
                </div>
                </div>

                <!-- RIGHT: EMERGENCY ID -->
                <div class="ma-card ma-docs__card">
                <div class="ma-card__title">EMERGENCY ID</div>
                <p class="ma-p ma-docs__p">
                    Basic emergency data shown to rescuers or medical staff (placeholders until user fills data).
                </p>

                <!-- ID CARD -->
                <div class="ma-idcard" id="maEmergencyIdCard">
  <div class="ma-idcard__top">
    <div class="ma-idcard__photo">
      <img src="https://via.placeholder.com/72x72.png?text=Photo" alt="Profile photo" />
    </div>
    <div class="ma-idcard__who">
      <div class="ma-idcard__name"><?= h($fullName) ?></div>
      <div class="ma-idcard__meta">Emergency ID • <strong><?= h($emergencyId) ?></strong></div>

      <?php if (!empty($flash)): ?>
        <div style="margin-top:6px; font-size:13px; opacity:.9;">
          <?= h($flash) ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <form method="POST" class="ma-idcard__form" style="margin-top:12px;">
    <input type="hidden" name="action" value="update_emergency" />
    <input type="hidden" name="csrf" value="<?= h($csrf) ?>" />

    <div class="ma-kv ma-idcard__kv">
      <div class="ma-kv__row">
        <span>Blood group</span>
        <strong style="min-width:180px;">
          <input class="form-control" type="text" name="blood_group" placeholder="e.g. O+"
                 value="<?= h((string)($em['blood_group'] ?? '')) ?>" />
        </strong>
      </div>

      <div class="ma-kv__row">
        <span>Allergies</span>
        <strong style="min-width:180px;">
          <input class="form-control" name="allergies"  type="text"
                    placeholder="e.g. Penicillin" value="<?= h((string)($em['allergies'] ?? '')) ?>"/>
        </strong>
      </div>

      <div class="ma-kv__row">
        <span>Chronic conditions</span>
        <strong style="min-width:180px;">
          <input class="form-control" name="chronic_conditions"  type="text"
                    placeholder="e.g. Asthma" value="<?= h((string)($em['chronic_conditions'] ?? '')) ?>"/>
        </strong>
      </div>

      <div class="ma-kv__row">
        <span>Medications</span>
        <strong style="min-width:180px;">
          <input class="form-control" name="medications"  type="text"
                    placeholder="e.g. Inhaler" value="<?= h((string)($em['medications'] ?? '')) ?>"/>
        </strong>
      </div>

      <div class="ma-kv__row">
        <span>Previous surgeries / injuries</span>
        <strong style="min-width:180px;">
          <input class="form-control" name="previous_surgeries"  type="text"
                    placeholder="e.g. Knee surgery 2021" value="<?= h((string)($em['previous_surgeries'] ?? '')) ?>"/>
        </strong>
      </div>

      <div class="ma-kv__row">
        <span>Address</span>
        <strong style="min-width:180px;">
          <input class="form-control" name="address"  type="text"
                    placeholder="Street, number, city" value="<?= h((string)($em['address'] ?? '')) ?>"/>
        </strong>
      </div>

      <div class="ma-kv__row">
        <span>Emergency contact 1</span>
        <strong style="min-width:180px;">
          <input class="form-control" type="text" name="emergency_contact1"
                 placeholder="Name + phone"
                 value="<?= h((string)($em['emergency_contact1'] ?? '')) ?>" />
        </strong>
      </div>

      <div class="ma-kv__row">
        <span>Emergency contact 2</span>
        <strong style="min-width:180px;">
          <input class="form-control" type="text" name="emergency_contact2"
                 placeholder="Name + phone"
                 value="<?= h((string)($em['emergency_contact2'] ?? '')) ?>" />
        </strong>
      </div>
    </div>

    <div class="ma-docs__note">
      Show this card to rescuers or medical staff.
    </div>

    <div class="ma-docs__idActions" style="display:flex; gap:10px; flex-wrap:wrap;">
      <button type="submit" class="vs-btn style7 ma-docs__btn">
        Update
      </button>

      <button type="button" class="vs-btn style7 ma-docs__btn" id="btnPrintEmergencyId">
        Download Emergency ID
      </button>
    </div>
  </form>
</div>

            </div>

            <!-- FIXED BOTTOM BANNER (same markup as other tabs) -->
            <div class="ma-bottom-banner mt-25" role="note">
                <div class="ma-bottom-banner__inner">
                <div class="ma-bottom-banner__text">
                    <div class="ma-bottom-banner__title">
                    Before repatriation or transfer, you must contact Europ Assistance otherwise a maximum of EUR 750 will be reimbursed.
                    </div>
                    <div class="ma-bottom-banner__meta">
                    <span class="ma-bottom-banner__brand">Europ Assistance</span>
                    <a class="ma-bottom-banner__phone" href="tel:+4312533798">+43/1/253 3798</a>
                    </div>
                </div>

                <a class="vs-btn style7 ma-bottom-banner__btn"
                    href="https://alpenverein.sichermitknox.com/schadenmelden"
                    target="_blank" rel="noopener">
                    REPORT EMERGENCY
                </a>
                </div>
            </div>
            </div>


            <!-- REPORT ACCIDENT PANEL (TAB 3) -->
            <div class="ma-section ma-accident" data-section="accident" hidden>
            <h4 class="ma-h4 ma-accident__h1">Report Accident</h4>

            <!-- STEP 1 -->
            <div class="ma-card ma-accident__card">
                <div class="ma-card__title ma-accident__title">STEP 1 — LIFE-SAVING</div>
                <p class="ma-p ma-accident__p">
                If someone is in danger — call rescue immediately.
                </p>

                <div class="ma-accident__actions">
                <button type="button" class="vs-btn style7 ma-accident__btn" data-jump="sos">
                    GO TO SOS
                </button>
                <a class="ma-accident__quick" href="tel:112" aria-label="Call 112">Call 112</a>
                </div>

                <div class="ma-accident__hint">
                Use SOS to find the correct local mountain rescue number for your country/region.
                </div>

                <!-- NEW: Battery saver block -->
                <div class="ma-accident__battery">
                <div class="ma-accident__batteryTitle">If your battery is running low</div>
                <div class="ma-accident__batteryText">
                    If your phone battery is low and dropping fast, do the following:
                </div>
                <ul class="ma-accident__batteryList">
                    <li>Send your location only once — do not use live tracking.</li>
                    <li>Close all apps that are not urgently needed.</li>
                    <li>Turn off mobile data, Wi-Fi and Bluetooth.</li>
                    <li>Enable airplane mode when you are not making calls.</li>
                    <li>Keep your phone in an inner pocket so your body heat keeps it warm.</li>
                    <li>Avoid sending messages, videos and photos while waiting for help.</li>
                </ul>
                <div class="ma-accident__batteryNote">
                    “Preserving battery while waiting for rescuers can determine the outcome.”
                </div>
                </div>
            </div>

            <!-- STEP 2 -->
            <div class="ma-card ma-accident__card mt-15">
                <div class="ma-card__title ma-accident__title">STEP 2 — TRANSPORT / HOSPITAL SUPPORT</div>
                <p class="ma-p ma-accident__p">
                When you are safe, stabilised in a hospital, and need transportation to another hospital or home:
                </p>

                <div class="ma-accident__contact">
                <div class="ma-accident__brand">Europ Assistance</div>

                <div class="ma-accident__contactLine">
                    <span class="ma-accident__label">Phone</span>
                    <a class="ma-accident__value" href="tel:+4312533798">+43/1/253 3798</a>
                </div>

                <div class="ma-accident__contactLine">
                    <span class="ma-accident__label">Email</span>
                    <a class="ma-accident__value" href="mailto:aws@alpenverein.at">aws@alpenverein.at</a>
                </div>

                <div class="ma-accident__micro">
                    Transport must be organised via Europ Assistance. Otherwise a maximum of EUR 750 will be reimbursed.
                </div>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="ma-card ma-accident__card mt-15">
                <div class="ma-card__title ma-accident__title">STEP 3 — CLAIM & REPORT</div>

                <p class="ma-p ma-accident__p">
                Submit your claim using the official online form.
                </p>

                <div class="ma-accident__online" id="maAccidentOnlineNote" role="note">
                <span class="ma-accident__onlineDot" aria-hidden="true"></span>
                <span id="maAccidentOnlineText">Online status: Checking…</span>
                </div>

                <div class="ma-accident__actions">
                <a
                    class="vs-btn style7 ma-accident__btn ma-accident__btn--wide"
                    href="https://alpenverein.sichermitknox.com/schadenmelden"
                    target="_blank"
                    rel="noopener"
                    id="btnReportEmergency"
                >
                    REPORT EMERGENCY 
                </a>
                </div>

                <div class="ma-accident__offline" id="maAccidentOfflineMsg" hidden>
                This form requires internet. Submit once you have signal.
                </div>

                <div class="ma-accident__divider"></div>

                <div class="ma-accident__details">
                <div class="ma-accident__detailsTitle">What to do in case of an accident?</div>

                <p class="ma-accident__detailsP">
                    If rescue from inaccessible terrain is necessary, always call the local mountain rescue service emergency line or another
                    emergency line in the country/region. In Europe this is typically <a class="ma-link" href="tel:112">112</a>.
                    <button type="button" class="ma-accident__inlineJump" data-jump="sos">Open SOS</button>
                    to find the correct local number.
                </p>

                <p class="ma-accident__detailsP">
                    In life-threatening situations, call for help immediately so the rescue team can reach you as quickly and efficiently as possible.
                </p>

                <p class="ma-accident__detailsP">
                    If you are already safe, stabilised in a hospital and need transportation to another hospital (closest to your place of permanent residence),
                    or to your place of permanent residence itself, it must be organised by the contracted assistance provider listed on your Alpenverein
                    membership card: <strong>Europ Assistance</strong> —
                    <a class="ma-link" href="tel:+4312533798">+43/1/253 3798</a>,
                    <a class="ma-link" href="mailto:aws@alpenverein.at">aws@alpenverein.at</a>.
                    Otherwise, you will be reimbursed a maximum of <strong>EUR 750</strong> for this transportation.
                </p>
                </div>
            </div>

            <!-- Fixed bottom banner (same markup as other tabs) -->
            <div class="ma-bottom-banner mt-25" role="note">
                <div class="ma-bottom-banner__inner">
                <div class="ma-bottom-banner__text">
                    <div class="ma-bottom-banner__title">
                    Before repatriation or transfer, you must contact Europ Assistance otherwise a maximum of EUR 750 will be reimbursed.
                    </div>
                    <div class="ma-bottom-banner__meta">
                    <span class="ma-bottom-banner__brand">Europ Assistance</span>
                    <a class="ma-bottom-banner__phone" href="tel:+4312533798">+43/1/253 3798</a>
                    </div>
                </div>

                <a
                    class="vs-btn style7 ma-bottom-banner__btn"
                    href="https://alpenverein.sichermitknox.com/schadenmelden"
                    target="_blank"
                    rel="noopener"
                >
                    REPORT EMERGENCY
                </a>
                </div>
            </div>
            </div>


            
            <!-- HELPLINE PANEL (TAB 4) -->
            <div class="ma-section ma-helpline" data-section="helpline" hidden>
            <h4 class="ma-h4 ma-helpline__h1">Helpline</h4>

            <!-- Activation card -->
            <div class="ma-card">
                <div class="ma-helpline__top">
                <div>
                    <div class="ma-card__title ma-helpline__title">ACTIVATION REQUIRED</div>
                    <p class="ma-p ma-helpline__sub">
                    Activate Helpline before going outdoors. Your emergency contacts can use this line to get information about you if something happens.
                    </p>
                </div>

                <div class="ma-helpline__pill" aria-label="Activation status">
                    <span class="ma-helpline__pillDot" aria-hidden="true"></span>
                    Not cached
                </div>
                </div>

                <div class="ma-helpline__actions">
                <a
                    class="vs-btn style7 ma-helpline__btn ma-helpline__btn--primary"
                    href="https://alpenverein.sichermitknox.com/helpline-login"
                    target="_blank"
                    rel="noopener"
                    id="btnActivateHelpline"
                >
                    ACTIVATE HELPLINE
                </a>

                <a
                    class="vs-btn style7 ma-helpline__btn ma-helpline__btn--call"
                    href="tel:+430501015"
                    id="btnHelplineOffline"
                >
                    HELPLINE (OFFLINE CALL): +43 (0) 50 10 15
                </a>
                </div>

                <div class="ma-note mt-15" role="note">
                <strong>Recommendation:</strong> We recommend activating Helpline before any trip.
                <br />
                <span style="opacity:.9;">
                    More info &amp; videos:
                    <a
                    class="ma-helpline__link"
                    href="https://alpenverein.sichermitknox.com/service"
                    target="_blank"
                    rel="noopener"
                    >
                    Open HelpLine service page
                    </a>
                </span>
                </div>
            </div>

            <!-- Explanation card -->
            <div class="ma-card mt-15">
                <div class="ma-card__title">Helpline: Information when it matters</div>
                <div class="ma-helpline__explain ma-p">
                <p class="ma-p" style="margin-bottom:10px;">
                    “If something happens, I won’t find out.”
                </p>
                <p class="ma-p" style="margin-bottom:0;">
                    Neither hospitals nor the police are allowed to release information, and patients are often unable to do so.
                    Then begins the ordeal of navigating confidentiality and data protection.
                    The HelpLine relieves your emergency contacts of this uncertainty and regulates their right to information.
                </p>
                </div>
            </div>

            <!-- Extra tip card (bottom part requested) -->
            <div class="ma-card mt-15">
                <div class="ma-card__title">PHONE POWER TIP (ALTITUDE &amp; COLD)</div>
                <div class="ma-helpline__tip">
                <div class="ma-helpline__tipTitle">Keep power for the call that matters</div>
                <p class="ma-helpline__tipText">
                    At higher altitudes and in cold weather, phones drain battery much faster.
                    The combination of cold wind, weak signal and demanding terrain can drain your battery several times faster than in the city.
                    Keep your phone in an inner pocket close to your body, switch off features you don’t need, and save energy so you can call for help if necessary.
                </p>
                </div>
            </div>

            <!-- FIXED BOTTOM BANNER (same markup you already use on other tabs) -->
            <div class="ma-bottom-banner mt-25" role="note">
                <div class="ma-bottom-banner__inner">
                <div class="ma-bottom-banner__text">
                    <div class="ma-bottom-banner__title">
                    Before repatriation or transfer, you must contact Europ Assistance otherwise a maximum of EUR 750 will be reimbursed.
                    </div>
                    <div class="ma-bottom-banner__meta">
                    <span class="ma-bottom-banner__brand">Europ Assistance</span>
                    <a class="ma-bottom-banner__phone" href="tel:+4312533798">+43/1/253 3798</a>
                    </div>
                </div>

                <a
                    class="vs-btn style7 ma-bottom-banner__btn"
                    href="https://alpenverein.sichermitknox.com/schadenmelden"
                    target="_blank"
                    rel="noopener"
                >
                    REPORT EMERGENCY
                </a>
                </div>
            </div>
            </div>

            </div>

            <!-- Panel bottom navigation -->
            <div class="ma-panel__footer">
            <button type="button" class="vs-btn style7" id="maPrev">BACK</button>
            <button type="button" class="vs-btn style7" id="maNext">NEXT</button>
            </div>
        </div>

        <!-- IV) GET READY FOR THE TOUR -->
        <div class="ma-prep mt-25">
        <div class="ma-prep__title">GET READY FOR THE TOUR</div>
        <div class="ma-prep__text">
            Before you head into the mountains or any more demanding terrain, do the following:
        </div>

        <ul class="ma-prep__list">
            <li>Cache all documents and cards in BERG so they are available even without internet</li>
            <li>Charge your phone battery to 100% and bring a fully charged power bank</li>
            <li>Enable battery saver mode before you start moving</li>
            <li>Inform your emergency contacts where you’re going, who you’re going with, how long you’ll stay, and when you plan to return</li>
            <li>Turn on airplane mode when you don’t have coverage or don’t need mobile data — your phone uses far less power in this mode</li>
            <li>Disable mobile data, Wi-Fi, Bluetooth, and close background apps you don’t urgently need</li>
            <li>In cold conditions, keep your phone in an inner pocket close to your body — low temperatures drastically reduce battery life</li>
            <li>If you’re moving in a group, agree that one phone stays on while another is kept as a backup for emergencies</li>
            <li>Avoid constant GPS tracking, navigation, and sending photos/videos — it drains battery and signal extremely fast</li>
        </ul>

        <div class="ma-prep__note">
            <strong>Note:</strong><br />
            “A few minutes of preparation before departure can be crucial for your safety when you’re in the mountains.”
        </div>
        </div>

        <!-- V Rotating tips (Home / My Profile style) -->
        <div class="ma-tips mt-20" aria-label="Rotating safety tips">
        <div class="ma-tips__head">
            <div class="ma-tips__label">QUICK SAFETY TIPS</div>

            <div class="ma-tips__nav" aria-label="Carousel controls">
            <button type="button" class="ma-tips__arrow" id="maTipsPrev" aria-label="Previous tips">
                ‹
            </button>
            <button type="button" class="ma-tips__arrow" id="maTipsNext" aria-label="Next tips">
                ›
            </button>
            </div>
        </div>

        <div class="ma-tips__viewport" id="maTipsViewport" tabindex="0" aria-roledescription="carousel">
            <div class="ma-tips__track" id="maTipsTrack">
            <article class="ma-tip-card" aria-label="Tip 1">
                <div class="ma-tip-card__inner">
                <div class="ma-tip-card__title">Cold & altitude drain battery faster</div>
                <div class="ma-tip-card__text">
                    Your phone drains battery much faster in cold weather and at higher altitude.
                    Keep it in an inner pocket and enable battery saver as soon as you start your hike.
                </div>
                </div>
            </article>

            <article class="ma-tip-card" aria-label="Tip 2">
                <div class="ma-tip-card__inner">
                <div class="ma-tip-card__title">No signal = higher power consumption</div>
                <div class="ma-tip-card__text">
                    In the mountains, your phone constantly searches for signal and can drain battery multiple times faster than in the city.
                    When there’s no coverage, enable airplane mode and save power for emergencies.
                </div>
                </div>
            </article>

            <article class="ma-tip-card" aria-label="Tip 3">
                <div class="ma-tip-card__inner">
                <div class="ma-tip-card__title">Cache BERG before departure</div>
                <div class="ma-tip-card__text">
                    Cache all BERG documents and cards before you leave.
                    Don’t rely on having internet signal when you need it most.
                </div>
                </div>
            </article>

            <article class="ma-tip-card" aria-label="Tip 4">
                <div class="ma-tip-card__inner">
                <div class="ma-tip-card__title">Save battery for the rescue call</div>
                <div class="ma-tip-card__text">
                    Save battery for calling for help.
                    Avoid live GPS tracking and posting photos/videos while you’re in the mountains.
                </div>
                </div>
            </article>
            </div>
        </div>

        <div class="ma-tips__dots" id="maTipsDots" aria-label="Tips pagination"></div>
        </div>



        </div>
    </div>
    </section>

    <!-- I) REQUIRED POPUP ON PAGE OPEN -->
    <div class="ma-pop" id="maOfflinePopup" hidden>
    <div class="ma-pop__backdrop" data-pop-close></div>

    <div class="ma-pop__dialog" role="dialog" aria-modal="true" aria-labelledby="maPopTitle">
        <button type="button" class="ma-pop__close" data-pop-close aria-label="Close">×</button>

        <div class="ma-pop__title" id="maPopTitle">Cache documents for offline use</div>

        <ul class="ma-pop__list">
        <li>Download emergency PDFs</li>
        <li>Save ID cards for offline viewing</li>
        <li>Add app to Home Screen</li>
        </ul>

        <div class="ma-pop__note">
        “BERG Emergency Mode works even without internet.<br />
        Before you head outdoors, make sure you cache your data.”
        </div>
        
                <!-- IOS -->
        
        <div class="ma-pop__note" id="maPopHelp"></div>
        
        <!-- IOS -->

        <div class="ma-pop__actions">
        <button type="button" class="vs-btn style7 w-100" id="maPopInstall" style="display:none;">ADD TO HOME SCREEN</button>
        <button type="button" class="vs-btn style7 w-100" id="maPopCacheNow">Cache Now</button>
        <div class="ma-pop__disclaimer" id="maPopStatus">The process takes 10–20 seconds.</div>
        </div>

    </div>
    </div>



    </main>
    <!-- ================= Footer Start ================= -->
<?php require dirname(__DIR__) . '/footer-en.php'; ?>
    <!-- ================= Footer End ================= -->

    <!-- ================= Main Section Wrapper End ================= -->
    <a href="#" class="scrollToTop scroll-btn"
      ><i class="far fa-arrow-up"></i
    ></a>
    <!-- ***************** Code End  Here ***************** -->
    <!--================= All Js File ================= -->
    <!-- Jquery -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <!-- Jquery UI -->
    <script src="assets/js/jquery-ui.min.js"></script>
    <!-- Jquery UI -->
    <script src="assets/js/moment.min.js"></script>
    <!-- Jquery UI -->
    <script src="assets/js/daterangepicker.min.js"></script>
    <!-- Swiper Slider -->
    <script src="assets/js/swiper-bundle.min.js"></script>
    <!-- Bootstrap -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- WOW.js Animation -->
    <script src="assets/js/wow.min.js"></script>
    <!-- Magnific Popup -->
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Image Loaded Jquery -->
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <!-- Odometer JS -->
    <script src="assets/js/odometer.min.js"></script>
    <script src="assets/js/viewport.jquery.js"></script>
    <!-- Gsap -->
    <script src="assets/js/gsap.min.js"></script>
    <!-- ScrollTrigger -->
    <script src="assets/js/ScrollTrigger.min.js"></script>
    <!-- ScrollToPlugin -->
    <script src="assets/js/ScrollToPlugin.min.js"></script>
    <!-- SplitText -->
    <script src="assets/js/SplitText.min.js"></script>

    <!-- Main Js File -->
    <script src="assets/js/main.js"></script>
    
    
        <script>
(() => {
  const pop = document.getElementById("maOfflinePopup");
  const helpEl = document.getElementById("maPopHelp");
  const statusEl = document.getElementById("maPopStatus");
  const installBtn = document.getElementById("maPopInstall");
  const cacheBtn = document.getElementById("maPopCacheNow");

  // Ako ti je modal nekad "zalepljen" za scroll: prebaci ga direktno u body
  if (pop && pop.parentElement !== document.body) document.body.appendChild(pop);

  const ua = navigator.userAgent || "";
  const isIOS = /iPad|iPhone|iPod/.test(ua) && !window.MSStream;
  const isStandalone = window.matchMedia("(display-mode: standalone)").matches || window.navigator.standalone === true;

  let deferredPrompt = null;

  window.addEventListener("beforeinstallprompt", (e) => {
    e.preventDefault();
    deferredPrompt = e;
    renderHelp();
  });

  function renderHelp() {
    if (isStandalone) {
      helpEl.innerHTML = '“BERG Emergency Mode works even without internet.”<br>Icon is already installed on your Home Screen.';
      installBtn.style.display = "none";
      return;
    }

    if (isIOS) {
      helpEl.innerHTML =
        'iPhone/iPad (Safari):<br>' +
        '1) Open this page in <b>Safari</b><br>' +
        '2) Tap <b>Share</b> (square + arrow)<br>' +
        '3) Tap <b>Add to Home Screen</b><br>' +
        '<br><b>Then</b> tap <b>Cache Now</b> once while online.';
      installBtn.style.display = "none";
      return;
    }

    if (deferredPrompt) {
      helpEl.innerHTML =
        'Android: Tap <b>ADD TO HOME SCREEN</b> to install the icon.<br>' +
        'After that, tap <b>Cache Now</b> once while online.';
      installBtn.style.display = "inline-flex";
      return;
    }

    helpEl.innerHTML =
      'Manual install:<br>' +
      'Android (Chrome): Menu (⋮) → <b>Install app</b> / <b>Add to Home screen</b><br>' +
      'iOS: Safari → Share → <b>Add to Home Screen</b><br>' +
      '<br><b>Then</b> tap <b>Cache Now</b> once while online.';
    installBtn.style.display = "none";
  }

  renderHelp();
  ensureSW();


  installBtn.addEventListener("click", async () => {
    if (!deferredPrompt) return;
    deferredPrompt.prompt();
    const res = await deferredPrompt.userChoice;
    deferredPrompt = null;

    if (res && res.outcome === "accepted") {
      statusEl.textContent = "Installed. Now tap “Cache Now” to download offline data.";
      installBtn.style.display = "none";
    }
  });

  async function ensureSW() {
    if (!("serviceWorker" in navigator)) return false;
    try {
      await navigator.serviceWorker.register("/sw-emergency.js", { scope: "/" });
      await navigator.serviceWorker.ready;
      return true;
    } catch (err) {
      console.warn("SW register failed:", err);
      return false;
    }
  }

  const EMERGENCY_URLS = [
    "/emergency/profile.php",
    "/emergency/offline.html",
    "/assets/css/plugins.css",
    "/assets/css/style.css",
    "/assets/js/vendor/jquery-3.6.0.min.js",
    "/assets/js/main.js",
    "/assets/docs/alpenverein-card.pdf",
    "/assets/docs/insurance-brochure.pdf",
    "/manifest-emergency.webmanifest",
    "/assets/img/pwa/berg-emergency-192.png",
    "/assets/img/pwa/berg-emergency-512.png",
    "/assets/img/pwa/apple-touch-icon.png"
  ];

  function warmUpLoad(url) {
    return new Promise((resolve) => {
      const iframe = document.createElement("iframe");
      iframe.style.position = "absolute";
      iframe.style.width = "1px";
      iframe.style.height = "1px";
      iframe.style.opacity = "0";
      iframe.style.pointerEvents = "none";
      iframe.src = url;

      document.body.appendChild(iframe);

      iframe.onload = () => setTimeout(() => { iframe.remove(); resolve(true); }, 1200);
      setTimeout(() => { try { iframe.remove(); } catch(e){} resolve(false); }, 15000);
    });
  }

  cacheBtn.addEventListener("click", async () => {
    statusEl.textContent = "Caching… keep this page open (10–20s).";

    const ok = await ensureSW();
    if (!ok) {
      statusEl.textContent = "Service Worker failed. This works only on HTTPS (or localhost).";
      return;
    }

    await warmUpLoad("/emergency/profile.php?cachewarm=1");

    const sw = navigator.serviceWorker.controller || (await navigator.serviceWorker.ready).active;
    if (!sw) {
      statusEl.textContent = "SW is not controlling this page yet. Refresh once and try again.";
      return;
    }

    navigator.serviceWorker.addEventListener("message", (e) => {
      if (e.data && e.data.type === "CACHE_DONE") {
        statusEl.textContent = "Done ✅ Offline cache is ready. Test: Airplane Mode + open the icon.";
      }
    }, { once:true });

    sw.postMessage({ type: "CACHE_NOW", urls: EMERGENCY_URLS });
  });
})();
</script>
  </body>
</html>
