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
    <title>BERG Membership Program - Zdravlje & Dodatne Opcije</title>

    <meta name="description" content="BERG Membership Program - O nama" />
    <meta name="keywords" content="BERG Membership Program, o nama, članstvo, spasavanje, outdoor" />
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
      <section class="vs-breadcrumb" data-bg-src="./assets/img/berg-membership-health-custom-upgrades.png">
        <div class="container">
          <div class="row text-center">
            <div class="col-12">
              <div class="breadcrumb-content">
                <h1 class="breadcrumb-title">Zdravlje & Dodatne Opcije</h1>
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
                <a href="benefiti.php" class="vs-btn style4-secundary">
                  <span>ZAŠTITA SPASAVANJA</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Breadcrumb Area end =================-->

      <!--================= Benefits: Courses & Events start =================-->
        <section
        class="vs-about position-relative space pb-5"
        style="background-color:#fdf8f5"
        id="benefits-health"
        >
        <div class="container">
            <!-- Title -->
            <div class="row">
            <div class="col-lg-auto mx-auto">
                <div class="title-area text-center">
                <span class="sec-subtitle text-capitalize">benefiti</span>
                <h2 class="sec-title">Zdravlje &amp; Prilagođene nadogradnje</h2>
                <p class="sec-text mt-2 mb-0">
                    Uštede na zdravstvenim pregledima i opcione nadogradnje. Benefiti se razlikuju u zavisnosti od paketa.
                </p>
                </div>
            </div>
            </div>

            <p class="berg-note">
            <strong>Napomena:</strong> Ništa od ovoga se ne kupuje na BERG sajtu — ovo su samo informativne opcije.
            </p>

            <!-- 3 columns (Knox-like) -->
            <div class="berg-knox-grid">
            <!-- Column 1 -->
            <div class="berg-knox-col">
                <div class="berg-knox-col__head">Nadogradnje</div>

                <ul class="berg-knox-list">
                <li class="berg-knox-item">
                    <img class="berg-knox-icon" src="./assets/img/knox-icons/premium-annual-travel-insurance.svg" alt="" loading="lazy" />
                    <div>
                    <p class="berg-knox-title">Premium godišnje putno osiguranje</p>
                    <div class="berg-knox-sub">Troškovi lečenja do €500.000</div>
                    </div>
                </li>

                <li class="berg-knox-item">
                    <img class="berg-knox-icon" src="./assets/img/knox-icons/premium-single-trip-insurance.svg" alt="" loading="lazy" />
                    <div>
                    <p class="berg-knox-title">Premium osiguranje za jedno putovanje</p>
                    <div class="berg-knox-sub">Putovanja duža od osam nedelja</div>
                    </div>
                </li>

                <li class="berg-knox-item">
                    <img class="berg-knox-icon" src="./assets/img/knox-icons/accident-life-annuity.svg" alt="" loading="lazy" />
                    <div>
                    <p class="berg-knox-title">Renta u slučaju nezgode</p>
                    <div class="berg-knox-sub">Nakon nezgoda u slobodno vreme</div>
                    </div>
                </li>

                <li class="berg-knox-item">
                    <img class="berg-knox-icon" src="./assets/img/knox-icons/dog-rescue.svg" alt="" loading="lazy" />
                    <div>
                    <p class="berg-knox-title">Spašavanje psa</p>
                    <div class="berg-knox-sub">Dodatna vrednost za vašeg psa</div>
                    </div>
                </li>
                </ul>
            </div>

            <!-- Column 2 -->
            <div class="berg-knox-col">
                <div class="berg-knox-col__head">Dodatno</div>

                <ul class="berg-knox-list">
                <li class="berg-knox-item">
                    <img class="berg-knox-icon" src="./assets/img/knox-icons/sports-equipment-insurance.svg" alt="" loading="lazy" />
                    <div>
                    <p class="berg-knox-title">Osiguranje sportske opreme</p>
                    <div class="berg-knox-sub">Zaštita vaše opreme</div>
                    </div>
                </li>

                <li class="berg-knox-item">
                    <img class="berg-knox-icon" src="./assets/img/knox-icons/helpline-plus.svg" alt="" loading="lazy" />
                    <div>
                    <p class="berg-knox-title">HelpLine Plus</p>
                    <div class="berg-knox-sub">Helpline i za aktivnosti u slobodno vreme</div>
                    </div>
                </li>

                <li class="berg-knox-item">
                    <img class="berg-knox-icon" src="./assets/img/knox-icons/special-class.svg" alt="" loading="lazy" />
                    <div>
                    <p class="berg-knox-title">Specijalna klasa</p>
                    <div class="berg-knox-sub">Vrhunska nega tokom bolničkog lečenja</div>
                    </div>
                </li>
                </ul>
            </div>

            <!-- Column 3 -->
            <div class="berg-knox-col">
                <div class="berg-knox-col__head">Doživotna renta</div>

                <ul class="berg-knox-list">
                <li class="berg-knox-item">
                    <img class="berg-knox-icon" src="./assets/img/knox-icons/life-annuity-single.svg" alt="" loading="lazy" />
                    <div>
                    <p class="berg-knox-title">Doživotna renta (pojedinačno)</p>
                    <div class="berg-knox-sub">Pojedinačni proizvod doživotne rente</div>
                    </div>
                </li>

                <li class="berg-knox-item">
                    <img class="berg-knox-icon" src="./assets/img/knox-icons/life-pension-families.svg" alt="" loading="lazy" />
                    <div>
                    <p class="berg-knox-title">Doživotna renta za porodice</p>
                    <div class="berg-knox-sub">Porodični proizvod doživotne rente</div>
                    </div>
                </li>

                <li class="berg-knox-item">
                    <img class="berg-knox-icon" src="./assetsassets/img/knox-icons/accident-lump-sum-74.svg" alt="" loading="lazy" />
                    <div>
                    <p class="berg-knox-title">Jednokratna isplata u slučaju nezgode od 74. godine</p>
                    <div class="berg-knox-sub">Jednokratna isplata u slučaju nezgode od 74. godine</div>
                    </div>
                </li>

                <li class="berg-knox-item">
                    <img class="berg-knox-icon" src="./assets/img/knox-icons/accident-capital-15.svg" alt="" loading="lazy" />
                    <div>
                    <p class="berg-knox-title">Isplata kapitala u slučaju nezgode do 15. godine</p>
                    <div class="berg-knox-sub">Isplata kapitala u slučaju nezgode do 15. godine</div>
                    </div>
                </li>
                </ul>
            </div>
            </div>

            <!-- Serbian text + CTA -->
            <div class="berg-bottom-box">
            <p class="mb-3">
                Svaki zahtev za nadogradnju osiguranja obrađuje se individualno.<br />
                Ukoliko želite neku od navedenih opcija, pošaljite nam upit na
                <a href="mailto:info@bergmembership.com">info@bergmembership.com</a> sa kratkim opisom željene nadogradnje,
                kako bismo vaš zahtev prosledili dalje našem partneru.
            </p>

            <div class="berg-actions">
                <a class="vs-btn style4" href="mailto:info@bergmembership.com">
                <span>POŠALJI UPIT ZA NADOGRADNJU</span>
                </a>

                <a class="berg-link" href="https://alpenverein.sichermitknox.com/" target="_blank" rel="noopener">
                Više informacija na sajtu partnera
                </a>
            </div>
            </div>

        </div>
        </section>
        <!--================= Benefits: Health & Custom Upgrades end =================-->



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
