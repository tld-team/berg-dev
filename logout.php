<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

// Bezbedan redirect (samo lokalne putanje)
function safe_next(string $fallback = 'index.php'): string {
  $next = (string)($_GET['next'] ?? '');
  $next = trim($next);

  if ($next !== '' && strpos($next, '://') === false && str_starts_with($next, '/')) {
    return $next;
  }

  // fallback na referer ako je isti host
  $ref = (string)($_SERVER['HTTP_REFERER'] ?? '');
  if ($ref !== '') {
    $parts = parse_url($ref);
    $host = (string)($parts['host'] ?? '');
    $myHost = (string)($_SERVER['HTTP_HOST'] ?? '');
    if ($host !== '' && $myHost !== '' && strcasecmp($host, $myHost) === 0) {
      $path = (string)($parts['path'] ?? '');
      $q = isset($parts['query']) ? ('?' . $parts['query']) : '';
      if ($path !== '') return $path . $q;
    }
  }

  return $fallback;
}

// Očisti sesiju
$_SESSION = [];

if (ini_get('session.use_cookies')) {
  $params = session_get_cookie_params();
  setcookie(session_name(), '', time() - 42000,
    $params['path'] ?? '/',
    $params['domain'] ?? '',
    (bool)($params['secure'] ?? false),
    (bool)($params['httponly'] ?? true)
  );
}

session_destroy();

header('Location: ' . safe_next('index.php'));
exit;
