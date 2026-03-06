<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

// prilagodi putanju ako ti je db.php negde drugde
require __DIR__ . '/admin/db.php';

function h(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$isUserLoggedIn = !empty($_SESSION['user_id']);
$currentUrl = (string)($_SERVER['REQUEST_URI'] ?? '/');
$logoutHref = 'logout.php?next=' . urlencode($currentUrl);
$loginHref  = 'login.php';
$authHref   = $isUserLoggedIn ? $logoutHref : $loginHref;
$authText   = $isUserLoggedIn ? 'Logout' : 'Login';

$errorMsg = '';
$emailValue = '';

if ($isUserLoggedIn) {
  header('Location: moj-profil.php');
  exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $emailValue = trim((string)($_POST['username'] ?? '')); // tvoje polje se zove username
  $password   = (string)($_POST['password'] ?? '');

  if ($emailValue === '' || $password === '') {
    $errorMsg = 'Unesi email i password.';
  } elseif (!filter_var($emailValue, FILTER_VALIDATE_EMAIL)) {
    $errorMsg = 'Unesi validan email.';
  } else {
    $stmt = $mysqli->prepare("SELECT id, email, password FROM `user` WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $emailValue);
    $stmt->execute();
    $res = $stmt->get_result();
    $u = $res->fetch_assoc();

    $ok = false;

    if ($u) {
      $stored = (string)($u['password'] ?? '');

      // standardno: hashed password
      if ($stored !== '' && password_verify($password, $stored)) {
        $ok = true;
      }

      // fallback (ako je neko uneo plain text u bazu), pa odmah migriraj u hash
      if (!$ok && $stored !== '' && hash_equals($stored, $password)) {
        $ok = true;
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $upd = $mysqli->prepare("UPDATE `user` SET password = ? WHERE id = ? LIMIT 1");
        $uid = (int)$u['id'];
        $upd->bind_param("si", $newHash, $uid);
        $upd->execute();
      }
    }

    if ($ok) {
      session_regenerate_id(true);
      $_SESSION['user_id'] = (int)$u['id'];
      $_SESSION['user_email'] = (string)$u['email'];

      header('Location: moj-profil.php');
      exit;
    } else {
      $errorMsg = 'Pogrešan email ili password.';
    }
  }
}
?>

<!DOCTYPE html>
<html class="no-js" lang="sr">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="author" content="https://is.gd/a33FWT" />
    <title>BERG Membership Program - Prijava</title>

    <meta name="description" content="BERG Membership Program - Prijava" />
    <meta name="keywords" content="BERG Membership Program, prijava, članstvo" />
    <meta name="robots" content="INDEX,FOLLOW" />
    <meta name="developer" content="Apis Development" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="57x57" href="assets/img/berg-membership-program-ig.svg" />
    <link rel="apple-touch-icon" sizes="60x60" href="assets/img/berg-membership-program-ig.svg" />
    <link rel="apple-touch-icon" sizes="72x72" href="assets/img/berg-membership-program-ig.svg" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/berg-membership-program-ig.svg" />
    <link rel="apple-touch-icon" sizes="114x114" href="assets/img/berg-membership-program-ig.svg" />
    <link rel="apple-touch-icon" sizes="120x120" href="assets/img/berg-membership-program-ig.svg" />
    <link rel="apple-touch-icon" sizes="144x144" href="assets/img/berg-membership-program-ig.svg" />
    <link rel="apple-touch-icon" sizes="152x152" href="assets/img/berg-membership-program-ig.svg" />
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/berg-membership-program-ig.svg" />
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/berg-membership-program-ig.svg" />
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/berg-membership-program-ig.svg" />
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/berg-membership-program-ig.svg" />
    <link rel="manifest" href="assets/img/favicons/manifest.json" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="msapplication-TileImage" content="assets/img/favicons/ms-icon-144x144.png" />
    <meta name="theme-color" content="#fff" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
      rel="stylesheet"
    />

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/plugins.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
  </head>

  <body class="vs-body">
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        Koristite <strong>zastareli</strong> pregledač. Molimo vas da
        <a href="https://browsehappy.com/">ažurirate pregledač</a> radi boljeg
        iskustva i bezbednosti.
      </p>
    <![endif]-->

    <?php require __DIR__ . '/header-sr.php'; ?>

    <main class="main">
      <!--================= Breadcrumb Area start =================-->
      <section class="vs-breadcrumb" data-bg-src="./assets/img/berg-membership-login.png">
        <div class="container">
          <div class="row text-center">
            <div class="col-12">
              <div class="breadcrumb-content">
                <h1 class="breadcrumb-title">Prijava</h1>
              </div>

              <div class="breadcrumb-content">
                <h5 class="mt-4" style="color: white">
                  Sve što ti treba za bezbedniju avanturu na otvorenom, u jednoj kartici.
                </h5>
              </div>

              <div class="breadcrumb-content">
                <p class="mt-4" style="color: white">
                  Saznaj šta dobijaš uz BERG: zaštitu spasavanja širom sveta,
                  uštede za članove i praktične pogodnosti koje podržavaju tvoj outdoor stil.
                </p>
              </div>

              <div class="fade-anim mt-5" data-delay="0.77" data-direction="top">
                <a href="clanstvo.php" class="vs-btn style4">
                  <span>IZABERI ČLANSTVO</span>
                </a>
                <a href="benefiti.php" class="vs-btn style4">
                  <span>ZAŠTITA SPASAVANJA</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Breadcrumb Area end =================-->

      <!--================= Login Area start =================-->
      <section
        class="vs-about position-relative space berg-login pb-5"
        style="background-color: #f0f1e9"
      >
        <div class="container">
          <div class="row">
            <div class="col-lg-auto mx-auto">
              <div class="title-area text-center">
                <span class="sec-subtitle text-capitalize fade-anim" data-direction="top">
                  BERG Membership Prijava
                </span>
                <h2 class="sec-title fade-anim" data-direction="bottom">
                  Pristupi svom nalogu
                </h2>
                <p class="berg-login-subtext">
                  Prijavi se da upravljaš članstvom, pregledaš dokumenta i koristiš ekskluzivne benefite.
                </p>
              </div>
            </div>
          </div>

          <!-- LOGIN FORM -->
          <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-7 col-xl-6">
              <div class="berg-login-card">
                <h4 class="berg-login-title text-center mb-25">Prijava člana</h4>

                <form
                  class="berg-login-form"
                  action="prijava.php"
                  method="post"
                  novalidate
                >
                  <div class="row g-3">
                    <div class="col-12">
                      <label class="form-label">Korisničko ime ili Email *</label>
                      <input
                        class="form-control"
                        type="text"
                        name="username"
                        placeholder="Unesi korisničko ime ili email"
                        required
                        value="<?php echo h($emailValue); ?>"
                      />
                    </div>

                    <div class="col-12">
                      <label class="form-label">Lozinka *</label>
                      <div class="berg-pass-wrap">
                        <input
                          class="form-control berg-pass-input"
                          type="password"
                          name="password"
                          placeholder="Unesi lozinku"
                          required
                        />
                        <button
                          type="button"
                          class="berg-pass-toggle"
                          aria-label="Prikaži/Sakrij lozinku"
                        >
                          Prikaži
                        </button>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="berg-login-row">
                        <label class="berg-check">
                          <input type="checkbox" name="remember" />
                          <span>Zapamti me</span>
                        </label>

                        <a class="berg-forgot" href="#">Zaboravljena lozinka?</a>
                      </div>
                    </div>

                    <div class="col-12">
                      <button type="submit" class="vs-btn style9 w-100 berg-login-btn">
                        <span>PRIJAVI SE</span>
                      </button>
                    </div>

                    <div class="col-12">
                      <div class="berg-login-foot text-center">
                        <span>Nemaš nalog?</span>
                        <a href="clanstvo.php">Postani član</a>
                      </div>
                    </div>
                  </div>
                </form>

                <?php if (!empty($errorMsg)): ?>
                  <div class="berg-login-msg mt-20">
                    <?php echo h($errorMsg); ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Login Area end =================-->
    </main>

    <?php require __DIR__ . '/footer-sr.php'; ?>

    <a href="#" class="scrollToTop scroll-btn"><i class="far fa-arrow-up"></i></a>

    <!-- JS -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/daterangepicker.min.js"></script>
    <script src="assets/js/swiper-bundle.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/odometer.min.js"></script>
    <script src="assets/js/viewport.jquery.js"></script>
    <script src="assets/js/gsap.min.js"></script>
    <script src="assets/js/ScrollTrigger.min.js"></script>
    <script src="assets/js/ScrollToPlugin.min.js"></script>
    <script src="assets/js/SplitText.min.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>
