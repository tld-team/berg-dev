<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

$isUserLoggedIn = !empty($_SESSION['user_id']);

// opcionalno: za redirect nazad na istu stranicu posle logout-a
$currentUrl = (string)($_SERVER['REQUEST_URI'] ?? '/');
$logoutHref = 'logout.php?next=' . urlencode($currentUrl);
$loginHref  = 'login.php';

$authHref = $isUserLoggedIn ? $logoutHref : $loginHref;
$authText = $isUserLoggedIn ? 'Logout' : 'Login';

function h(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="author" content="https://is.gd/a33FWT" />
    <title>BERG Membership Program - Tours & Experiences</title>

    <meta name="description" content="BERG Membership Program - Benefits" />
    <meta name="keywords" content="BERG Membership Program - Benefits" />
    <meta name="robots" content="INDEX,FOLLOW" />
    <meta name="developer" content="Apis Development" />

    <!-- Mobile Specific Metas -->
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <!-- Favicons - Place favicon.ico in the root directory -->
    <link
      rel="apple-touch-icon"
      sizes="57x57"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="apple-touch-icon"
      sizes="60x60"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="apple-touch-icon"
      sizes="72x72"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="apple-touch-icon"
      sizes="76x76"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="apple-touch-icon"
      sizes="114x114"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="apple-touch-icon"
      sizes="120x120"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="apple-touch-icon"
      sizes="144x144"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="apple-touch-icon"
      sizes="152x152"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="apple-touch-icon"
      sizes="180x180"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="96x96"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="assets/img/berg-membership-program-ig.svg"
    />
    <link rel="manifest" href="assets/img/favicons/manifest.json" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta
      name="msapplication-TileImage"
      content="assets/img/favicons/ms-icon-144x144.png"
    />
    <meta name="theme-color" content="#fff" />
    <!--=================
	  Google Fonts
	================= -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
      rel="stylesheet"
    />
    <!--=================
	    All CSS File
	================= -->
    <!-- plugins -->
    <link rel="stylesheet" href="assets/css/plugins.css" />
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css" />
  </head>

  <body class="vs-body">
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->
    <!--********************************
   		Code Start From Here 
	******************************** -->
    <!--=================
		Preloader
	=================-->
    <?php require __DIR__ . '/header-en.php'; ?>
      <!--================= Header Area end =================-->

      <!--================= Breadcrumb Area start =================-->
      <section
        class="vs-breadcrumb"
        data-bg-src="./assets/img/berg-membership-tours-experiences.png"
      >
        <div class="container">
          <div class="row text-center">
            <div class="col-12">
              <div class="breadcrumb-content">
                <h1 class="breadcrumb-title">Tours & Experiences</h1>
              </div>
              <div class="breadcrumb-content">
                <h5 class="mt-4" style="color: white">
                  All you need for safe outdoor adventure — in one card.
                </h5>
              </div>
              <div class="breadcrumb-content">
                <p class="mt-4" style="color: white">
                  Explore what you get with BERG: worldwide rescue protection,
                  member savings, and practical access that supports your
                  outdoor lifestyle.
                </p>
              </div>
              <div
                class="fade-anim mt-5"
                data-delay="0.77"
                data-direction="top"
              >
                <a href="membership.php" class="vs-btn style4">
                  <span>CHOOSE A MEMBERSHIP</span>
                </a>
                <a href="benefits.php" class="vs-btn style4-secundary">
                  <span>RESCUE PROTECTION</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Breadcrumb Area end =================-->

      <!--================= Benefits: Tours & Experiences start =================-->
        <section class="vs-about position-relative space" style="background-color:#fdf8f5" id="benefits-tours">
        <div class="container">
            <!-- Title -->
            <div class="row">
            <div class="col-lg-auto mx-auto">
                <div class="title-area text-center">
                <span class="sec-subtitle text-capitalize fade-anim" data-direction="top">
                    benefits
                </span>
                <h2 class="sec-title fade-anim" data-direction="bottom">
                    Tours &amp; Experiences
                </h2>
                <p class="sec-text mt-2 mb-0">
                    Discounts on tours and accommodation.
                </p>
                </div>
            </div>
            </div>

            <!-- Partner cards (Reusable Benefit Partner Card) -->
            <div class="row g-4">

            <!-- Card 1: Montanaro Tours -->
            <div class="col-md-6 col-lg-4">
              <article class="benefit-card" data-benefit-card>
                <div class="benefit-card__top">
                  <img
                    class="benefit-card__logo"
                    src="./assets/img/benefits/berg-membership-montanaro.png"
                    alt="Montanaro"
                    loading="lazy"
                  />
                  <span class="benefit-card__badge">10% OFF</span>
                </div>

                <h4 class="benefit-card__title">Montanaro tours</h4>

            <!--    <p class="benefit-card__desc">
                  BERG members get 10% off all Montanaro tours in Serbia and abroad.
                </p>  -->

                <!-- NEW: detailed text block (as on image) -->
                <div class="benefit-card__more">
                  <p class="benefit-card__more-title"><strong>MONTANARO TOURS – Discounts for BERG Members</strong></p>

                  <p class="benefit-card__more-text">
                    BERG members receive exclusive discounts on all Montanaro tours in Serbia and abroad:
                  </p>

                  <ul class="benefit-card__more-list">
                    <li><strong>5%</strong> discount on all expeditions and tours with Hiking Tour Serbia tours</li>
                    <li><strong>5%</strong> discount on expeditions and tours with more than 2 nights</li>
                    <li><strong>15%</strong> discount on tours with up to two nights</li>
                    <li><strong>20%</strong> discount on tours with one overnight stay</li>
                    <li><strong>20%</strong> discount on all courses and trainings</li>
                  </ul>

                  <p class="benefit-card__more-text">
                    <strong>Annual discount limits per member:</strong>
                  </p>

                  <ul class="benefit-card__more-list">
                    <li>up to <strong>2</strong> expeditions/tours with more than 2 nights</li>
                    <li>up to <strong>5</strong> tours with up to two nights</li>
                    <li>up to <strong>10</strong> courses and/or tours with one overnight stay</li>
                  </ul>

                  <p class="benefit-card__more-note">
                    Discounts apply to active BERG members booking directly through Montanaro channels.
                  </p>
                </div>
                <!-- /NEW -->

                <a
                  class="vs-btn style4 benefit-card__cta"
                  href="https://montanaro.rs/avanture/"
                  target="_blank"
                  rel="noopener"
                >
                  <span>VIEW TOURS</span>
                </a>
              </article>
            </div>
            
            
            <!-- Card 2: HTS Tours -->
            <div class="col-md-6 col-lg-4">
              <article class="benefit-card" data-benefit-card>
                <div class="benefit-card__top">
                  <img
                    class="benefit-card__logo"
                    src="./assets/HTS.png"
                    alt="Montanaro"
                    loading="lazy"
                  />
                  <span class="benefit-card__badge">5% OFF</span>
                </div>

                <h4 class="benefit-card__title">Hiking Tour Serbia tours</h4>

            <!--    <p class="benefit-card__desc">
                  BERG members get 10% off all Montanaro tours in Serbia and abroad.
                </p>  -->

                <!-- NEW: detailed text block (as on image) -->
                <div class="benefit-card__more">
                  <p class="benefit-card__more-title"><strong>Hiking Tour Serbia TOURS – Discounts for BERG Members</strong></p>

                  <p class="benefit-card__more-text">
                    BERG members receive exclusive discounts on all Hiking Tour Serbia tours in Serbia and abroad:
                  </p>

                  <ul class="benefit-card__more-list">
                    <li><strong>5%</strong> discount on all expeditions and tours with Hiking Tour Serbia tours</li>
                  </ul>

                  <p class="benefit-card__more-text">
                    <strong>Annual discount limits per member:</strong>
                  </p>

                  <ul class="benefit-card__more-list">
                    <li>up to <strong>2</strong> expeditions/tours with more than 2 nights</li>
                    <li>up to <strong>5</strong> tours with up to two nights</li>
                    <li>up to <strong>10</strong> courses and/or tours with one overnight stay</li>
                  </ul>

                  <p class="benefit-card__more-note">
                    Discounts apply to active BERG members booking directly through Hiking Tour Serbia channels.
                  </p>
                </div>
                <!-- /NEW -->

                <a
                  class="vs-btn style4 benefit-card__cta"
                  href="https://hikingtourserbia.com/"
                  target="_blank"
                  rel="noopener"
                >
                  <span>VIEW TOURS</span>
                </a>
              </article>
            </div>


            <!-- Card 3: Alpine Club huts (Info card - wider) -->
            <div class="col-md-6 col-lg-4">
                <article class="benefit-card benefit-card--info" data-benefit-card>
                <div class="benefit-card__top">
                    <img
                    class="benefit-card__logo"
                    src="./assets/img/benefits/berg-membership-alpenvereinshutten.png"
                    alt="Alpine huts"
                    loading="lazy"
                    />
                    <span class="benefit-card__badge">HUT DISCOUNTS</span>
                </div>

                <h4 class="benefit-card__title">Accommodation in Alpine Club huts</h4>

                <div class="benefit-card__desc">
                    <p class="mb-3">
                    Members of the Alpine Club (Österreichischer Alpenverein) receive a discount of at least
                    <strong>€10 per night</strong> in <strong>500+ mountain huts</strong> operated by the Austrian,
                    German, and South Tyrolean Alpine Clubs. This discount applies with a valid membership card and
                    covers accommodation across Austria and surrounding Alpine regions.
                    </p>

                    <p class="mb-3">
                    In addition, membership includes <strong>international reciprocal rights</strong>—members receive
                    the same benefits as local members in huts of partner alpine associations in other European countries
                    (e.g., Switzerland, France, Italy, Spain, Slovenia, Liechtenstein, Belgium, Luxembourg, and the Netherlands).
                    </p>

                    <p class="mb-0">
                    The Alpine Club network also includes <strong>“Vertragshäuser”</strong>—partner private mountain lodges and
                    hostels that offer <strong>5–20% off</strong> accommodation to members with a valid membership card.
                    </p>
                </div>

                <div class="mt-4">
                    <a
                    class="vs-btn style4 benefit-card__cta"
                    href="https://www.alpenverein.at/huetten/finder.php"
                    target="_blank"
                    rel="noopener"
                    >
                    <span>FIND A MOUNTAIN HUT</span>
                    </a>
                </div>
                </article>
            </div>

            </div>

            <!-- CTA -->
            <div class="row pb-5">
            <div class="col-12">
                <div class="text-center space-extra-top btn-trigger btn-bounce">
                <a href="membership.php" class="vs-btn style4">
                    <span>BECOME A MEMBER</span>
                </a>
                </div>
            </div>
            </div>
        </div>
        </section>
        <!--================= Benefits: Tours & Experiences end =================-->
        
        <!--================= Feature Area start =================-->
      <div class="vs-feature-style1 vs-feature-emergency position-relative bg-theme-color">
        <div class="container">
          <div class="row g-3 align-items-center vs-feature-emergency__bar">
            <!-- LEFT -->
            <div class="col-lg-7">
              <div class="vs-feature-emergency__left text-center text-lg-start">
                <h1 class="feature-expert text-white-color ff-rubik fw-bold char-animation mb-2">
                  What to do in an emergency?
                </h1>

                <p class="vs-feature-emergency__note text-white-color ff-rubik mb-0">
                  Before repatriation, transport, in-patient medical 
                  treatment abroad or transport within the country of 
                  main place of residence <strong>(not in event of rescue)</strong>, you 
                  must contact the 24h emergency service (or max. EUR 
                  750 will be compensated)
                </p>
              </div>
            </div>

            <!-- RIGHT -->
            <div class="col-lg-5">
              <div class="vs-feature-emergency__right d-flex flex-column align-items-center align-items-lg-end text-center text-lg-end">
                <div class="vs-feature-emergency__label text-white-color ff-rubik fw-bold">
                  Europ Assistance
                </div>

                <a class="vs-btn style-4 vs-feature-emergency__btn" href="tel:+4312533798">
                  <i class="fas fa-phone-alt"></i>
                  <span>T +43/1/253 3798</span>
                </a>

                <a class="vs-btn style-4 vs-feature-emergency__btn" href="mailto:aws@alpenverein.at">
                  <i class="fas fa-envelope"></i>
                  <span>AWS@ALPENVEREIN.AT</span>
                </a>
              </div>
            </div>
          </div>
        </div>

        <h2 class="position-absolute text-white-color">Emergency</h2>
      </div>
      <!--================= Feature Area end =================-->     

    </main>
    <!-- ================= Footer Start ================= -->
<?php require __DIR__ . '/footer-en.php'; ?>
    <!-- ================= Footer End ================= -->

    <!-- ================= Main Section Wrapper End ================= -->
    <a href="#" class="scrollToTop scroll-btn"
      ><i class="far fa-arrow-up"></i
    ></a>
    <!-- ***************** Code End  Here ***************** -->
    <!--================= All Js File ================= -->
    <!-- Jquery -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <!-- Jquery UI -->
    <script src="assets/js/jquery-ui.min.js"></script>
    <!-- Jquery UI -->
    <script src="assets/js/moment.min.js"></script>
    <!-- Jquery UI -->
    <script src="assets/js/daterangepicker.min.js"></script>
    <!-- Swiper Slider -->
    <script src="assets/js/swiper-bundle.min.js"></script>
    <!-- Bootstrap -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- WOW.js Animation -->
    <script src="assets/js/wow.min.js"></script>
    <!-- Magnific Popup -->
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Image Loaded Jquery -->
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <!-- Odometer JS -->
    <script src="assets/js/odometer.min.js"></script>
    <script src="assets/js/viewport.jquery.js"></script>
    <!-- Gsap -->
    <script src="assets/js/gsap.min.js"></script>
    <!-- ScrollTrigger -->
    <script src="assets/js/ScrollTrigger.min.js"></script>
    <!-- ScrollToPlugin -->
    <script src="assets/js/ScrollToPlugin.min.js"></script>
    <!-- SplitText -->
    <script src="assets/js/SplitText.min.js"></script>

    <!-- Main Js File -->
    <script src="assets/js/main.js"></script>
  </body>
</html>
