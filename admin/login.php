<?php
declare(strict_types=1);

session_start();

// Ako je vec ulogovan, prebaci na admin
if (!empty($_SESSION['admin_id'])) {
  header('Location: admin.php');
  exit;
}

require __DIR__ . '/db.php';

function h(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim((string)($_POST['username'] ?? ''));
  $password = (string)($_POST['password'] ?? '');

  if ($username === '' || $password === '') {
    $err = 'Unesi username i password.';
  } else {
    $stmt = $mysqli->prepare("SELECT id, username, password FROM admin WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

    $ok = false;

    if ($row) {
      $stored = (string)$row['password'];

      // Podrzava hash (preporuceno), ali i fallback ako je u bazi plaintext (pa ga automatski prehashuje).
      if (password_verify($password, $stored)) {
        $ok = true;
      } elseif (hash_equals($stored, $password)) {
        // fallback za slucaj da si upisao plaintext u bazu
        $ok = true;

        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $up = $mysqli->prepare("UPDATE admin SET password = ? WHERE id = ? LIMIT 1");
        $up->bind_param("si", $newHash, $row['id']);
        $up->execute();
      }
    }

    if ($ok) {
      session_regenerate_id(true);
      $_SESSION['admin_id'] = (int)$row['id'];
      $_SESSION['admin_username'] = (string)$row['username'];
      header('Location: admin.php');
      exit;
    } else {
      $err = 'Pogrešan username ili password.';
    }
  }
}
?>
<!doctype html>
<html lang="sr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login</title>
  <style>
    :root{
      --primary:#75754f;
      --accent:#eae8d9;
      --bg-1:#ece7d6;
      --bg-2:#dad4bd;
      --card:#fbfaf4;
      --muted:#5f5f5f;
      --line:#c7c0a4;
      --line-2:#b4ad8d;
    }
    *{box-sizing:border-box}
    body{
      margin:0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial, "Apple Color Emoji","Segoe UI Emoji";
      background:
        radial-gradient(900px 500px at 15% 0%, rgba(117,117,79,.35), transparent 60%),
        radial-gradient(900px 500px at 85% 10%, rgba(234,232,217,.60), transparent 60%),
        linear-gradient(180deg, var(--bg-1), var(--bg-2));
      color:#1d1d1d;
      min-height:100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:24px;
    }
    .wrap{
      width:100%;
      max-width:420px;
    }
    .card{
      background:var(--card);
      border:1.5px solid var(--line-2);
      border-radius:18px;
      box-shadow: 0 12px 28px rgba(0,0,0,.08);
      padding:22px;
    }

    .logo-wrap{
      display:flex;
      justify-content:center;
      align-items:center;
      margin-bottom:14px;
    }
    .logo-wrap img{
      max-width: 220px;
      width: 70%;
      height: auto;
      display:block;
      filter: drop-shadow(0 10px 18px rgba(0,0,0,.08));
    }

    h1{
      margin:0 0 8px 0;
      font-size:20px;
      letter-spacing:.2px;
      text-align:center;
    }
    p{
      margin:0 0 18px 0;
      color:var(--muted);
      font-size:14px;
      line-height:1.4;
      text-align:center;
    }
    .field{margin-bottom:12px}
    label{
      display:block;
      font-size:13px;
      color:#3a3a3a;
      margin:0 0 6px 0;
      font-weight:600;
    }
    input{
      width:100%;
      padding:12px 12px;
      border:1.5px solid var(--line);
      border-radius:12px;
      outline:none;
      background:rgba(255,255,255,.75);
      font-size:14px;
    }
    input:focus{
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(117,117,79,.18);
      background:rgba(255,255,255,.9);
    }
    .btn{
      width:100%;
      border:0;
      background: linear-gradient(180deg, rgba(117,117,79,.98), rgba(96,96,60,.98));
      color:#fff;
      padding:12px 14px;
      border-radius:12px;
      cursor:pointer;
      font-weight:700;
      font-size:14px;
      box-shadow: 0 14px 22px rgba(117,117,79,.25);
    }
    .btn:hover{filter:brightness(.97)}
    .err{
      background: rgba(180, 30, 30, .08);
      border: 1.5px solid rgba(180, 30, 30, .20);
      color:#7a1b1b;
      padding:10px 12px;
      border-radius:12px;
      margin-bottom:12px;
      font-size:14px;
    }
    .brand{
      text-align:center;
      font-size:12px;
      color:var(--muted);
      margin-top:12px;
    }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="card">

      <div class="logo-wrap">
        <img src="logo.svg" alt="Logo" style="border-radius: 20px;">
      </div>

      <h1>Berg Membership</h1>
      <p>Dobrodošli na Berg Membership admin panel.</p>

      <?php if ($err): ?>
        <div class="err"><?php echo h($err); ?></div>
      <?php endif; ?>

      <form method="post" autocomplete="off">
        <div class="field">
          <label for="username">Username</label>
          <input id="username" name="username" type="text" required>
        </div>
        <div class="field">
          <label for="password">Password</label>
          <input id="password" name="password" type="password" required>
        </div>
        <button class="btn" type="submit">Login</button>
      </form>
    </div>

    <div class="brand">bergmembership.com</div>
  </div>
</body>
</html>
