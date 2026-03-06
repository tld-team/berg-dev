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
    <title>BERG Membership Program - Benefits</title>

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
        data-bg-src="./assets/img/berg-membership-contact.png"
      >
        <div class="container">
          <div class="row text-center">
            <div class="col-12">
              <div class="breadcrumb-content">
                <h1 class="breadcrumb-title">Contact</h1>
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

      <!--================= Contact Area Start =================-->
      <section class="vs-contact space pb-5" style="background-color:#fdf8f5">
        <div class="container">
          <div class="row g-4 gx-xl-5 overflow-hidden">
            <div class="col-lg-5">
              <div class="title-area text-start mb-2">
                <span class="sec-subtitle style-2">contact us</span>
                <h2 class="sec-title">Get in touch with us</h2>
              </div>
              <div class="vs-contact-info mt-3 mb-2">
                <p>
                  <span class="text-theme-color fw-bold">Address:</span>
                  Balkanska 18/5, 11000 Belgrade, Serbia
                </p>

                <div class="vs-contact-list">
                  <div class="contact-item">
                    <span class="icon">
                      <i class="fa-solid fa-phone-volume"></i>
                    </span>
                    <div class="info">
                      <h6 class="info-title">Customer Service :</h6>
                      <p>
                        <a href="tel:+381691516160">(+381)69 151 6160</a>
                      </p>
                    </div>
                  </div>

                  <div class="contact-item">
                    <span class="icon">
                      <i class="fa-light fa-envelope"></i>
                    </span>
                    <div class="info">
                      <h6 class="info-title">Contact &amp; Support :</h6>
                      <p>
                        <a
                          href="mailto:info@bergmembership.com"
                          style="text-transform: none"
                          >info@bergmembership.com</a
                        >
                      </p>
                    </div>
                  </div>
                </div>

                <div class="social-follow">
                  <span>Follow Us :</span>

                  <ul class="custom-ul">
                    <li>
                      <a
                        href="https://www.instagram.com/bergmembership/"
                        target="_blank"
                        rel="noopener"
                      >
                        <i class="fa-brands fa-instagram"></i>
                      </a>
                    </li>
                    <li>
                      <a href="#" target="_blank" rel="noopener">
                        <i class="fa-brands fa-facebook"></i>
                      </a>
                    </li>
                    <li>
                      <a href="#" target="_blank" rel="noopener">
                        <i class="fa-brands fa-linkedin-in"></i>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-7" >
              <form
              action="https://formsubmit.co/0f28fb814fdefc1905787c1ff7c3f2b0"
              method="POST"
              class="w100"
            >
              <input type="hidden" name="_subject" value="BERG Membership - Newsletter subscription" />
              <input type="hidden" name="_template" value="table" />
              <input type="hidden" name="_captcha" value="false" />
              <input type="text" name="_honey" style="display:none" tabindex="-1" autocomplete="off" />
              <input type="hidden" name="source" value="Contact form" />
                <div class="row">
                  <div class="col-md-6 form-group">
                    <input
                      name="fname"
                      type="text"
                      class="form-control"
                      placeholder="First Name*"
                      required
                      autocomplete="off"
                    />
                  </div>
                  <div class="col-md-6 form-group">
                    <input
                      name="fname"
                      type="text"
                      class="form-control"
                      placeholder="Last Name*"
                      required
                    />
                  </div>
                  <div class="col-md-6 form-group">
                    <input
                      name="email"
                      type="email"
                      class="form-control"
                      placeholder="Your Email*"
                      required
                    />
                  </div>
                  <div class="col-md-6 form-group">
                    <input
                      name="phone"
                      type="tel"
                      class="form-control"
                      placeholder="Your Phone*"
                      required
                    />
                  </div>
                  <div class="col-12 form-group">
                    <textarea
                      name="message"
                      class="form-control"
                      placeholder="Your Message..."
                      required
                    ></textarea>
                  </div>
                  <div class="col-12 form-group mt-2 mb-0">
                    <button class="vs-btn" type="submit">Send Message</button>
                  </div>
                  <p class="form-messages mb-5 mt-3"></p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
      <!--================= Contact Area end =================-->

      <!--================= Map Area start =================-->
      <div class="map-layout1" style="bckground-color:#fdf8f5 !important">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2830.497942448577!2d20.457564976602526!3d44.81141947675551!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x475a7aae8fd22661%3A0x5b969bfc85448c81!2sBalkanska%2018%2C%20Beograd!5e0!3m2!1sen!2srs!4v1767145032638!5m2!1sen!2srs"
          height="600"
          style="border: 0"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
      </div>
      <!--================= Map Area end =================-->
      
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
