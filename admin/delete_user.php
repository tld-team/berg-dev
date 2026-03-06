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
$csrf = (string)$_SESSION['csrf'];

$id = isset($_GET['id']) ? (int)$_GET['id'] : (int)($_POST['id'] ?? 0);
if ($id <= 0) {
  http_response_code(400);
  exit('Nedostaje ID user-a.');
}

$flashOk = '';
$flashErr = '';

// Fetch user (za prikaz)
$stmt = $mysqli->prepare("SELECT id, email, first_name, last_name FROM `user` WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();

if (!$user) {
  http_response_code(404);
  exit('User nije pronađen.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $token = (string)($_POST['csrf'] ?? '');
  if (!hash_equals($csrf, $token)) {
    $flashErr = 'CSRF greška. Osveži stranicu i pokušaj ponovo.';
  } else {
    try {
      $del = $mysqli->prepare("DELETE FROM `user` WHERE id = ? LIMIT 1");
      $del->bind_param("i", $id);
      if (!$del->execute()) {
        throw new RuntimeException('Greška pri brisanju: ' . $del->error);
      }
      $flashOk = 'User je obrisan.';
    } catch (Throwable $e) {
      $flashErr = $e->getMessage();
    }
  }
}

$adminUser = (string)($_SESSION['admin_username'] ?? 'admin');
?>
<!doctype html>
<html lang="sr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Delete user</title>

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
      max-width:1200px; margin:0 auto; padding:14px 18px;
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
    .actions{display:flex; gap:10px; align-items:center; flex-wrap:wrap;}
    .muted{color:var(--muted); font-size:12px}
    .container{max-width:1200px; margin:0 auto; padding:18px;}
    .card{
      background: var(--card);
      border:1.5px solid var(--line-2);
      border-radius:18px;
      box-shadow: var(--shadow);
      padding:16px;
      max-width:720px;
    }
    h2{margin:0 0 10px 0; font-size:16px;}
    .hint{margin:0 0 14px 0; color: var(--muted); font-size:13px; line-height:1.45;}
    .flash{
      margin: 0 0 14px 0;
      padding:10px 12px;
      border-radius:12px;
      font-size:14px;
      border:1.5px solid var(--line-2);
      background: rgba(251,250,244,.9);
      box-shadow: 0 8px 18px rgba(0,0,0,.05);
    }
    .flash.ok{border-color: rgba(18,140,72,.30); background: rgba(18,140,72,.08); color: #0f5c31;}
    .flash.err{border-color: rgba(177,43,43,.30); background: rgba(177,43,43,.08); color: #7a1b1b;}

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
      background: rgba(177,43,43,.10);
      border-color: rgba(177,43,43,.28);
      color: #8b1f1f;
      box-shadow: 0 10px 18px rgba(177,43,43,.10);
    }
    .btn-primary{
      background: linear-gradient(180deg, rgba(117,117,79,.98), rgba(96,96,60,.98));
      border-color: rgba(90,90,55,.85);
      color:#fff;
      box-shadow: 0 14px 22px rgba(117,117,79,.25);
    }
  </style>
</head>
<body>
  <div class="topbar">
    <div class="topbar-inner">
      <div class="brand">
        <span>Delete user</span>
        <span class="pill">bergmembership.com</span>
      </div>
      <div class="actions">
        <span class="muted">Ulogovan: <strong><?php echo h($adminUser); ?></strong></span>
        <a class="btn" href="admin.php">Nazad</a>
        <a class="btn btn-danger" href="loglout.php">Log out</a>
      </div>
    </div>
  </div>

  <div class="container">
    <?php if ($flashOk): ?>
      <div class="flash ok"><?php echo h($flashOk); ?></div>
      <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <a class="btn btn-primary" href="admin.php">Nazad na admin</a>
      </div>
    <?php else: ?>
      <?php if ($flashErr): ?><div class="flash err"><?php echo h($flashErr); ?></div><?php endif; ?>

      <div class="card">
        <h2>Potvrdi brisanje</h2>
        <p class="hint">
          Brišeš user-a:
          <strong>#<?php echo (int)$user['id']; ?></strong>,
          <strong><?php echo h((string)$user['email']); ?></strong>
          (<?php echo h(trim((string)$user['first_name'] . ' ' . (string)$user['last_name'])); ?>)
        </p>

        <form method="post">
          <input type="hidden" name="csrf" value="<?php echo h($csrf); ?>">
          <input type="hidden" name="id" value="<?php echo (int)$user['id']; ?>">

          <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <button type="submit" class="btn btn-danger" onclick="return confirm('Da li si siguran?');">
              Da, obriši
            </button>
            <a class="btn" href="edit_user.php?id=<?php echo (int)$user['id']; ?>">Nazad na edit</a>
            <a class="btn" href="admin.php">Odustani</a>
          </div>
        </form>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
