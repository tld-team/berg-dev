<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

$isUserLoggedIn = !empty($_SESSION['user_id']);

// opcionalno: za redirect nazad na istu stranicu posle logout-a
$currentUrl = (string)($_SERVER['REQUEST_URI'] ?? '/');
$logoutHref = 'logout.php?next=' . urlencode($currentUrl);
$loginHref  = 'prijava.php';

$authHref = $isUserLoggedIn ? $logoutHref : $loginHref;
$authText = $isUserLoggedIn ? 'Odjava' : 'Prijava';

function h(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>

<!DOCTYPE html>
<html class="no-js" lang="sr">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="author" content="https://is.gd/a33FWT" />
    <title>BERG Membership Program - Kursevi</title>

    <meta name="description" content="BERG Membership Program - Kursevi" />
    <meta name="keywords" content="BERG Membership Program, kursevi, članstvo, obuke" />
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
    <!--================= Header Area end =================-->

    <main class="main">
      <!--================= Breadcrumb Area start =================-->
      <section class="vs-breadcrumb" data-bg-src="./assets/img/berg-membership-courses.png">
        <div class="container">
          <div class="row text-center">
            <div class="col-12">
              <div class="breadcrumb-content">
                <h1 class="breadcrumb-title">BERG MEMBERSHIP</h1>
              </div>

              <div class="breadcrumb-content">
                <h5 class="mt-4" style="color: white">
                  Sve što ti je potrebno za bezbedne avanture u prirodi – u jednom članstvu.
                </h5>
              </div>

              <div class="breadcrumb-content">
            <!--    <p class="mt-4" style="color: white">
                  Saznaj šta dobijaš uz BERG: zaštitu spasavanja širom sveta,
                  uštede za članove i praktične pogodnosti koje podržavaju tvoj outdoor stil.
                </p>  -->
              </div>

              <div class="fade-anim mt-5" data-delay="0.77" data-direction="top">
                <a href="clanstvo.php" class="vs-btn style4">
                  <span>POSTANI BERG ČLAN</span>
                </a>
                <a href="benefiti.php" class="vs-btn style4-secundary">
                  <span>ISTRAŽI SVE BENEFITE</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Breadcrumb Area end =================-->

      <!--================= About Area start =================-->
      <section class="vs-about position-relative space" style="background-color: #fdf8f5">
        <div class="container">
          <div class="row">
            <div class="col-lg-auto mx-auto">
              <div class="title-area text-center">
                <span class="sec-subtitle text-capitalize fade-anim" data-direction="top">
                  Kursevi
                </span>
                <h2 class="sec-title fade-anim" data-direction="bottom">
                  Uskoro...
                </h2>
              </div>
            </div>
          </div>

          <div class="row g-4 align-items-center">
            <!-- (prazno kao u originalu) -->
          </div>

          <!-- CTA -->
          <div class="row pb-5">
            <div class="col-12">
              <div class="text-center space-extra-top btn-trigger btn-bounce">
                <a href="clanstvo.php" class="vs-btn style4">
                  <span>POSTANI ČLAN</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= About Area end =================-->
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
