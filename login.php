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
  // ako je već ulogovan, pošalji ga na home (ili promeni gde hoćeš)
  header('Location: my-profile.php');
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

      header('Location: my-profile.php');
      exit;
    } else {
      $errorMsg = 'Pogrešan email ili password.';
    }
  }
}
?>


<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="author" content="https://is.gd/a33FWT" />
    <title>BERG Membership Program - Login</title>

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
        data-bg-src="./assets/img/berg-membership-login.png"
      >
        <div class="container">
          <div class="row text-center">
            <div class="col-12">
              <div class="breadcrumb-content">
                <h1 class="breadcrumb-title">Login</h1>
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

      <!--================= Login Area start =================-->
      <section
        class="vs-about position-relative space berg-login pb-5"
        style="background-color: #f0f1e9"
      >
        <div class="container">
          <div class="row">
            <div class="col-lg-auto mx-auto">
              <div class="title-area text-center">
                <span
                  class="sec-subtitle text-capitalize fade-anim"
                  data-direction="top"
                >
                  BERG Membership Login
                </span>
                <h2 class="sec-title fade-anim" data-direction="bottom">
                  Access your member account
                </h2>
                <p class="berg-login-subtext">
                  Sign in to manage your membership, view documents, and access
                  exclusive benefits.
                </p>
              </div>
            </div>
          </div>

          <!-- LOGIN FORM -->
          <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-7 col-xl-6">
              <div class="berg-login-card">
                <h4 class="berg-login-title text-center mb-25">Member Login</h4>

                <form
                  class="berg-login-form"
                  action="login.php"
                  method="post"
                  novalidate
                >
                  <div class="row g-3">
                    <div class="col-12">
                      <label class="form-label">Username or Email *</label>
                      <input
                        class="form-control"
                        type="text"
                        name="username"
                        placeholder="Enter your username or email"
                        required
                        value="<?php echo h($emailValue); ?>"
                      />
                    </div>

                    <div class="col-12">
                      <label class="form-label">Password *</label>
                      <div class="berg-pass-wrap">
                        <input
                          class="form-control berg-pass-input"
                          type="password"
                          name="password"
                          placeholder="Enter your password"
                          required
                        />
                        <button
                          type="button"
                          class="berg-pass-toggle"
                          aria-label="Show/Hide password"
                        >
                          Show
                        </button>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="berg-login-row">
                        <label class="berg-check">
                          <input type="checkbox" name="remember" />
                          <span>Remember me</span>
                        </label>

                        <a class="berg-forgot" href="#">Forgot password?</a>
                      </div>
                    </div>

                    <div class="col-12">
                      <button
                        type="submit"
                        class="vs-btn style9 w-100 berg-login-btn"
                      >
                        <span>LOGIN</span>
                      </button>
                    </div>

                    <div class="col-12">
                      <div class="berg-login-foot text-center">
                        <span>New here?</span>
                        <a href="membership.php">Become a member</a>
                      </div>
                    </div>
                  </div>
                </form>

                <!-- OPTIONAL: message placeholders -->
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
