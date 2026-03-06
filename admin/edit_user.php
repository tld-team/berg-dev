<?php
declare(strict_types=1);

session_start();
require __DIR__ . '/db.php';


$uploadBaseDir = __DIR__ . '/uploads';
$cardsDir      = $uploadBaseDir . '/cards';

foreach ([$uploadBaseDir, $cardsDir] as $dir) {
  if (!is_dir($dir)) {
    @mkdir($dir, 0755, true);
  }
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

  return rtrim($destUrlPrefix, '/') . '/' . $name; // uploads/cards/xxx.pdf
}




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

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
  http_response_code(400);
  exit('Nedostaje ID user-a.');
}

$flashOk = '';
$flashErr = '';

// Fetch user
$stmt = $mysqli->prepare("SELECT * FROM `user` WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();

if (!$user) {
  http_response_code(404);
  exit('User nije pronađen.');
}

function norm_nullable_int($v): ?int {
  $v = trim((string)$v);
  if ($v === '') return null;
  $i = (int)$v;
  return $i > 0 ? $i : null;
}

function build_children_json(array $post): ?string {
  $child_category    = $post['child_category'] ?? [];
  $child_first_name  = $post['child_first_name'] ?? [];
  $child_last_name   = $post['child_last_name'] ?? [];
  $child_birth_year  = $post['child_birth_year'] ?? [];
  $child_birth_month = $post['child_birth_month'] ?? [];
  $child_birth_day   = $post['child_birth_day'] ?? [];
  $child_gender      = $post['child_gender'] ?? [];

  if (!is_array($child_first_name)) return null;

  $children = [];
  $count = count($child_first_name);
  for ($i = 0; $i < $count; $i++) {
    $fn = trim((string)($child_first_name[$i] ?? ''));
    $ln = trim((string)($child_last_name[$i] ?? ''));
    $cat = trim((string)($child_category[$i] ?? ''));
    $gy  = trim((string)($child_birth_year[$i] ?? ''));
    $gm  = trim((string)($child_birth_month[$i] ?? ''));
    $gd  = trim((string)($child_birth_day[$i] ?? ''));
    $gg  = trim((string)($child_gender[$i] ?? ''));

    // ako su prazni i ime i prezime, preskoci
    if ($fn === '' && $ln === '') continue;

    $children[] = [
      'category'    => $cat,
      'first_name'  => $fn,
      'last_name'   => $ln,
      'birth_year'  => $gy,
      'birth_month' => $gm,
      'birth_day'   => $gd,
      'gender'      => $gg,
    ];
  }

  return $children ? json_encode($children, JSON_UNESCAPED_UNICODE) : null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $token = (string)($_POST['csrf'] ?? '');
  if (!hash_equals($csrf, $token)) {
    $flashErr = 'CSRF greška. Osveži stranicu i pokušaj ponovo.';
  } else {
    try {
        
              // Separate action: upload Alpenverein card PDF
      if (($_POST['action'] ?? '') === 'upload_card') {
        if (empty($_FILES['card_pdf']['tmp_name'])) {
          throw new RuntimeException('Izaberi PDF.');
        }

        $url = save_pdf_upload($_FILES['card_pdf'], $cardsDir, 'uploads/cards');

        $stmtC = $mysqli->prepare("UPDATE `user` SET card = ? WHERE id = ? LIMIT 1");
        $stmtC->bind_param("si", $url, $id);
        if (!$stmtC->execute()) {
          throw new RuntimeException('Greška pri snimanju card PDF: ' . $stmtC->error);
        }

        $flashOk = 'Card PDF je uploadovan.';

        // Refetch updated user
        $stmt = $mysqli->prepare("SELECT * FROM `user` WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        // Stop here so the normal "save user" logic doesn't run
        goto after_post;
      }

        
      $email = trim((string)($_POST['email'] ?? ''));
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new RuntimeException('Email nije validan.');
      }

      $newPassword = (string)($_POST['password'] ?? '');
      $passwordHash = null;
      if (trim($newPassword) !== '') {
        if (strlen($newPassword) < 6) {
          throw new RuntimeException('Password mora imati bar 6 karaktera.');
        }
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
      }

      $selected_plan   = trim((string)($_POST['selected_plan'] ?? ''));
      $selected_option = trim((string)($_POST['selected_option'] ?? ''));

      $first_name = trim((string)($_POST['first_name'] ?? ''));
      $last_name  = trim((string)($_POST['last_name'] ?? ''));

      $birth_year  = norm_nullable_int($_POST['birth_year'] ?? '');
      $birth_month = trim((string)($_POST['birth_month'] ?? ''));
      $birth_day   = norm_nullable_int($_POST['birth_day'] ?? '');
      $gender      = trim((string)($_POST['gender'] ?? ''));

      $partner_first_name = trim((string)($_POST['partner_first_name'] ?? ''));
      $partner_last_name  = trim((string)($_POST['partner_last_name'] ?? ''));

      $partner_birth_year  = norm_nullable_int($_POST['partner_birth_year'] ?? '');
      $partner_birth_month = trim((string)($_POST['partner_birth_month'] ?? ''));
      $partner_birth_day   = norm_nullable_int($_POST['partner_birth_day'] ?? '');
      $partner_gender      = trim((string)($_POST['partner_gender'] ?? ''));

      $phone        = trim((string)($_POST['phone'] ?? ''));
      $street       = trim((string)($_POST['street'] ?? ''));
      $house_number = trim((string)($_POST['house_number'] ?? ''));
      $city         = trim((string)($_POST['city'] ?? ''));
      $zip          = trim((string)($_POST['zip'] ?? ''));
      $country      = trim((string)($_POST['country'] ?? ''));

      $children_json = build_children_json($_POST);

      // Update (sa ili bez password-a)
      if ($passwordHash !== null) {
        $sql = "
          UPDATE `user` SET
            email = ?,
            password = ?,
            selected_plan = ?,
            selected_option = ?,
            first_name = ?,
            last_name = ?,
            birth_year = ?,
            birth_month = ?,
            birth_day = ?,
            gender = ?,
            partner_first_name = ?,
            partner_last_name = ?,
            partner_birth_year = ?,
            partner_birth_month = ?,
            partner_birth_day = ?,
            partner_gender = ?,
            children_json = ?,
            phone = ?,
            street = ?,
            house_number = ?,
            city = ?,
            zip = ?,
            country = ?
          WHERE id = ?
          LIMIT 1
        ";
        $stmtUp = $mysqli->prepare($sql);

        $params = [
          $email,
          $passwordHash,
          $selected_plan,
          $selected_option,
          $first_name,
          $last_name,
          $birth_year,
          $birth_month,
          $birth_day,
          $gender,
          $partner_first_name,
          $partner_last_name,
          $partner_birth_year,
          $partner_birth_month,
          $partner_birth_day,
          $partner_gender,
          $children_json,
          $phone,
          $street,
          $house_number,
          $city,
          $zip,
          $country,
          $id
        ];
        $types = str_repeat('s', count($params) - 1) . 'i';
        $stmtUp->bind_param($types, ...$params);
      } else {
        $sql = "
          UPDATE `user` SET
            email = ?,
            selected_plan = ?,
            selected_option = ?,
            first_name = ?,
            last_name = ?,
            birth_year = ?,
            birth_month = ?,
            birth_day = ?,
            gender = ?,
            partner_first_name = ?,
            partner_last_name = ?,
            partner_birth_year = ?,
            partner_birth_month = ?,
            partner_birth_day = ?,
            partner_gender = ?,
            children_json = ?,
            phone = ?,
            street = ?,
            house_number = ?,
            city = ?,
            zip = ?,
            country = ?
          WHERE id = ?
          LIMIT 1
        ";
        $stmtUp = $mysqli->prepare($sql);

        $params = [
          $email,
          $selected_plan,
          $selected_option,
          $first_name,
          $last_name,
          $birth_year,
          $birth_month,
          $birth_day,
          $gender,
          $partner_first_name,
          $partner_last_name,
          $partner_birth_year,
          $partner_birth_month,
          $partner_birth_day,
          $partner_gender,
          $children_json,
          $phone,
          $street,
          $house_number,
          $city,
          $zip,
          $country,
          $id
        ];
        $types = str_repeat('s', count($params) - 1) . 'i';
        $stmtUp->bind_param($types, ...$params);
      }

      if (!$stmtUp->execute()) {
        if ((int)$stmtUp->errno === 1062) {
          throw new RuntimeException('Već postoji user sa ovim email-om.');
        }
        throw new RuntimeException('Greška pri snimanju: ' . $stmtUp->error);
      }

      $flashOk = 'User je sačuvan.';

      // Refetch updated user
      $stmt = $mysqli->prepare("SELECT * FROM `user` WHERE id = ? LIMIT 1");
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $res = $stmt->get_result();
      $user = $res->fetch_assoc();

    } catch (Throwable $e) {
      $flashErr = $e->getMessage();
    }
  }
}
after_post:

$children = [];
if (!empty($user['children_json'])) {
  $decoded = json_decode((string)$user['children_json'], true);
  if (is_array($decoded)) $children = $decoded;
}

$adminUser = (string)($_SESSION['admin_username'] ?? 'admin');
?>
<!doctype html>
<html lang="sr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit user</title>

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

    label{display:block; font-size:13px; margin:0 0 6px 0; color:#333; font-weight:600;}
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
    input:focus, textarea:focus, select:focus{
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(117,117,79,.18);
      background: rgba(255,255,255,.85);
    }

    .row{display:grid; grid-template-columns:1fr; gap:12px}
    .row2{display:grid; grid-template-columns:1fr 1fr; gap:12px}
    @media (max-width: 780px){ .row2{grid-template-columns:1fr;} }

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

    .footer-space{height:18px}
    code{font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;}
  </style>
</head>
<body>
  <div class="topbar">
    <div class="topbar-inner">
      <div class="brand">
        <span>Edit user</span>
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
    <?php if ($flashOk): ?><div class="flash ok"><?php echo h($flashOk); ?></div><?php endif; ?>
    <?php if ($flashErr): ?><div class="flash err"><?php echo h($flashErr); ?></div><?php endif; ?>

    <div class="card">
      <h2>User #<?php echo (int)$user['id']; ?></h2>
      <p class="hint">
        Email je obavezan. Password je opcion (ako ga ostaviš prazno, ostaje stari).
        Delete ide preko posebne strane: <code>delete_user.php</code>.
      </p>

      <form method="post" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?php echo h($csrf); ?>">

        <div class="row">
          <div class="row2">
            <div>
              <label>Email *</label>
              <input type="email" name="email" required value="<?php echo h((string)$user['email']); ?>">
            </div>
            <div>
              <label>Novi password (opciono)</label>
              <input type="password" name="password" placeholder="ostavi prazno da ostane stari">
            </div>
          </div>

          <div class="row2">
            <div>
              <label>Selected plan</label>
              <input type="text" name="selected_plan" value="<?php echo h((string)($user['selected_plan'] ?? '')); ?>">
            </div>
            <div>
              <label>Selected option</label>
              <input type="text" name="selected_option" value="<?php echo h((string)($user['selected_option'] ?? '')); ?>">
            </div>
          </div>

          <div class="row2">
            <div>
              <label>First name</label>
              <input type="text" name="first_name" value="<?php echo h((string)($user['first_name'] ?? '')); ?>">
            </div>
            <div>
              <label>Last name</label>
              <input type="text" name="last_name" value="<?php echo h((string)($user['last_name'] ?? '')); ?>">
            </div>
          </div>

          <div class="row2">
            <div>
              <label>Year of birth</label>
              <input type="number" name="birth_year" min="1900" max="2100" value="<?php echo h((string)($user['birth_year'] ?? '')); ?>">
            </div>
            <div>
              <label>Month of birth</label>
              <input type="text" name="birth_month" value="<?php echo h((string)($user['birth_month'] ?? '')); ?>">
            </div>
          </div>

          <div class="row2">
            <div>
              <label>Day of birth</label>
              <input type="number" name="birth_day" min="1" max="31" value="<?php echo h((string)($user['birth_day'] ?? '')); ?>">
            </div>
            <div>
              <label>Gender</label>
              <select name="gender">
                <?php $g = (string)($user['gender'] ?? ''); ?>
                <option value="" <?php echo $g===''?'selected':''; ?>>—</option>
                <option value="male" <?php echo $g==='male'?'selected':''; ?>>Male</option>
                <option value="female" <?php echo $g==='female'?'selected':''; ?>>Female</option>
              </select>
            </div>
          </div>
          
          <div class="row2">
  <div>
    <label>Alpenverein card (PDF)</label>

    <?php if (!empty($user['card'])): ?>
      <div style="margin:0 0 8px 0;">
        <a class="btn" href="<?php echo h((string)$user['card']); ?>" target="_blank" rel="noopener">Open current PDF</a>
      </div>
    <?php else: ?>
      <div class="muted" style="margin:0 0 8px 0;">No card uploaded.</div>
    <?php endif; ?>

    <input type="file" name="card_pdf" accept="application/pdf">
    <div class="muted" style="margin-top:6px;">Upload replaces the current card.</div>
  </div>

  <div style="display:flex; align-items:flex-end;">
    <button class="btn btn-primary" type="submit" name="action" value="upload_card">Upload card</button>
  </div>
</div>


          <div style="height:6px;"></div>
          <div class="hint" style="margin:0;">Partner (za Family)</div>

          <div class="row2">
            <div>
              <label>Partner first name</label>
              <input type="text" name="partner_first_name" value="<?php echo h((string)($user['partner_first_name'] ?? '')); ?>">
            </div>
            <div>
              <label>Partner last name</label>
              <input type="text" name="partner_last_name" value="<?php echo h((string)($user['partner_last_name'] ?? '')); ?>">
            </div>
          </div>

          <div class="row2">
            <div>
              <label>Partner year</label>
              <input type="number" name="partner_birth_year" min="1900" max="2100" value="<?php echo h((string)($user['partner_birth_year'] ?? '')); ?>">
            </div>
            <div>
              <label>Partner month</label>
              <input type="text" name="partner_birth_month" value="<?php echo h((string)($user['partner_birth_month'] ?? '')); ?>">
            </div>
          </div>

          <div class="row2">
            <div>
              <label>Partner day</label>
              <input type="number" name="partner_birth_day" min="1" max="31" value="<?php echo h((string)($user['partner_birth_day'] ?? '')); ?>">
            </div>
            <div>
              <label>Partner gender</label>
              <?php $pg = (string)($user['partner_gender'] ?? ''); ?>
              <select name="partner_gender">
                <option value="" <?php echo $pg===''?'selected':''; ?>>—</option>
                <option value="male" <?php echo $pg==='male'?'selected':''; ?>>Male</option>
                <option value="female" <?php echo $pg==='female'?'selected':''; ?>>Female</option>
              </select>
            </div>
          </div>

          <div style="height:6px;"></div>
          <div class="hint" style="margin:0; display:flex; justify-content:space-between; align-items:center; gap:12px;">
            <span>Children</span>
            <button type="button" class="btn" id="addChildBtn">Add child</button>
          </div>

          <div id="childrenWrap" class="row" style="margin-top:10px;">
            <?php if (!$children): ?>
              <!-- empty -->
            <?php else: ?>
              <?php foreach ($children as $ch): ?>
                <div class="child-card">
                  <div class="child-head">
                    <strong>Child</strong>
                    <button type="button" class="child-remove" title="Remove">×</button>
                  </div>

                  <div class="row2">
                    <div>
                      <label>Category</label>
                      <?php $cc = (string)($ch['category'] ?? ''); ?>
                      <select name="child_category[]">
                        <option value="student" <?php echo $cc==='student'?'selected':''; ?>>Student aged 19 to 27 years</option>
                        <option value="child" <?php echo $cc==='child'?'selected':''; ?>>Child up to 18 years</option>
                      </select>
                    </div>
                    <div>
                      <label>Gender</label>
                      <?php $cg = (string)($ch['gender'] ?? ''); ?>
                      <select name="child_gender[]">
                        <option value="" <?php echo $cg===''?'selected':''; ?>>—</option>
                        <option value="male" <?php echo $cg==='male'?'selected':''; ?>>Male</option>
                        <option value="female" <?php echo $cg==='female'?'selected':''; ?>>Female</option>
                      </select>
                    </div>
                  </div>

                  <div class="row2">
                    <div>
                      <label>First name</label>
                      <input type="text" name="child_first_name[]" value="<?php echo h((string)($ch['first_name'] ?? '')); ?>">
                    </div>
                    <div>
                      <label>Last name</label>
                      <input type="text" name="child_last_name[]" value="<?php echo h((string)($ch['last_name'] ?? '')); ?>">
                    </div>
                  </div>

                  <div class="row2">
                    <div>
                      <label>Year</label>
                      <input type="number" name="child_birth_year[]" min="1900" max="2100" value="<?php echo h((string)($ch['birth_year'] ?? '')); ?>">
                    </div>
                    <div>
                      <label>Month</label>
                      <input type="text" name="child_birth_month[]" value="<?php echo h((string)($ch['birth_month'] ?? '')); ?>">
                    </div>
                  </div>

                  <div>
                    <label>Day</label>
                    <input type="number" name="child_birth_day[]" min="1" max="31" value="<?php echo h((string)($ch['birth_day'] ?? '')); ?>">
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>

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
              <input type="tel" name="phone" value="<?php echo h((string)($user['phone'] ?? '')); ?>">
            </div>
            <div>
              <label>Country</label>
              <input type="text" name="country" value="<?php echo h((string)($user['country'] ?? '')); ?>">
            </div>
          </div>

          <div class="row2">
            <div>
              <label>Street</label>
              <input type="text" name="street" value="<?php echo h((string)($user['street'] ?? '')); ?>">
            </div>
            <div>
              <label>House number</label>
              <input type="text" name="house_number" value="<?php echo h((string)($user['house_number'] ?? '')); ?>">
            </div>
          </div>

          <div class="row2">
            <div>
              <label>City</label>
              <input type="text" name="city" value="<?php echo h((string)($user['city'] ?? '')); ?>">
            </div>
            <div>
              <label>ZIP</label>
              <input type="text" name="zip" value="<?php echo h((string)($user['zip'] ?? '')); ?>">
            </div>
          </div>

          <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <button class="btn btn-primary" type="submit">Sačuvaj</button>
            <a class="btn btn-danger" href="delete_user.php?id=<?php echo (int)$user['id']; ?>">Delete</a>
            <a class="btn" href="admin.php">Nazad</a>
          </div>
        </div>
      </form>
    </div>

    <div class="footer-space"></div>
  </div>

  <script>
    (function () {
      const wrap = document.getElementById('childrenWrap');
      const tpl = document.getElementById('childTpl');
      const addBtn = document.getElementById('addChildBtn');

      function wireRemove(root){
        const btn = root.querySelector('.child-remove');
        if (btn) {
          btn.addEventListener('click', function () {
            root.remove();
          });
        }
      }

      // wire existing
      if (wrap) {
        wrap.querySelectorAll('.child-card').forEach(wireRemove);
      }

      if (!wrap || !tpl || !addBtn) return;

      addBtn.addEventListener('click', function () {
        const node = tpl.content.cloneNode(true);
        const card = node.querySelector('.child-card');
        if (card) wireRemove(card);
        wrap.appendChild(node);
      });
    })();
  </script>
</body>
</html>
