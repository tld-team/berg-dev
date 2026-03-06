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
        data-bg-src="./assets/img/berg-membership-membership.png"
      >
        <div class="container">
          <div class="row text-center">
            <div class="col-12">
              <div class="breadcrumb-content">
                <h1 class="breadcrumb-title">Membership</h1>
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

      <!--================= MEMBERSHIP ORDER (like Alpenverein SK) start =================-->
      <section
        class="vs-tour-package space"
        id="membership-programs"
        style="background-color: #fdf8f5"
      >
        <div class="container">
          <div class="row justify-content-between align-items-center">
            <div class="col-12">
              <div class="title-area text-center">
                <span class="sec-subtitle fade-anim" data-direction="bottom">
                  MEMBERSHIP PROGRAMS
                </span>
                <h2 class="sec-title fade-anim" data-direction="top">
                  Choose the program that fits your adventure style.
                </h2>
              </div>
            </div>
            <!-- PLAN CARDS -->
            <div class="col-12">
              <div class="berg-order-plans">
                <!-- CARD 1: BERG EXPLORER (Adult + Eligible merged) -->
                <div
                  class="berg-plan-card tour-package-box bg-white-color text-center"
                  data-plan="explorer"
                >
                  <div class="tour-package-thumb">
                    <img
                      src="assets/img/berg-membership-berg-explorer.png"
                      alt="BERG Explorer"
                      class="w-100"
                    />
                  </div>

                  <div class="berg-plan-body tour-package-content">
                    <h3 class="title">
                      <span>BERG EXPLORER</span>
                    </h3>

                    <div class="berg-plan-meta">
                      <p class="mb-10"><strong>Cover:</strong> Worldwide</p>
                      <p class="mb-0">
                        <strong>SAR altitude:</strong> up to 6000m
                      </p>
                    </div>

                    <!-- Dropdown: Adult + Eligible types (bez cena) -->
                    <div class="berg-plan-select">
                      <label class="form-label mb-2"
                        ><strong>Choose member type</strong></label
                      >
                      <select
                        class="form-select berg-select"
                        data-role="explorerType"
                      >
                        <option value="adult">Adult (birth 1998 - 1962)</option>
                        <option value="senior">Senior (birth 1961 and older)</option>
                        <option value="junior">Junior (birth 1999 - 2007)</option>
                        <option value="mountain_rescuer">
                          Mountain rescuer
                        </option>
                        <option value="child">Child (birth 2008 and younger)</option>
                        <option value="disabled">Disabled (over 50% and including 50%)</option>
                      </select>
                    </div>

                    <div class="berg-plan-footer">
                      <p class="mb-0">
                        Official
                        <img
                          src="assets/img/partners/alpenverein.png"
                          style="height: 50px"
                          alt=""
                        />
                        partner
                      </p>
                    </div>

                    <div class="berg-plan-actions">
                      <button
                        type="button"
                        class="vs-btn style7 w-100 berg-buy-btn"
                      >
                        BUY NOW
                      </button>
                    </div>
                  </div>
                </div>

                <!-- CARD 2: FAMILY -->
                <div
                  class="berg-plan-card tour-package-box bg-white-color text-center"
                  data-plan="family"
                >
                  <div class="tour-package-thumb">
                    <img
                      src="assets/img/berg-membership-family.png"
                      alt="BERG Family"
                      class="w-100"
                    />
                  </div>

                  <div class="berg-plan-body tour-package-content">
                    <h3 class="title text-center">
                      <span>BERG FAMILY</span>
                    </h3>

                    <div class="berg-plan-meta">
                      <p class="mb-10"><strong>Cover:</strong> Worldwide</p>
                      <p class="mb-0">
                        <strong>SAR altitude:</strong> up to 6000m
                      </p>
                    </div>

                    <!-- Dropdown: Family options (po klijentu) -->
                    <div class="berg-plan-select">
                      <label class="form-label mb-2"
                        ><strong>Choose family option</strong></label
                      >
                      <select
                        class="form-select berg-select"
                        data-role="familyType"
                      >
                        <option value="couple">Married couple or partners (children free)</option>
                        <option value="single">Single parent with children (divorced, widowed, etc.)</option>
                      </select>
                    </div>

                    <div class="berg-plan-footer">
                      <p class="mb-0">
                        Official
                        <img
                          src="assets/img/partners/alpenverein.png"
                          style="height: 50px"
                          alt=""
                        />
                        partner
                      </p>
                    </div>

                    <div class="berg-plan-actions">
                      <button
                        type="button"
                        class="vs-btn style7 w-100 berg-buy-btn"
                      >
                        BUY NOW
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Small note (kao na referenci, bez cena) -->
              <div class="text-center mt-25">
                <p class="mb-30">
                  All programs include the same worldwide travel and mountain
                  rescue coverage up to 6,000 m.
                </p>
              </div>

              <!-- BIG CTA (per klijentu) -->
              <div class="col-12 mt-50 mb-25 text-center">
                <a href="benefits.php" class="vs-btn style7">
                  EXPLORE ALL BENEFITS
                </a>
              </div>
            </div>

            <!-- ORDER FLOW (Step 1/2/3) -->
            <div class="col-12">
                <form
                    id="bergMembershipForm"
                    action="membership-submit.php"
                    method="POST"
                    >
                    <!-- FormSubmit settings -->
                    <input type="hidden" name="_subject" value="BERG Membership - Membership Programs Form" />
                    <input type="hidden" name="_template" value="table" />
                    <input type="hidden" name="_captcha" value="false" />
                    <input type="text" name="_honey" style="display:none" tabindex="-1" autocomplete="off" />
                    <input type="hidden" name="source" value="Membership Programs" />

              <div id="berg-order" class="berg-order mt-40" hidden>
                <div class="berg-steps">
                  <div class="berg-step is-active" data-step="1">
                    <span class="berg-step-num">1</span>
                    <span class="berg-step-label">CHOOSE CATEGORY</span>
                  </div>
                  <div class="berg-step" data-step="2">
                    <span class="berg-step-num">2</span>
                    <span class="berg-step-label">PERSONAL DATA</span>
                  </div>
                  <div class="berg-step" data-step="3">
                    <span class="berg-step-num">3</span>
                    <span class="berg-step-label">CONTACTS</span>
                  </div>
                </div>

                <!-- STEP 1 -->
                <div class="berg-step-panel" data-step-panel="1">
                  <div class="berg-panel-card">
                    <h4 class="mb-15">1. Choose category</h4>

                    <div class="row g-3">
                      <div class="col-lg-6">
                        <div class="berg-summary">
                          <p class="mb-5">
                            <strong>Selected program:</strong>
                            <span id="bergSelectedPlan">—</span>
                          </p>
                          <p class="mb-0">
                            <strong>Option:</strong>
                            <span id="bergSelectedOption">—</span>
                          </p>
                        </div>
                      </div>

                      <div class="col-lg-6">
                        <div class="berg-actions-row">
                          <button
                            type="button"
                            class="vs-btn style7 berg-next"
                            data-next="2"
                          >
                            Next step
                          </button>
                          <button
                            type="button"
                            class="vs-btn style7 berg-cancel"
                          >
                            Cancel
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- STEP 2 -->
                <div class="berg-step-panel" data-step-panel="2" hidden>
                  <div class="berg-panel-card">
                    <h4 class="mb-15 text-center">2. Personal data</h4>

                    <!-- MAIN PERSON -->
                    <div class="row g-3">
                      <div class="col-md-6">
                        <label class="form-label">First name *</label>
                        <input
                          class="form-control"
                          type="text"
                          name="first_name"
                          required
                        />
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Last name *</label>
                        <input
                          class="form-control"
                          type="text"
                          name="last_name"
                          required
                        />
                      </div>

                      <div class="col-md-4">
                        <label class="form-label">Year of birth *</label>
                        <input
                          class="form-control"
                          type="number"
                          name="birth_year"
                          min="1900"
                          max="2100"
                          required
                        />
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Month of birth *</label>
                        <select class="form-select" name="birth_month" required>
                          <option value="">—</option>
                          <option>January</option>
                          <option>February</option>
                          <option>March</option>
                          <option>April</option>
                          <option>May</option>
                          <option>June</option>
                          <option>July</option>
                          <option>August</option>
                          <option>September</option>
                          <option>October</option>
                          <option>November</option>
                          <option>December</option>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Day of birth *</label>
                        <input
                          class="form-control"
                          type="number"
                          name="birth_day"
                          min="1"
                          max="31"
                          required
                        />
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Gender *</label>
                        <select class="form-select" name="gender" required>
                          <option value="">—</option>
                          <option value="male">Male</option>
                          <option value="female">Female</option>
                        </select>
                      </div>
                    </div>

                    <!-- PARTNER (ONLY FOR FAMILY) -->
                    <div
                      id="bergPartnerBlock"
                      class="berg-subblock mt-25"
                      hidden
                    >
                      <h5 class="mb-15">Husband/wife or partner</h5>

                      <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label">First name *</label>
                          <input
                            class="form-control"
                            type="text"
                            name="partner_first_name"
                          />
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Last name *</label>
                          <input
                            class="form-control"
                            type="text"
                            name="partner_last_name"
                          />
                        </div>

                        <div class="col-md-4">
                          <label class="form-label">Year of birth *</label>
                          <input
                            class="form-control"
                            type="number"
                            name="partner_birth_year"
                            min="1900"
                            max="2100"
                          />
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Month of birth *</label>
                          <select
                            class="form-select"
                            name="partner_birth_month"
                          >
                            <option value="">—</option>
                            <option>January</option>
                            <option>February</option>
                            <option>March</option>
                            <option>April</option>
                            <option>May</option>
                            <option>June</option>
                            <option>July</option>
                            <option>August</option>
                            <option>September</option>
                            <option>October</option>
                            <option>November</option>
                            <option>December</option>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Day of birth *</label>
                          <input
                            class="form-control"
                            type="number"
                            name="partner_birth_day"
                            min="1"
                            max="31"
                          />
                        </div>

                        <div class="col-md-6">
                          <label class="form-label">Gender *</label>
                          <select class="form-select" name="partner_gender">
                            <option value="">—</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                          </select>
                        </div>
                      </div>

                      <!-- CHILDREN -->
                      <div class="mt-25">
                        <div
                          class="d-flex align-items-center justify-content-between flex-wrap gap-2"
                        >
                          <h5 class="mb-0">Children</h5>
                          <button
                            type="button"
                            class="vs-btn style7 berg-add-child"
                          >
                            Add child
                          </button>
                        </div>

                        <div id="bergChildrenList" class="mt-15"></div>

                        <template id="bergChildTpl">
                          <div class="berg-child-card">
                            <div
                              class="d-flex align-items-center justify-content-between"
                            >
                              <h6 class="mb-0 berg-child-title">Child</h6>
                              <button
                                type="button"
                                class="berg-child-remove"
                                aria-label="Remove child"
                              >
                                ×
                              </button>
                            </div>

                            <div class="row g-3 mt-1">
                              <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <select
                                  class="form-select"
                                  name="child_category[]"
                                >
                                  <option value="student">
                                    Student aged 19 to 27 years
                                  </option>
                                  <option value="child">
                                    Child up to 18 years
                                  </option>
                                </select>
                              </div>

                              <div class="col-md-6">
                                <label class="form-label">First name *</label>
                                <input
                                  class="form-control"
                                  type="text"
                                  name="child_first_name[]"
                                />
                              </div>
                              <div class="col-md-6">
                                <label class="form-label">Last name *</label>
                                <input
                                  class="form-control"
                                  type="text"
                                  name="child_last_name[]"
                                />
                              </div>

                              <div class="col-md-4">
                                <label class="form-label">Year *</label>
                                <input
                                  class="form-control"
                                  type="number"
                                  name="child_birth_year[]"
                                  min="1900"
                                  max="2100"
                                />
                              </div>
                              <div class="col-md-4">
                                <label class="form-label">Month *</label>
                                <select
                                  class="form-select"
                                  name="child_birth_month[]"
                                >
                                  <option value="">—</option>
                                  <option>January</option>
                                  <option>February</option>
                                  <option>March</option>
                                  <option>April</option>
                                  <option>May</option>
                                  <option>June</option>
                                  <option>July</option>
                                  <option>August</option>
                                  <option>September</option>
                                  <option>October</option>
                                  <option>November</option>
                                  <option>December</option>
                                </select>
                              </div>
                              <div class="col-md-4">
                                <label class="form-label">Day *</label>
                                <input
                                  class="form-control"
                                  type="number"
                                  name="child_birth_day[]"
                                  min="1"
                                  max="31"
                                />
                              </div>

                              <div class="col-md-6">
                                <label class="form-label">Gender *</label>
                                <select
                                  class="form-select"
                                  name="child_gender[]"
                                >
                                  <option value="">—</option>
                                  <option value="male">Male</option>
                                  <option value="female">Female</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </template>
                      </div>
                    </div>

                    <div class="berg-actions-row mt-25">
                      <button
                        type="button"
                        class="vs-btn style7 berg-prev"
                        data-prev="1"
                      >
                        Back
                      </button>
                      <button
                        type="button"
                        class="vs-btn style7 berg-next"
                        data-next="3"
                      >
                        Next step
                      </button>
                    </div>
                  </div>
                </div>

                <!-- STEP 3 -->
                <div class="berg-step-panel" data-step-panel="3" hidden>
                  <div class="berg-panel-card">
                    <h4 class="mb-15 text-center">3. Contacts</h4>

                    <div class="row g-3">
                      <div class="col-md-6">
                        <label class="form-label">Email *</label>
                        <input
                          class="form-control"
                          type="email"
                          name="email"
                          required
                        />
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Telephone *</label>
                        <input
                          class="form-control"
                          type="tel"
                          name="phone"
                          required
                        />
                      </div>

                      <div class="col-md-8">
                        <label class="form-label">Street *</label>
                        <input
                          class="form-control"
                          type="text"
                          name="street"
                          required
                        />
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">House number *</label>
                        <input
                          class="form-control"
                          type="text"
                          name="house_number"
                          required
                        />
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">City *</label>
                        <input
                          class="form-control"
                          type="text"
                          name="city"
                          required
                        />
                      </div>
                      <div class="col-md-3">
                        <label class="form-label">ZIP *</label>
                        <input
                          class="form-control"
                          type="text"
                          name="zip"
                          required
                        />
                      </div>
                      <div class="col-md-3">
                        <label class="form-label">Country *</label>
                        <input
                          class="form-control"
                          type="text"
                          name="country"
                          required
                        />
                      </div>
                    </div>

                    <div class="berg-actions-row mt-25">
                      <button
                        type="button"
                        class="vs-btn style7 berg-prev"
                        data-prev="2"
                      >
                        Back
                      </button>
                      <button type="submit" class="vs-btn style7 berg-submit">
                            Place order
                      </button>

                    </div>

                    <div id="bergSuccess" class="berg-success mt-20" hidden>
                      <strong>Thank you.</strong> Payment instructions will be
                      delivered via email (integration placeholder).
                    </div>
                  </div>
                </div>

                <input type="hidden" id="bergPlanValue" name="selected_plan" />
                <input type="hidden" id="bergOptionValue" name="selected_option" />
                
                </form>

              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= MEMBERSHIP ORDER end =================-->
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
