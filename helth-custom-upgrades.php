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
    <title>BERG Membership Program - Health & Custom Upgrades</title>

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
        data-bg-src="./assets/img/berg-membership-health-custom-upgrades.png"
      >
        <div class="container">
          <div class="row text-center">
            <div class="col-12">
              <div class="breadcrumb-content">
                <h1 class="breadcrumb-title">Health & Custom Upgrades</h1>
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

      <!--================= Benefits: Health & Custom Upgrades start =================-->
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
          <span class="sec-subtitle text-capitalize">benefits</span>
          <h2 class="sec-title">Health &amp; Custom Upgrades</h2>
          <p class="sec-text mt-2 mb-0">
            Health checkup savings and optional upgrades. Benefits vary by plan.
          </p>
        </div>
      </div>
    </div>

    <p class="berg-note">
      <strong>Note:</strong> None of these options can be purchased on the BERG website — they are for informational purposes only.
    </p>

    <!-- 3 columns (Knox-like) -->
    <div class="berg-knox-grid">
      <!-- Column 1 -->
      <div class="berg-knox-col">
        <div class="berg-knox-col__head">Upgrades</div>

        <ul class="berg-knox-list">
          <li class="berg-knox-item">
            <!-- Globe + Shield (annual travel insurance) -->
            <div class="berg-knox-icon" aria-hidden="true">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" style="display:block">
                <path d="M12 21a9 9 0 1 0 0-18a9 9 0 0 0 0 18Z" stroke="currentColor" stroke-width="1.8"/>
                <path d="M3 12h18" stroke="currentColor" stroke-width="1.8"/>
                <path d="M12 3c2.8 2.7 4.2 5.7 4.2 9S14.8 18.3 12 21c-2.8-2.7-4.2-5.7-4.2-9S9.2 5.7 12 3Z" stroke="currentColor" stroke-width="1.8"/>
                <path d="M18.2 10.2l2.2 1.2v2.9c0 2.2-1.4 4.1-3.6 4.8l-.8.3l-.8-.3c-2.2-.7-3.6-2.6-3.6-4.8v-2.9l2.2-1.2" stroke="currentColor" stroke-width="1.6"/>
              </svg>
            </div>
            <div>
              <p class="berg-knox-title">Premium annual travel insurance</p>
              <div class="berg-knox-sub">Treatment costs up to €500,000</div>
            </div>
          </li>

          <li class="berg-knox-item">
            <!-- Suitcase / Trip (single-trip insurance) -->
            <div class="berg-knox-icon" aria-hidden="true">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" style="display:block">
                <path d="M8 7V6a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1" stroke="currentColor" stroke-width="1.8"/>
                <path d="M6 7h12a2 2 0 0 1 2 2v8a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V9a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.8"/>
                <path d="M9 11h6" stroke="currentColor" stroke-width="1.8"/>
              </svg>
            </div>
            <div>
              <p class="berg-knox-title">Premium single-trip insurance</p>
              <div class="berg-knox-sub">Trips lasting longer than eight weeks</div>
            </div>
          </li>

          <li class="berg-knox-item">
            <!-- Heartbeat / Accident annuity -->
            <div class="berg-knox-icon" aria-hidden="true">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" style="display:block">
                <path d="M12 21s-7-4.6-9.1-9.2C1.4 8.6 3.4 6 6.3 6c1.6 0 3 .8 3.7 2c.7-1.2 2.1-2 3.7-2c2.9 0 4.9 2.6 3.4 5.8C19 16.4 12 21 12 21Z" stroke="currentColor" stroke-width="1.8"/>
                <path d="M3.8 12h3l1.2-2.4L10.2 15l1.6-3h2.2l1.1 2.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <div>
              <p class="berg-knox-title">Accident life annuity</p>
              <div class="berg-knox-sub">After leisure accidents</div>
            </div>
          </li>

          <li class="berg-knox-item">
            <!-- Paw / Dog rescue -->
            <div class="berg-knox-icon" aria-hidden="true">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" style="display:block">
                <path d="M8.2 10.2c.8 0 1.5-.9 1.5-2s-.7-2-1.5-2S6.7 7.1 6.7 8.2s.7 2 1.5 2Z" stroke="currentColor" stroke-width="1.6"/>
                <path d="M15.8 10.2c.8 0 1.5-.9 1.5-2s-.7-2-1.5-2s-1.5.9-1.5 2s.7 2 1.5 2Z" stroke="currentColor" stroke-width="1.6"/>
                <path d="M6.4 13c.7 0 1.3-.8 1.3-1.8s-.6-1.8-1.3-1.8S5 10.2 5 11.2S5.7 13 6.4 13Z" stroke="currentColor" stroke-width="1.6"/>
                <path d="M17.6 13c.7 0 1.3-.8 1.3-1.8s-.6-1.8-1.3-1.8s-1.3.8-1.3 1.8s.6 1.8 1.3 1.8Z" stroke="currentColor" stroke-width="1.6"/>
                <path d="M12 12.2c-2.4 0-4.5 1.8-4.5 4.1c0 1.8 1.5 2.9 4.5 2.9s4.5-1.1 4.5-2.9c0-2.3-2.1-4.1-4.5-4.1Z" stroke="currentColor" stroke-width="1.8"/>
              </svg>
            </div>
            <div>
              <p class="berg-knox-title">Dog rescue</p>
              <div class="berg-knox-sub">The added value for your dog</div>
            </div>
          </li>
        </ul>
      </div>

      <!-- Column 2 -->
      <div class="berg-knox-col">
        <div class="berg-knox-col__head">Extra</div>

        <ul class="berg-knox-list">
          <li class="berg-knox-item">
            <!-- Helmet / Gear insurance -->
            <div class="berg-knox-icon" aria-hidden="true">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" style="display:block">
                <path d="M4 13a8 8 0 0 1 16 0v2H4v-2Z" stroke="currentColor" stroke-width="1.8"/>
                <path d="M20 15h-5a2 2 0 0 0-2 2v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                <path d="M4 15h10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
              </svg>
            </div>
            <div>
              <p class="berg-knox-title">Sports equipment insurance</p>
              <div class="berg-knox-sub">Protection for your equipment</div>
            </div>
          </li>

          <li class="berg-knox-item">
            <!-- Headset / Helpline -->
            <div class="berg-knox-icon" aria-hidden="true">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" style="display:block">
                <path d="M4 12a8 8 0 0 1 16 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                <path d="M4.5 12.5v3a2 2 0 0 0 2 2H8v-7H6.5a2 2 0 0 0-2 2Z" stroke="currentColor" stroke-width="1.8"/>
                <path d="M19.5 12.5v3a2 2 0 0 1-2 2H16v-7h1.5a2 2 0 0 1 2 2Z" stroke="currentColor" stroke-width="1.8"/>
                <path d="M8 19.5c1 .7 2.5 1.1 4 1.1c2.8 0 5-1.3 5-3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
              </svg>
            </div>
            <div>
              <p class="berg-knox-title">HelpLine Plus</p>
              <div class="berg-knox-sub">Helpline also for leisure activities</div>
            </div>
          </li>

          <li class="berg-knox-item">
            <!-- Hospital bed / Special class -->
            <div class="berg-knox-icon" aria-hidden="true">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" style="display:block">
                <path d="M4 11h16v6H4v-6Z" stroke="currentColor" stroke-width="1.8"/>
                <path d="M7 11V8.8A2.8 2.8 0 0 1 9.8 6h4.4A2.8 2.8 0 0 1 17 8.8V11" stroke="currentColor" stroke-width="1.8"/>
                <path d="M6 17v2M18 17v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                <path d="M9 14h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
              </svg>
            </div>
            <div>
              <p class="berg-knox-title">Special class</p>
              <div class="berg-knox-sub">Top-quality care during inpatient stays</div>
            </div>
          </li>
        </ul>
      </div>

      <!-- Column 3 -->
      <div class="berg-knox-col">
        <div class="berg-knox-col__head">Life annuity</div>

        <ul class="berg-knox-list">
          <li class="berg-knox-item">
            <!-- Coins / Single annuity -->
            <div class="berg-knox-icon" aria-hidden="true">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" style="display:block">
                <path d="M12 7c3.3 0 6-1.1 6-2.5S15.3 2 12 2S6 3.1 6 4.5S8.7 7 12 7Z" stroke="currentColor" stroke-width="1.8"/>
                <path d="M6 4.5V10c0 1.4 2.7 2.5 6 2.5s6-1.1 6-2.5V4.5" stroke="currentColor" stroke-width="1.8"/>
                <path d="M6 10v5.5C6 16.9 8.7 18 12 18s6-1.1 6-2.5V10" stroke="currentColor" stroke-width="1.8"/>
                <path d="M9 21h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
              </svg>
            </div>
            <div>
              <p class="berg-knox-title">Life annuity (single)</p>
              <div class="berg-knox-sub">Life annuity single product</div>
            </div>
          </li>

          <li class="berg-knox-item">
            <!-- Family / Users -->
            <div class="berg-knox-icon" aria-hidden="true">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" style="display:block">
                <path d="M9 11a3 3 0 1 0-3-3a3 3 0 0 0 3 3Z" stroke="currentColor" stroke-width="1.8"/>
                <path d="M17 11a2.8 2.8 0 1 0-2.8-2.8A2.8 2.8 0 0 0 17 11Z" stroke="currentColor" stroke-width="1.8"/>
                <path d="M3.5 20a5.5 5.5 0 0 1 11 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                <path d="M14.5 20a4.5 4.5 0 0 1 6 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
              </svg>
            </div>
            <div>
              <p class="berg-knox-title">Life pension for families</p>
              <div class="berg-knox-sub">Life annuity family product</div>
            </div>
          </li>

          <li class="berg-knox-item">
            <!-- Calendar + 74 (lump-sum from 74) -->
            <div class="berg-knox-icon" aria-hidden="true">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" style="display:block">
                <path d="M7 3v3M17 3v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                <path d="M4 7h16v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7Z" stroke="currentColor" stroke-width="1.8"/>
                <path d="M4 10h16" stroke="currentColor" stroke-width="1.8"/>
                <path d="M7.2 14.2h3.6v6H7.2v-6Z" stroke="currentColor" stroke-width="1.6"/>
                <path d="M13.8 15.2h2.8l-2.2 2.2a2.2 2.2 0 0 0 3.2 2.8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <div>
              <p class="berg-knox-title">Accident lump-sum payment from age 74</p>
              <div class="berg-knox-sub">Accident lump-sum payment from age 74</div>
            </div>
          </li>

          <li class="berg-knox-item">
            <!-- Child + Shield (capital payment up to 15) -->
            <div class="berg-knox-icon" aria-hidden="true">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" style="display:block">
                <path d="M9 11a3 3 0 1 0-3-3a3 3 0 0 0 3 3Z" stroke="currentColor" stroke-width="1.8"/>
                <path d="M3.5 20a5.5 5.5 0 0 1 9 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                <path d="M16.2 10.2l2.2 1.2v2.9c0 2.2-1.4 4.1-3.6 4.8l-.8.3-.8-.3c-2.2-.7-3.6-2.6-3.6-4.8v-2.9l2.2-1.2" stroke="currentColor" stroke-width="1.6"/>
              </svg>
            </div>
            <div>
              <p class="berg-knox-title">Accident capital payment up to age 15</p>
              <div class="berg-knox-sub">Accident capital payment up to age 15</div>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <!-- English text + CTA -->
    <div class="berg-bottom-box">
      <p class="mb-3">
        Each request for an insurance upgrade is handled individually.<br />
        If you would like any of the options listed above, please send us an enquiry to
        <a href="mailto:info@bergmembership.com">info@bergmembership.com</a> with a short description of the upgrade you want,
        so we can forward your request to our partner.
      </p>

      <div class="berg-actions">
        <a class="vs-btn style4" href="mailto:info@bergmembership.com">
          <span>SEND AN UPGRADE ENQUIRY</span>
        </a>

        <a class="berg-link" href="https://alpenverein.sichermitknox.com/" target="_blank" rel="noopener">
          More information on the partner’s website
        </a>
      </div>
    </div>
  </div>
</section>
<!--================= Benefits: Health & Custom Upgrades end =================-->

    
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
