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

$uploadBaseDir = __DIR__ . '/uploads';
$galleryDir    = $uploadBaseDir . '/gallery';

// napravi foldere ako ne postoje
foreach ([$uploadBaseDir, $galleryDir] as $dir) {
  if (!is_dir($dir)) {
    @mkdir($dir, 0755, true);
  }
}

// (Apache) zabrani php u uploads + sakrij listing
$htaccess = $uploadBaseDir . '/.htaccess';
if (!file_exists($htaccess)) {
  @file_put_contents(
    $htaccess,
    "Options -Indexes\n<FilesMatch \"\\.(php|phtml|php3|php4|php5|phar)$\">\n  Deny from all\n</FilesMatch>\n"
  );
}

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

  return rtrim($destUrlPrefix, '/') . '/' . $name; // npr uploads/gallery/xxx.jpg
}

function safe_delete_local_upload(string $relativeUrl): void {
  // brisemo samo fajlove unutar admin/uploads/
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

// flash poruke (PRG)
$flashOk  = (string)($_SESSION['flash_ok'] ?? '');
$flashErr = (string)($_SESSION['flash_err'] ?? '');
unset($_SESSION['flash_ok'], $_SESSION['flash_err']);

$highlightId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// POST akcije: add_images / delete_image
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $token  = (string)($_POST['csrf'] ?? '');
  $action = (string)($_POST['action'] ?? '');

  if (!hash_equals($csrf, $token)) {
    $_SESSION['flash_err'] = 'CSRF greška. Osveži stranicu i pokušaj ponovo.';
    header('Location: edit_gallery.php' . ($highlightId > 0 ? '?id=' . $highlightId : ''));
    exit;
  }

  try {
    if ($action === 'add_images') {
      if (empty($_FILES['gallery_images']['name'][0])) {
        throw new RuntimeException('Izaberi bar jednu sliku.');
      }

      $names = $_FILES['gallery_images']['name'];
      $tmp   = $_FILES['gallery_images']['tmp_name'];
      $err   = $_FILES['gallery_images']['error'];
      $size  = $_FILES['gallery_images']['size'];

      $count = is_array($names) ? count($names) : 0;
      if ($count <= 0) {
        throw new RuntimeException('Nema fajlova.');
      }

      $stmt = $mysqli->prepare("INSERT INTO gallery (images) VALUES (?)");
      $inserted = 0;

      for ($i = 0; $i < $count; $i++) {
        $file = [
          'name' => $names[$i] ?? '',
          'tmp_name' => $tmp[$i] ?? '',
          'error' => $err[$i] ?? UPLOAD_ERR_NO_FILE,
          'size' => $size[$i] ?? 0,
        ];

        $url = save_image_upload($file, $galleryDir, 'uploads/gallery');
        $stmt->bind_param("s", $url);
        $stmt->execute();
        $inserted++;
      }

      $_SESSION['flash_ok'] = "Dodato: {$inserted} slika.";
      header('Location: edit_gallery.php');
      exit;
    }

    if ($action === 'delete_image') {
      $imgId = isset($_POST['image_id']) ? (int)$_POST['image_id'] : 0;
      if ($imgId <= 0) {
        throw new RuntimeException('Nedostaje ID slike.');
      }

      $st = $mysqli->prepare("SELECT id, images FROM gallery WHERE id = ? LIMIT 1");
      $st->bind_param("i", $imgId);
      $st->execute();
      $img = $st->get_result()->fetch_assoc();

      if (!$img) {
        throw new RuntimeException('Slika ne postoji.');
      }

      $url = (string)$img['images'];

      $del = $mysqli->prepare("DELETE FROM gallery WHERE id = ? LIMIT 1");
      $del->bind_param("i", $imgId);
      $del->execute();

      safe_delete_local_upload($url);

      $_SESSION['flash_ok'] = 'Slika je obrisana.';
      header('Location: edit_gallery.php' . ($highlightId > 0 ? '?id=' . $highlightId : ''));
      exit;
    }

    throw new RuntimeException('Nepoznata akcija.');
  } catch (Throwable $e) {
    $_SESSION['flash_err'] = $e->getMessage();
    header('Location: edit_gallery.php' . ($highlightId > 0 ? '?id=' . $highlightId : ''));
    exit;
  }
}

// fetch sve slike
$galleryRows = [];
$res = $mysqli->query("SELECT id, images FROM gallery ORDER BY id DESC");
while ($r = $res->fetch_assoc()) $galleryRows[] = $r;

// fetch highlight (opciono)
$highlight = null;
if ($highlightId > 0) {
  $st = $mysqli->prepare("SELECT id, images FROM gallery WHERE id = ? LIMIT 1");
  $st->bind_param("i", $highlightId);
  $st->execute();
  $highlight = $st->get_result()->fetch_assoc() ?: null;
}

$adminUser = (string)($_SESSION['admin_username'] ?? 'admin');
?>
<!doctype html>
<html lang="sr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gallery manager</title>

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
      max-width:1200px; margin:0 auto;
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

    .container{max-width:1200px; margin:0 auto; padding:18px;}

    .grid{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap:16px;
      align-items:start;
    }
    @media (max-width: 980px){
      .grid{grid-template-columns: 1fr;}
    }

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
    .btn-danger{
      background: rgba(177,43,43,.12);
      border-color: rgba(177,43,43,.30);
      color: var(--danger);
      box-shadow: 0 10px 18px rgba(177,43,43,.12);
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
      height:320px;
      object-fit:cover;
      display:block;
    }
    .box{
      border:1.5px solid var(--line);
      border-radius:16px;
      padding:14px;
      background: rgba(255,255,255,.55);
    }

    table{
      width:100%;
      border-collapse:separate;
      border-spacing:0;
      overflow:hidden;
      border:1.5px solid var(--line-2);
      border-radius:16px;
      background: rgba(255,255,255,.70);
    }
    th, td{
      padding:12px 12px;
      border-bottom:1.5px solid var(--line);
      vertical-align:middle;
      font-size:14px;
    }
    th{
      text-align:left;
      font-size:12px;
      letter-spacing:.3px;
      text-transform:uppercase;
      color:#3f3f3f;
      background: linear-gradient(180deg, rgba(234,232,217,.75), rgba(234,232,217,.45));
    }
    tr:last-child td{border-bottom:0}
    tbody tr:hover td{background: rgba(117,117,79,.05);}

    .thumb{
      width:64px; height:64px;
      border-radius:12px;
      object-fit:cover;
      border:1.5px solid var(--line-2);
      background:#f3f1e7;
    }
    .cell-flex{display:flex; align-items:center; gap:12px;}
    .path{color:var(--muted); font-size:12px; word-break:break-all;}
  </style>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
  <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
</head>
<body>

  <div class="topbar">
    <div class="topbar-inner">
      <div class="brand">
        <span>Gallery Manager</span>
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

    <div class="grid">

      <div class="card">
        <h2>Dodaj nove slike</h2>
        <p class="hint">Dodavanje ne briše stare slike. Možeš ubaciti više slika odjednom.</p>

        <form method="post" enctype="multipart/form-data">
          <input type="hidden" name="csrf" value="<?php echo h($csrf); ?>">
          <input type="hidden" name="action" value="add_images">

          <div style="margin-bottom:12px;">
            <label>Slike</label>
            <input type="file" name="gallery_images[]" accept="image/*" multiple required>
          </div>

          <button class="btn btn-primary" type="submit">Dodaj slike</button>
        </form>
      </div>

      <div class="card">
        <h2>Odabrana slika</h2>
        <p class="hint">Ako si došao ovde klikom na izmenu ove slike, prikazaće se baš ta slika radi brzog brisanja.</p>

        <?php if ($highlight): ?>
          <div class="layout">
            <div class="preview">
              <a href="<?php echo h((string)$highlight['images']); ?>" data-fancybox="gallery">
                <img src="<?php echo h((string)$highlight['images']); ?>" alt="gallery-<?php echo (int)$highlight['id']; ?>">
              </a>
            </div>

            <div class="box">
              <div style="margin-bottom:10px;">
                <strong>ID: <?php echo (int)$highlight['id']; ?></strong>
                <div class="path"><?php echo h((string)$highlight['images']); ?></div>
              </div>

              <form method="post" onsubmit="return confirm('Da li sigurno želiš da obrišeš ovu sliku?');" style="margin:0;">
                <input type="hidden" name="csrf" value="<?php echo h($csrf); ?>">
                <input type="hidden" name="action" value="delete_image">
                <input type="hidden" name="image_id" value="<?php echo (int)$highlight['id']; ?>">
                <button class="btn btn-danger" type="submit">Ukloni sliku</button>
              </form>
            </div>
          </div>
        <?php else: ?>
          <div class="box">
            <span class="muted">Nije izabrana nijedna slika.</span>
          </div>
        <?php endif; ?>
      </div>

    </div>

    <div style="height:16px;"></div>

    <div class="card">
      <h2>Sve slike u galeriji</h2>
      <p class="hint">Klik na thumbnail otvara galeriju. Brisanje briše i red u bazi i fajl sa diska.</p>

      <table>
        <thead>
          <tr>
            <th>Slika</th>
            <th style="width:120px;">ID</th>
            <th style="width:180px;">Akcija</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!$galleryRows): ?>
            <tr><td colspan="3" class="muted">Nema slika u galeriji.</td></tr>
          <?php else: ?>
            <?php foreach ($galleryRows as $g): ?>
              <tr>
                <td>
                  <div class="cell-flex">
                    <a href="<?php echo h((string)$g['images']); ?>" data-fancybox="gallery">
                      <img class="thumb" src="<?php echo h((string)$g['images']); ?>" alt="gallery-<?php echo (int)$g['id']; ?>">
                    </a>
                    <div class="path"><?php echo h((string)$g['images']); ?></div>
                  </div>
                </td>
                <td><strong><?php echo (int)$g['id']; ?></strong></td>
                <td>
                  <form method="post" onsubmit="return confirm('Da li sigurno želiš da obrišeš ovu sliku?');" style="margin:0;">
                    <input type="hidden" name="csrf" value="<?php echo h($csrf); ?>">
                    <input type="hidden" name="action" value="delete_image">
                    <input type="hidden" name="image_id" value="<?php echo (int)$g['id']; ?>">
                    <button class="btn btn-danger" type="submit">Ukloni</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>

</body>
</html>
