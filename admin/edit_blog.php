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

function save_image_upload(array $file, string $destDir, string $destUrlPrefix, int $maxBytes = 10000000): string {
  if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
    throw new RuntimeException('Upload nije validan.');
  }
  if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
    throw new RuntimeException('Greška pri uploadu.');
  }
  if (($file['size'] ?? 0) <= 0 || ($file['size'] ?? 0) > $maxBytes) {
    throw new RuntimeException('Fajl je prevelik ili neispravan.');
  }

  $info = @getimagesize($file['tmp_name']);
  if ($info === false) {
    throw new RuntimeException('Fajl nije slika.');
  }

  $mime = (string)($info['mime'] ?? '');
  $allowed = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp',
    'image/gif'  => 'gif',
  ];
  if (!isset($allowed[$mime])) {
    throw new RuntimeException('Nepodržan format slike.');
  }

  $ext = $allowed[$mime];
  $name = bin2hex(random_bytes(16)) . '.' . $ext;

  if (!is_dir($destDir)) {
    @mkdir($destDir, 0755, true);
  }

  $destPath = rtrim($destDir, '/\\') . DIRECTORY_SEPARATOR . $name;
  if (!move_uploaded_file($file['tmp_name'], $destPath)) {
    throw new RuntimeException('Ne mogu da sačuvam fajl.');
  }

  return rtrim($destUrlPrefix, '/') . '/' . $name;
}

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

$stmt = $mysqli->prepare("SELECT id, subject, text, main_image FROM blog WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) {
  http_response_code(404);
  exit('Blog post ne postoji.');
}

$flashOk = '';
$flashErr = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $token = (string)($_POST['csrf'] ?? '');
  if (!hash_equals($csrf, $token)) {
    $flashErr = 'CSRF greška. Osveži stranicu i pokušaj ponovo.';
  } else {
    try {
      $subject = trim((string)($_POST['subject'] ?? ''));
      $text    = trim((string)($_POST['text'] ?? ''));

      if ($subject === '' || $text === '') {
        throw new RuntimeException('Naslov i tekst su obavezni.');
      }

      $newImageUrl = (string)$post['main_image'];
      $oldImageUrl = (string)$post['main_image'];

      $hasNewImage = !empty($_FILES['main_image']['tmp_name']) && is_uploaded_file($_FILES['main_image']['tmp_name']);
      if ($hasNewImage) {
        $uploadDir = __DIR__ . '/uploads/blog';
        $newImageUrl = save_image_upload($_FILES['main_image'], $uploadDir, 'uploads/blog');
      }

      $up = $mysqli->prepare("UPDATE blog SET subject = ?, text = ?, main_image = ? WHERE id = ? LIMIT 1");
      $up->bind_param("sssi", $subject, $text, $newImageUrl, $id);
      $up->execute();

      if ($hasNewImage && $oldImageUrl !== $newImageUrl) {
        safe_delete_local_upload($oldImageUrl);
      }

      $post['subject'] = $subject;
      $post['text'] = $text;
      $post['main_image'] = $newImageUrl;

      $flashOk = 'Blog post je uspešno izmenjen.';
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
  <title>Edit blog</title>

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
      max-width:1100px; margin:0 auto;
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

    .container{max-width:1100px; margin:0 auto; padding:18px;}

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
      border:1.5px solid var(--line-2);
      background: rgba(251,250,244,.9);
      box-shadow: 0 8px 18px rgba(0,0,0,.05);
    }
    .flash.ok{border-color: rgba(18,140,72,.30); background: rgba(18,140,72,.08); color:#0f5c31;}
    .flash.err{border-color: rgba(177,43,43,.30); background: rgba(177,43,43,.08); color:#7a1b1b;}

    label{display:block; font-size:13px; margin:0 0 6px 0; color:#333; font-weight:600;}
    input[type="text"], textarea{
      width:100%;
      padding:11px 12px;
      border:1.5px solid var(--line);
      border-radius:12px;
      outline:none;
      font-size:14px;
      background: rgba(255,255,255,.65);
    }
    textarea{min-height:220px; resize:vertical}
    input:focus, textarea:focus{
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(117,117,79,.18);
      background: rgba(255,255,255,.85);
    }
    input[type="file"]{
      width:100%;
      padding:10px;
      border:1.5px dashed rgba(117,117,79,.55);
      border-radius:12px;
      background: rgba(234,232,217,.55);
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
    .btn-primary{
      background: linear-gradient(180deg, rgba(117,117,79,.98), rgba(96,96,60,.98));
      border-color: rgba(90,90,55,.85);
      color:#fff;
      box-shadow: 0 14px 22px rgba(117,117,79,.25);
    }

    .layout{
      display:grid;
      grid-template-columns: 360px 1fr;
      gap:16px;
      align-items:start;
    }
    @media (max-width: 900px){
      .layout{grid-template-columns: 1fr;}
    }

    .preview{
      width:100%;
      border-radius:16px;
      border:1.5px solid var(--line-2);
      overflow:hidden;
      background: rgba(255,255,255,.6);
    }
    .preview img{
      width:100%;
      height:260px;
      object-fit:cover;
      display:block;
    }
    .box{border:1.5px solid var(--line); border-radius:16px; padding:14px; background: rgba(255,255,255,.55);}
    .row{display:grid; grid-template-columns:1fr; gap:12px}
  </style>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
  <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
</head>
<body>

  <div class="topbar">
    <div class="topbar-inner">
      <div class="brand">
        <span>Edit Blog</span>
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
    <?php if ($flashOk): ?><div class="flash ok"><?php echo h($flashOk); ?></div><?php endif; ?>
    <?php if ($flashErr): ?><div class="flash err"><?php echo h($flashErr); ?></div><?php endif; ?>

    <div class="card">
      <h2>Izmeni blog (ID: <?php echo (int)$post['id']; ?>)</h2>
      <p class="hint">Možeš izmeniti naslov i tekst. Slika je opcionalna, uploaduj novu samo ako želiš zamenu (stara će se obrisati ako je lokalno sačuvana).</p>

      <div class="layout">
        <div class="preview">
          <a href="<?php echo h((string)$post['main_image']); ?>" data-fancybox="blogimg">
            <img src="<?php echo h((string)$post['main_image']); ?>" alt="blog-<?php echo (int)$post['id']; ?>">
          </a>
        </div>

        <div class="box">
          <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf" value="<?php echo h($csrf); ?>">

            <div class="row">
              <div>
                <label>Naslov (subject)</label>
                <input type="text" name="subject" value="<?php echo h((string)$post['subject']); ?>" required>
              </div>

              <div>
                <label>Tekst (text)</label>
                <textarea name="text" required><?php echo h((string)$post['text']); ?></textarea>
              </div>

              <div>
                <label>Nova glavna slika (opciono)</label>
                <input type="file" name="main_image" accept="image/*">
              </div>

              <div>
                <button class="btn btn-primary" type="submit">Sačuvaj izmene</button>
              </div>
            </div>
          </form>

          <div style="margin-top:12px;" class="muted">
            Trenutna putanja: <?php echo h((string)$post['main_image']); ?>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
