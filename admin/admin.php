<?php
declare(strict_types=1);

session_start();
require __DIR__ . '/db.php';

function h(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function is_https(): bool {
  return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || ((int)($_SERVER['SERVER_PORT'] ?? 0) === 443);
}

// Osnovna zastita za session cookie (nece nista pokvariti ako je vec poslato, ali idealno je na pocetku)
if (PHP_VERSION_ID >= 70300) {
  $params = session_get_cookie_params();
  setcookie(session_name(), session_id(), [
    'expires'  => 0,
    'path'     => $params['path'] ?? '/',
    'domain'   => $params['domain'] ?? '',
    'secure'   => is_https(),
    'httponly' => true,
    'samesite' => 'Lax',
  ]);
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
$blogDir       = $uploadBaseDir . '/blog';
$cardsDir      = $uploadBaseDir . '/cards';


foreach ([$uploadBaseDir, $galleryDir, $blogDir, $cardsDir] as $dir) {
  if (!is_dir($dir)) {
    @mkdir($dir, 0755, true);
  }
}

// Preporuceno: zabrani izvrsavanje .php u uploads (ako si na Apache)
$htaccess = $uploadBaseDir . '/.htaccess';
if (!file_exists($htaccess)) {
  @file_put_contents($htaccess, "Options -Indexes\n<FilesMatch \"\\.(php|phtml|php3|php4|php5|phar)$\">\n  Deny from all\n</FilesMatch>\n");
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

  $destPath = rtrim($destDir, '/\\') . DIRECTORY_SEPARATOR . $name;
  if (!move_uploaded_file($file['tmp_name'], $destPath)) {
    throw new RuntimeException('Ne mogu da sačuvam fajl.');
  }

  return rtrim($destUrlPrefix, '/') . '/' . $name; // npr uploads/gallery/xxx.jpg
}


function save_pdf_upload(array $file, string $destDir, string $destUrlPrefix, int $maxBytes = 20000000): string {
  if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
    throw new RuntimeException('Upload nije validan.');
  }
  if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
    throw new RuntimeException('Greška pri uploadu.');
  }
  if (($file['size'] ?? 0) <= 0 || ($file['size'] ?? 0) > $maxBytes) {
    throw new RuntimeException('PDF je prevelik ili neispravan.');
  }

  // MIME check (real file type)
  $finfo = new finfo(FILEINFO_MIME_TYPE);
  $mime = (string)$finfo->file($file['tmp_name']);
  if ($mime !== 'application/pdf') {
    throw new RuntimeException('Fajl mora biti PDF.');
  }

  $name = bin2hex(random_bytes(16)) . '.pdf';
  $destPath = rtrim($destDir, '/\\') . DIRECTORY_SEPARATOR . $name;

  if (!move_uploaded_file($file['tmp_name'], $destPath)) {
    throw new RuntimeException('Ne mogu da sačuvam PDF.');
  }

  return rtrim($destUrlPrefix, '/') . '/' . $name; // npr: uploads/cards/xxx.pdf
}






$flashOk = '';
$flashErr = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $token = (string)($_POST['csrf'] ?? '');
  if (!hash_equals($csrf, $token)) {
    $flashErr = 'CSRF greška. Osveži stranicu i pokušaj ponovo.';
  } else {
    $action = (string)($_POST['action'] ?? '');

    try {
        
        if ($action === 'upload_card') {
  $uid = (int)($_POST['user_id'] ?? 0);
  if ($uid <= 0) {
    throw new RuntimeException('Pogrešan user ID.');
  }
  if (empty($_FILES['card_pdf']['tmp_name'])) {
    throw new RuntimeException('Izaberi PDF.');
  }

  $url = save_pdf_upload($_FILES['card_pdf'], $cardsDir, 'uploads/cards');

  $stmt = $mysqli->prepare("UPDATE `user` SET card = ? WHERE id = ? LIMIT 1");
  $stmt->bind_param("si", $url, $uid);
  if (!$stmt->execute()) {
    throw new RuntimeException('Greška pri upisu u bazu: ' . $stmt->error);
  }

  $flashOk = 'Card PDF je uploadovan.';
}

        
        
      if ($action === 'add_gallery') {
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

        $flashOk = "Dodato u galeriju: {$inserted} slika.";
      }
      
            
            if ($action === 'add_user') {
        $email    = trim((string)($_POST['u_email'] ?? ''));
        $password = (string)($_POST['u_password'] ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          throw new RuntimeException('Email nije validan.');
        }
        if (strlen($password) < 6) {
          throw new RuntimeException('Password mora imati bar 6 karaktera.');
        }

        // ostala polja (sva su opcionalna osim email/pass)
        $selected_plan   = trim((string)($_POST['selected_plan'] ?? ''));
        $selected_option = trim((string)($_POST['selected_option'] ?? ''));

        $first_name = trim((string)($_POST['first_name'] ?? ''));
        $last_name  = trim((string)($_POST['last_name'] ?? ''));

        $birth_year  = (int)($_POST['birth_year'] ?? 0);
        $birth_month = trim((string)($_POST['birth_month'] ?? ''));
        $birth_day   = (int)($_POST['birth_day'] ?? 0);
        $gender      = trim((string)($_POST['gender'] ?? ''));

        $partner_first_name = trim((string)($_POST['partner_first_name'] ?? ''));
        $partner_last_name  = trim((string)($_POST['partner_last_name'] ?? ''));
        $partner_birth_year  = (int)($_POST['partner_birth_year'] ?? 0);
        $partner_birth_month = trim((string)($_POST['partner_birth_month'] ?? ''));
        $partner_birth_day   = (int)($_POST['partner_birth_day'] ?? 0);
        $partner_gender      = trim((string)($_POST['partner_gender'] ?? ''));

        $phone        = trim((string)($_POST['phone'] ?? ''));
        $street       = trim((string)($_POST['street'] ?? ''));
        $house_number = trim((string)($_POST['house_number'] ?? ''));
        $city         = trim((string)($_POST['city'] ?? ''));
        $zip          = trim((string)($_POST['zip'] ?? ''));
        $country      = trim((string)($_POST['country'] ?? ''));

        // Children -> JSON iz array polja
        $children = [];
        $child_category   = $_POST['child_category'] ?? [];
        $child_first_name = $_POST['child_first_name'] ?? [];
        $child_last_name  = $_POST['child_last_name'] ?? [];
        $child_birth_year = $_POST['child_birth_year'] ?? [];
        $child_birth_month= $_POST['child_birth_month'] ?? [];
        $child_birth_day  = $_POST['child_birth_day'] ?? [];
        $child_gender     = $_POST['child_gender'] ?? [];

        $count = is_array($child_first_name) ? count($child_first_name) : 0;
        for ($i = 0; $i < $count; $i++) {
          $fn = trim((string)($child_first_name[$i] ?? ''));
          $ln = trim((string)($child_last_name[$i] ?? ''));
          if ($fn === '' && $ln === '') continue;

          $children[] = [
            'category'   => (string)($child_category[$i] ?? ''),
            'first_name' => $fn,
            'last_name'  => $ln,
            'birth_year' => (string)($child_birth_year[$i] ?? ''),
            'birth_month'=> (string)($child_birth_month[$i] ?? ''),
            'birth_day'  => (string)($child_birth_day[$i] ?? ''),
            'gender'     => (string)($child_gender[$i] ?? ''),
          ];
        }

        $children_json = $children ? json_encode($children, JSON_UNESCAPED_UNICODE) : null;

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $mysqli->prepare("
          INSERT INTO `user`
          (email, password, selected_plan, selected_option,
           first_name, last_name, birth_year, birth_month, birth_day, gender,
           partner_first_name, partner_last_name, partner_birth_year, partner_birth_month, partner_birth_day, partner_gender,
           children_json, phone, street, house_number, city, zip, country)
          VALUES
          (?, ?, ?, ?,
           ?, ?, ?, ?, ?, ?,
           ?, ?, ?, ?, ?, ?,
           ?, ?, ?, ?, ?, ?, ?)
        ");

        $by  = ($birth_year > 0) ? $birth_year : null;
        $bd  = ($birth_day > 0) ? $birth_day : null;
        $pby = ($partner_birth_year > 0) ? $partner_birth_year : null;
        $pbd = ($partner_birth_day > 0) ? $partner_birth_day : null;

        $stmt->bind_param(
          "ssssssisssssissssssssss",
          $email, $hash, $selected_plan, $selected_option,
          $first_name, $last_name, $by, $birth_month, $bd, $gender,
          $partner_first_name, $partner_last_name, $pby, $partner_birth_month, $pbd, $partner_gender,
          $children_json, $phone, $street, $house_number, $city, $zip, $country
        );

        if (!$stmt->execute()) {
          if ((int)$stmt->errno === 1062) {
            throw new RuntimeException('User sa ovim email-om već postoji.');
          }
          throw new RuntimeException('Greška pri upisu user-a: ' . $stmt->error);
        }

        $flashOk = 'User je kreiran.';
      }

      
      

      if ($action === 'add_blog') {
        $subject = trim((string)($_POST['subject'] ?? ''));
        $text    = trim((string)($_POST['text'] ?? ''));

        if ($subject === '' || $text === '') {
          throw new RuntimeException('Naslov i tekst su obavezni.');
        }
        if (empty($_FILES['main_image']['tmp_name'])) {
          throw new RuntimeException('Glavna slika je obavezna.');
        }

        $imgUrl = save_image_upload($_FILES['main_image'], $blogDir, 'uploads/blog');

        $stmt = $mysqli->prepare("INSERT INTO blog (subject, text, main_image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $subject, $text, $imgUrl);
        $stmt->execute();

        $flashOk = 'Blog post je dodat.';
      }
    } catch (Throwable $e) {
      $flashErr = $e->getMessage();
    }
  }
}

// Fetch liste
$galleryRows = [];
$blogRows = [];

$resG = $mysqli->query("SELECT id, images FROM gallery ORDER BY id DESC");
while ($r = $resG->fetch_assoc()) $galleryRows[] = $r;

$resB = $mysqli->query("SELECT id, subject FROM blog ORDER BY id DESC");
while ($r = $resB->fetch_assoc()) $blogRows[] = $r;

$userRows = [];
$resU = $mysqli->query("SELECT id, email, first_name, last_name, selected_plan, selected_option, card, created_at FROM `user` ORDER BY id DESC");
while ($r = $resU->fetch_assoc()) $userRows[] = $r;


$adminUser = (string)($_SESSION['admin_username'] ?? 'admin');
?>
<!doctype html>
<html lang="sr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel</title>

  <style>
  :root{
    --primary:#75754f;      /* dominant */
    --accent:#eae8d9;       /* secondary */
    --bg-1:#ece7d6;         /* background tint */
    --bg-2:#dad4bd;         /* background tint darker */
    --card:#fbfaf4;         /* not pure white */
    --text:#1f1f1f;
    --muted:#5f5f5f;

    --line:#c7c0a4;         /* stronger borders */
    --line-2:#b4ad8d;       /* even stronger borders */
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
    position:sticky;
    top:0;
    z-index:10;
    background: rgba(117,117,79,.14);
    backdrop-filter: blur(10px);
    border-bottom: 1.5px solid var(--line-2);
    box-shadow: 0 8px 18px rgba(0,0,0,.06);
  }

  .topbar-inner{
    max-width:1200px;
    margin:0 auto;
    padding:14px 18px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
  }

  .brand{
    display:flex;
    align-items:center;
    gap:10px;
    font-weight:800;
    letter-spacing:.2px;
  }

  .pill{
    font-size:12px;
    padding:6px 10px;
    border-radius:999px;
    background: rgba(234,232,217,.85);
    color: var(--primary);
    border:1.5px solid var(--line-2);
    font-weight:700;
  }

  .actions{
    display:flex;
    gap:10px;
    align-items:center;
  }

  .container{
    max-width:1200px;
    margin:0 auto;
    padding:18px;
  }

  .grid{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap:16px;
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

  .card h2{
    margin:0 0 10px 0;
    font-size:16px;
  }

  .hint{
    margin:0 0 14px 0;
    color: var(--muted);
    font-size:13px;
    line-height:1.45;
  }

  .muted{color:var(--muted); font-size:12px}

  .flash{
    margin: 0 0 14px 0;
    padding:10px 12px;
    border-radius:12px;
    font-size:14px;
    border:1.5px solid var(--line-2);
    background: rgba(251,250,244,.9);
    box-shadow: 0 8px 18px rgba(0,0,0,.05);
  }
  .flash.ok{
    border-color: rgba(18,140,72,.30);
    background: rgba(18,140,72,.08);
    color: #0f5c31;
  }
  .flash.err{
    border-color: rgba(177,43,43,.30);
    background: rgba(177,43,43,.08);
    color: #7a1b1b;
  }

  label{
    display:block;
    font-size:13px;
    margin:0 0 6px 0;
    color:#333;
    font-weight:600;
  }

  input[type="text"],
input[type="email"],
input[type="password"],
input[type="number"],
input[type="tel"],
textarea,
select{
  width:100%;
  padding:11px 12px;
  border:1.5px solid var(--line);
  border-radius:12px;
  outline:none;
  font-size:14px;
  background: rgba(255,255,255,.65);
}

select{appearance:auto;}

.child-card{
  border:1.5px solid var(--line-2);
  border-radius:14px;
  padding:12px;
  background: rgba(255,255,255,.55);
}
.child-head{
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:10px;
  margin-bottom:10px;
}
.child-remove{
  border:1.5px solid rgba(177,43,43,.28);
  background: rgba(177,43,43,.10);
  color:#8b1f1f;
  width:34px;
  height:34px;
  border-radius:10px;
  cursor:pointer;
  font-weight:900;
  line-height:1;
}






  textarea{min-height:120px; resize:vertical}

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

  .row{display:grid; grid-template-columns:1fr; gap:12px}
  .row2{display:grid; grid-template-columns:1fr 1fr; gap:12px}
  @media (max-width: 780px){
    .row2{grid-template-columns:1fr;}
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
    background: rgba(177,43,43,.10);
    border-color: rgba(177,43,43,.28);
    color: #8b1f1f;
    box-shadow: 0 10px 18px rgba(177,43,43,.10);
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
    width:64px;
    height:64px;
    border-radius:12px;
    object-fit:cover;
    border:1.5px solid var(--line-2);
    background:#f3f1e7;
  }

  .cell-flex{
    display:flex;
    align-items:center;
    gap:12px;
  }

  .footer-space{height:18px}
</style>

</head>
<body>

  <div class="topbar">
    <div class="topbar-inner">
      <div class="brand">
        <span>Admin Panel</span>
        <span class="pill">bergmembership.com</span>
      </div>
      <div class="actions">
        <span class="muted">Ulogovan: <strong><?php echo h($adminUser); ?></strong></span>
        <a class="btn btn-danger" href="loglout.php">Log out</a>
      </div>
    </div>
  </div>

  <div class="container">

    <?php if ($flashOk): ?>
      <div class="flash ok"><?php echo h($flashOk); ?></div>
    <?php elseif ($flashErr): ?>
      <div class="flash err"><?php echo h($flashErr); ?></div>
    <?php endif; ?>

    <div class="grid">
      <div class="card">
        <h2>Dodaj slike u galeriju</h2>
        <p class="hint">Možeš ubaciti više slika odjednom.</p>

        <form method="post" enctype="multipart/form-data">
          <input type="hidden" name="csrf" value="<?php echo h($csrf); ?>">
          <input type="hidden" name="action" value="add_gallery">

          <div class="row">
            <div>
              <label>Slike</label>
              <input type="file" name="gallery_images[]" accept="image/*" multiple required>
            </div>
            <div>
              <button class="btn btn-primary" type="submit">Dodaj u galeriju</button>
            </div>
          </div>
        </form>
      </div>

      <div class="card">
        <h2>Dodaj blog post</h2>
        <p class="hint">Unesi naslov, tekst i dodaj glavnu sliku posta.</p>

        <form method="post" enctype="multipart/form-data">
          <input type="hidden" name="csrf" value="<?php echo h($csrf); ?>">
          <input type="hidden" name="action" value="add_blog">

          <div class="row">
            <div class="row2">
              <div>
                <label>Naslov</label>
                <input type="text" name="subject" required>
              </div>
              <div>
                <label>Glavna slika</label>
                <input type="file" name="main_image" accept="image/*" required>
              </div>
            </div>
            <div>
              <label>Tekst</label>
              <textarea name="text" required></textarea>
            </div>
            <div>
              <button class="btn btn-primary" type="submit">Dodaj blog post</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="footer-space"></div>
    

<div class="card">
  <h2>Kreiraj user-a</h2>
  <p class="hint">Ovaj user će moći da se uloguje na sajt korišćenjem emaila i passworda.</p>

  <form method="post" autocomplete="off">
    <input type="hidden" name="csrf" value="<?php echo h($csrf); ?>">
    <input type="hidden" name="action" value="add_user">

    <div class="row">
      <div class="row2">
        <div>
          <label>Email *</label>
          <input type="email" name="u_email" required>
        </div>
        <div>
          <label>Password *</label>
          <input type="password" name="u_password" required>
        </div>
      </div>

      <div class="row2">
        <div>
          <label>Selected plan</label>
          <input type="text" name="selected_plan" placeholder="explorer / family ...">
        </div>
        <div>
          <label>Selected option</label>
          <input type="text" name="selected_option" placeholder="adult / senior ...">
        </div>
      </div>

      <div class="row2">
        <div>
          <label>First name</label>
          <input type="text" name="first_name">
        </div>
        <div>
          <label>Last name</label>
          <input type="text" name="last_name">
        </div>
      </div>

      <div class="row2">
        <div>
          <label>Year of birth</label>
          <input type="number" name="birth_year" min="1900" max="2100">
        </div>
        <div>
          <label>Month of birth</label>
          <input type="text" name="birth_month" placeholder="January">
        </div>
      </div>

      <div class="row2">
        <div>
          <label>Day of birth</label>
          <input type="number" name="birth_day" min="1" max="31">
        </div>
        <div>
          <label>Gender</label>
          <select name="gender">
            <option value="">—</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>
      </div>

      <div style="height:6px;"></div>
      <div class="hint" style="margin:0;">Partner (za Family)</div>

      <div class="row2">
        <div>
          <label>Partner first name</label>
          <input type="text" name="partner_first_name">
        </div>
        <div>
          <label>Partner last name</label>
          <input type="text" name="partner_last_name">
        </div>
      </div>

      <div class="row2">
        <div>
          <label>Partner year</label>
          <input type="number" name="partner_birth_year" min="1900" max="2100">
        </div>
        <div>
          <label>Partner month</label>
          <input type="text" name="partner_birth_month" placeholder="January">
        </div>
      </div>

      <div class="row2">
        <div>
          <label>Partner day</label>
          <input type="number" name="partner_birth_day" min="1" max="31">
        </div>
        <div>
          <label>Partner gender</label>
          <select name="partner_gender">
            <option value="">—</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
        </div>
      </div>

      <div style="height:6px;"></div>
      <div class="hint" style="margin:0; display:flex; justify-content:space-between; align-items:center; gap:12px;">
        <span>Children</span>
        <button type="button" class="btn" id="addChildBtn">Add child</button>
      </div>

      <div id="childrenWrap" class="row" style="margin-top:10px;"></div>

      <template id="childTpl">
        <div class="child-card">
          <div class="child-head">
            <strong>Child</strong>
            <button type="button" class="child-remove" title="Remove">×</button>
          </div>

          <div class="row2">
            <div>
              <label>Category</label>
              <select name="child_category[]">
                <option value="student">Student aged 19 to 27 years</option>
                <option value="child">Child up to 18 years</option>
              </select>
            </div>
            <div>
              <label>Gender</label>
              <select name="child_gender[]">
                <option value="">—</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            </div>
          </div>

          <div class="row2">
            <div>
              <label>First name</label>
              <input type="text" name="child_first_name[]">
            </div>
            <div>
              <label>Last name</label>
              <input type="text" name="child_last_name[]">
            </div>
          </div>

          <div class="row2">
            <div>
              <label>Year</label>
              <input type="number" name="child_birth_year[]" min="1900" max="2100">
            </div>
            <div>
              <label>Month</label>
              <input type="text" name="child_birth_month[]" placeholder="January">
            </div>
          </div>

          <div>
            <label>Day</label>
            <input type="number" name="child_birth_day[]" min="1" max="31">
          </div>
        </div>
      </template>

      <div style="height:6px;"></div>
      <div class="hint" style="margin:0;">Contacts</div>

      <div class="row2">
        <div>
          <label>Telephone</label>
          <input type="tel" name="phone">
        </div>
        <div>
          <label>Country</label>
          <input type="text" name="country">
        </div>
      </div>

      <div class="row2">
        <div>
          <label>Street</label>
          <input type="text" name="street">
        </div>
        <div>
          <label>House number</label>
          <input type="text" name="house_number">
        </div>
      </div>

      <div class="row2">
        <div>
          <label>City</label>
          <input type="text" name="city">
        </div>
        <div>
          <label>ZIP</label>
          <input type="text" name="zip">
        </div>
      </div>

      <div>
        <button class="btn btn-primary" type="submit">Kreiraj user-a</button>
      </div>
    </div>
  </form>
</div>

<div class="footer-space"></div>

<div class="card">
  <h2>User-i</h2>
  <p class="hint">Lista svih user-a. Edit vodi na <code>edit_user.php</code>, delete na <code>delete_user.php</code> (napravićemo posle).</p>

  <table>
    <thead>
      <tr>
        <th style="width:90px;">ID</th>
        <th>Email</th>
        <th>Ime</th>
        <th>Plan</th>
        <th style="width:280px;">Akcije</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($userRows)): ?>
        <tr><td colspan="5" class="muted">Nema user-a.</td></tr>
      <?php else: ?>
        <?php foreach ($userRows as $u): ?>
          <tr>
            <td><strong><?php echo (int)$u['id']; ?></strong></td>
            <td><?php echo h((string)$u['email']); ?></td>
            <td><?php echo h(trim((string)$u['first_name'] . ' ' . (string)$u['last_name'])); ?></td>
            <td><?php echo h(trim((string)$u['selected_plan'] . ' / ' . (string)$u['selected_option'])); ?></td>
            <td>
              <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
  <a class="btn" href="edit_user.php?id=<?php echo (int)$u['id']; ?>">Edit</a>
  <a class="btn btn-danger" href="delete_user.php?id=<?php echo (int)$u['id']; ?>" onclick="return confirm('Obrisati user-a?');">Delete</a>

  <?php if (!empty($u['card'])): ?>
    <a class="btn" href="<?php echo h((string)$u['card']); ?>" target="_blank" rel="noopener">Card PDF</a>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data" style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
    <input type="hidden" name="csrf" value="<?php echo h($csrf); ?>">
    <input type="hidden" name="action" value="upload_card">
    <input type="hidden" name="user_id" value="<?php echo (int)$u['id']; ?>">

    <input type="file" name="card_pdf" accept="application/pdf" required style="max-width:220px;">
    <button class="btn btn-primary" type="submit">Upload card</button>
  </form>
</div>

            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

    
    <br>
    
    
    

    <div class="grid">
      <div class="card">
        <h2>Galerija</h2>
        <p class="hint">Klik na thumbnail otvara galeriju. Dugme „Izmeni“ vodi na formu za izmenu sastava galerije.</p>

        <table>
          <thead>
            <tr>
              <th>Slika</th>
              <th style="width:160px;">Akcija</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!$galleryRows): ?>
              <tr><td colspan="2" class="muted">Nema slika u galeriji.</td></tr>
            <?php else: ?>
              <?php foreach ($galleryRows as $g): ?>
                <tr>
                  <td>
                    <div class="cell-flex">
                      <a href="<?php echo h((string)$g['images']); ?>" data-fancybox="gallery">
                        <img class="thumb" src="<?php echo h((string)$g['images']); ?>" alt="gallery-<?php echo (int)$g['id']; ?>">
                      </a>
                      <div>
                        <div><strong>ID:</strong> <?php echo (int)$g['id']; ?></div>
                        <div class="muted"><?php echo h((string)$g['images']); ?></div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <a class="btn" href="edit_gallery.php?id=<?php echo (int)$g['id']; ?>">Izmeni</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="card">
        <h2>Blog</h2>
        <p class="hint">Levo je ID i naslov svakog blog posta. Desno su akcije za izmenu i brisanje blog postova.</p>

        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Naslov</th>
              <th style="width:260px;">Akcije</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!$blogRows): ?>
              <tr><td colspan="3" class="muted">Nema blog postova.</td></tr>
            <?php else: ?>
              <?php foreach ($blogRows as $b): ?>
                <tr>
                  <td><strong><?php echo (int)$b['id']; ?></strong></td>
                  <td><?php echo h((string)$b['subject']); ?></td>
                  <td>
                    <div style="display:flex; gap:10px; flex-wrap:wrap;">
                      <a class="btn" href="edit_blog.php?id=<?php echo (int)$b['id']; ?>">Izmeni</a>
                      <a class="btn btn-danger" href="delete_blog.php?id=<?php echo (int)$b['id']; ?>">Ukloni</a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <!-- Fancybox -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
  <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
  
  <script>
  (function () {
    const btn = document.getElementById('addChildBtn');
    const wrap = document.getElementById('childrenWrap');
    const tpl = document.getElementById('childTpl');

    if (!btn || !wrap || !tpl) return;

    btn.addEventListener('click', function () {
      const node = tpl.content.cloneNode(true);
      const card = node.querySelector('.child-card');
      const removeBtn = node.querySelector('.child-remove');

      if (removeBtn && card) {
        removeBtn.addEventListener('click', function () {
          card.remove();
        });
      }

      wrap.appendChild(node);
    });
  })();
</script>


</body>
</html>
