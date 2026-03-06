<?php
declare(strict_types=1);

session_start();
require __DIR__ . '/db.php';

function h(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

if (empty($_SESSION['admin_id'])) {
  header('Location: login.php');
  exit;
}

if (empty($_SESSION['csrf'])) {
  $_SESSION['csrf'] = bin2hex(random_bytes(32));
}
$csrf = $_SESSION['csrf'];

function safe_delete_local_upload(string $relativeUrl): void {
  $relativeUrl = ltrim($relativeUrl, '/');
  if (strpos($relativeUrl, 'uploads/') !== 0) return;

  $base = realpath(__DIR__ . '/uploads');
  if ($base === false) return;

  $target = realpath(__DIR__ . '/' . $relativeUrl);
  if ($target === false) return;

  if (strpos($target, $base) !== 0) return;

  if (is_file($target)) {
    @unlink($target);
  }
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
  http_response_code(400);
  exit('Nedostaje ID.');
}

$stmt = $mysqli->prepare("SELECT id, subject, main_image FROM blog WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) {
  http_response_code(404);
  exit('Blog post ne postoji.');
}

$flashErr = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $token = (string)($_POST['csrf'] ?? '');
  $confirm = (string)($_POST['confirm'] ?? '');

  if (!hash_equals($csrf, $token)) {
    $flashErr = 'CSRF greška. Osveži stranicu i pokušaj ponovo.';
  } elseif ($confirm !== 'yes') {
    header('Location: admin.php');
    exit;
  } else {
    // obrisati iz baze + fajl
    $img = (string)$post['main_image'];

    $del = $mysqli->prepare("DELETE FROM blog WHERE id = ? LIMIT 1");
    $del->bind_param("i", $id);
    $del->execute();

    safe_delete_local_upload($img);

    header('Location: admin.php');
    exit;
  }
}

$adminUser = (string)($_SESSION['admin_username'] ?? 'admin');
?>
<!doctype html>
<html lang="sr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Delete blog</title>

  <style>
    :root{
      --primary:#75754f;
      --accent:#eae8d9;
      --bg-1:#ece7d6;
      --bg-2:#dad4bd;
      --card:#fbfaf4;
      --text:#1f1f1f;
      --muted:#5f5f5f;

      --line:#c7c0a4;
      --line-2:#b4ad8d;
      --shadow: 0 12px 28px rgba(0,0,0,.08);

      --danger:#8b1f1f;
    }
    *{box-sizing:border-box}
    body{
      margin:0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial;
      color:var(--text);
      background:
        radial-gradient(900px 500px at 15% 0%, rgba(117,117,79,.35), transparent 60%),
        radial-gradient(900px 500px at 85% 10%, rgba(234,232,217,.60), transparent 60%),
        linear-gradient(180deg, var(--bg-1), var(--bg-2));
      min-height:100vh;
    }
    .topbar{
      position:sticky; top:0; z-index:10;
      background: rgba(117,117,79,.14);
      backdrop-filter: blur(10px);
      border-bottom: 1.5px solid var(--line-2);
      box-shadow: 0 8px 18px rgba(0,0,0,.06);
    }
    .topbar-inner{
      max-width:900px; margin:0 auto;
      padding:14px 18px;
      display:flex; align-items:center; justify-content:space-between; gap:12px;
    }
    .brand{display:flex; align-items:center; gap:10px; font-weight:800;}
    .pill{
      font-size:12px; padding:6px 10px; border-radius:999px;
      background: rgba(234,232,217,.85);
      color: var(--primary);
      border:1.5px solid var(--line-2);
      font-weight:700;
    }
    .actions{display:flex; gap:10px; align-items:center}
    .muted{color:var(--muted); font-size:12px}

    .container{max-width:900px; margin:0 auto; padding:18px;}
    .card{
      background: var(--card);
      border:1.5px solid var(--line-2);
      border-radius:18px;
      box-shadow: var(--shadow);
      padding:16px;
    }
    h2{margin:0 0 10px 0; font-size:16px}
    .hint{margin:0 0 14px 0; color:var(--muted); font-size:13px; line-height:1.45}

    .flash{
      margin: 0 0 14px 0;
      padding:10px 12px;
      border-radius:12px;
      font-size:14px;
      border:1.5px solid rgba(177,43,43,.30);
      background: rgba(177,43,43,.08);
      color: #7a1b1b;
      box-shadow: 0 8px 18px rgba(0,0,0,.05);
    }

    .btn{
      border:1.5px solid var(--line-2);
      background: rgba(255,255,255,.85);
      padding:10px 12px;
      border-radius:12px;
      cursor:pointer;
      font-weight:700;
      font-size:13px;
      color:#222;
      text-decoration:none;
      display:inline-flex;
      align-items:center;
      gap:8px;
      box-shadow: 0 10px 18px rgba(0,0,0,.06);
      transition: transform .05s ease, filter .15s ease;
    }
    .btn:hover{filter:brightness(.98)}
    .btn:active{transform: translateY(1px)}
    .btn-danger{
      background: rgba(177,43,43,.12);
      border-color: rgba(177,43,43,.30);
      color: var(--danger);
      box-shadow: 0 10px 18px rgba(177,43,43,.12);
    }
    .btn-primary{
      background: linear-gradient(180deg, rgba(117,117,79,.98), rgba(96,96,60,.98));
      border-color: rgba(90,90,55,.85);
      color:#fff;
      box-shadow: 0 14px 22px rgba(117,117,79,.25);
    }

    .box{
      border:1.5px solid var(--line);
      border-radius:16px;
      padding:14px;
      background: rgba(255,255,255,.55);
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
      flex-wrap:wrap;
    }
    .meta strong{display:block}
    .meta span{color:var(--muted); font-size:13px}
  </style>
</head>
<body>

  <div class="topbar">
    <div class="topbar-inner">
      <div class="brand">
        <span>Delete Blog</span>
        <span class="pill">bergmembership.com</span>
      </div>
      <div class="actions">
        <span class="muted">Ulogovan: <strong><?php echo h($adminUser); ?></strong></span>
        <a class="btn" href="admin.php">Nazad</a>
        <a class="btn" href="loglout.php">Log out</a>
      </div>
    </div>
  </div>

  <div class="container">
    <?php if ($flashErr): ?><div class="flash"><?php echo h($flashErr); ?></div><?php endif; ?>

    <div class="card">
      <h2>Potvrda brisanja</h2>
      <p class="hint">Ovo će obrisati blog post iz baze. Ako je slika sačuvana lokalno u <code>admin/uploads/</code>, biće obrisana i sa diska.</p>

      <div class="box">
        <div class="meta">
          <strong>ID: <?php echo (int)$post['id']; ?></strong>
          <span>Naslov: <?php echo h((string)$post['subject']); ?></span>
        </div>

        <form method="post" style="display:flex; gap:10px; flex-wrap:wrap; margin:0;">
          <input type="hidden" name="csrf" value="<?php echo h($csrf); ?>">
          <button class="btn" type="submit" name="confirm" value="no">Odustani</button>
          <button class="btn btn-danger" type="submit" name="confirm" value="yes">Ukloni</button>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
