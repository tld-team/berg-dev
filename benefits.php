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
        data-bg-src="./assets/img/berg-membership-benefits.png"
      >
        <div class="container">
          <div class="row text-center">
            <div class="col-12">
              <div class="breadcrumb-content">
                <h1 class="breadcrumb-title">Benefits</h1>
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
                <a href="#rescue-protection" class="vs-btn style4-secundary">
                  <span>RESCUE PROTECTION</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Breadcrumb Area end =================-->

      <!--================= Benefits Tabs (Clickable Tiles) Start =================-->
      <section
        class="vs-activities space berg-benefits-tabs"
        id="benefits-tabs"
        style="background-color: #fdf8f5"
      >
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-xl-10">
              <div class="title-area text-center">
                <span class="sec-subtitle">BENEFITS</span>
                <h2 class="sec-title">What you get with BERG</h2>
                <p class="sec-text mb-0">
                  Tap a benefit to jump to the details below.
                </p>
              </div>
            </div>
          </div>

          <div class="row gx-3 gy-3">
            <!-- TAB 1 -->
            <div class="col-md-6 col-lg-12">
              <div
                class="activities-box benefit-tile"
                data-href="#rescue-protection"
                role="link"
                tabindex="0"
              >
                <figure class="activities-thumb">
                  <img
                    src="./assets/img/berg-membership-worldwide-rescue-protection.png"
                    alt="Worldwide Rescue Protection"
                    class="w-100"
                  />

                  <!-- OVERLAY CONTENT (sve je UNUTAR slike) -->
                  <figcaption class="activities-content">
                    <h5 class="title mb-0">Worldwide Rescue Protection</h5>

                    <span class="info" style="color: white">
                      Worldwide leisure, accident, and international travel
                      protection — included in every membership (up to 6,000 m).
                    </span>

                    <span class="benefit-tile-cta">
                      <a
                        href="#rescue-protection"
                        class="vs-btn style4"
                        >SEE DETAILS</a
                      >
                    </span>
                  </figcaption>
                </figure>
              </div>
            </div>

            <!-- TAB 2 -->
            <div class="col-md-6 col-lg-3">
              <div
                class="activities-box benefit-tile"
                data-href="#gear-rental-first-aid"
                role="link"
                tabindex="0"
              >
                <figure class="activities-thumb">
                  <img
                    src="./assets/img/berg-membership-gear-rental-first-aid.png"
                    alt="Gear, Rental & First Aid"
                    class="w-100"
                  />

                  <figcaption class="activities-content">
                    <h5 class="title mb-0">Gear, Rental &amp; First Aid</h5>

                    <span class="info" style="color: white;">Member savings in stores, rentals, and first aid kits.</span>

                    <span class="benefit-tile-cta">
                      <a href="gear-rental-first-aid.php" class="vs-btn style4">SEE DETAILS</a>
                    </span>
                  </figcaption>
                </figure>
              </div>
            </div>

            <!-- TAB 3 -->
            <div class="col-md-6 col-lg-3">
              <div
                class="activities-box benefit-tile"
                data-href="#tours-experiences"
                role="link"
                tabindex="0"
              >
                <figure class="activities-thumb">
                  <img
                    src="./assets/img/berg-membership-tours-experiences.png"
                    alt="Tours & Experiences"
                    class="w-100"
                  />

                  <figcaption class="activities-content">
                    <h5 class="title mb-0">Tours &amp; Experiences</h5>

                    <span class="info" style="color: white;">Discounts on tours and accommodation.</span>

                    <span class="benefit-tile-cta">
                      <a href="tours-experiences.php" class="vs-btn style4">SEE DETAILS</a>
                    </span>
                  </figcaption>
                </figure>
              </div>
            </div>

            <!-- TAB 4 -->
            <div class="col-md-6 col-lg-3">
              <div
                class="activities-box benefit-tile"
                data-href="#courses-events"
                role="link"
                tabindex="0"
              >
                <figure class="activities-thumb">
                  <img
                    src="./assets/img/berg-membership-courses-events.png"
                    alt="Courses & Events"
                    class="w-100"
                  />

                  <figcaption class="activities-content">
                    <h5 class="title mb-0">Courses &amp; Events</h5>

                    <span class="info" style="color: white;">Access to courses, seminars, and events.</span>

                    <span class="benefit-tile-cta">
                      <a href="courses-events.php" class="vs-btn style4">SEE DETAILS</a>
                    </span>
                  </figcaption>
                </figure>
              </div>
            </div>

            <!-- TAB 5 -->
            <div class="col-md-6 col-lg-3">
              <div
                class="activities-box benefit-tile"
                data-href="#health-custom-upgrades"
                role="link"
                tabindex="0"
              >
                <figure class="activities-thumb">
                  <img
                    src="./assets/img/berg-membership-health-custom-upgrades.png"
                    alt="Health & Custom Upgrades"
                    class="w-100"
                  />

                  <figcaption class="activities-content">
                    <h5 class="title mb-0">Health &amp; Custom Upgrades</h5>

                    <span class="info" style="color: white;">
                      Health checkup savings and optional upgrades. <em>Benefits vary by plan.</em>
                    </span>

                    <span class="benefit-tile-cta">
                      <a href="helth-custom-upgrades.php" class="vs-btn style4">SEE DETAILS</a>
                    </span>
                  </figcaption>
                </figure>
              </div>
            </div>


          <!-- CTA -->
          <div class="row">
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
      <!--================= Benefits Tabs (Clickable Tiles) End =================-->

      <!--================= Coverage Overview Table (TAB 1 / #rescue) =================-->
      <section id="rescue-protection" class="vs-faq space coverage-table" style="background-color: #fdf8f5;" data-bg-src="assets/img/bg/destination.png">
        <div class="container">

          <div class="row">
            <div class="col-lg-12">
              <div class="title-area text-center">
                <span class="sec-subtitle text-capitalize fade-anim" data-direction="top">Insurance</span>
                <h2 class="sec-title fade-anim" data-direction="bottom">Examples of Coverage – Overview Table</h2>
                <p class="mt-2 mb-0">The example appears when you click on the corresponding row in the table.</p>
              </div>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-12">

              <!-- WHITE BOX (kao Useful links) -->
              <div class="coverage-table-box">

                <!-- header row -->
                <div class="coverage-table__head">
                  <div class="coverage-table__col coverage-table__col--left">Insurance coverage</div>
                  <div class="coverage-table__col coverage-table__col--right">Insured amount</div>
                </div>

                <!-- accordion rows -->
                <div class="accordion coverage-accordion" id="coverageAccordion">

                  <!-- 1 -->
                  <div class="accordion-item coverage-item">
                    <h3 class="accordion-header" id="cov-h1">
                      <button class="accordion-button collapsed coverage-btn" type="button"
                              data-bs-toggle="collapse" data-bs-target="#cov-c1"
                              aria-expanded="false" aria-controls="cov-c1">
                        <span class="coverage-left">
                          <span class="coverage-icon" aria-hidden="true"></span>
                          <span class="coverage-title">Rescue or search operation</span>
                        </span>
                        <span class="coverage-amount">up to 25 000 €</span>
                      </button>
                    </h3>

                    <div id="cov-c1" class="accordion-collapse collapse" aria-labelledby="cov-h1" data-bs-parent="#coverageAccordion">
                      <div class="accordion-body coverage-body">
                        <div class="coverage-bodygrid">
                          <div class="coverage-details">
                            <p>
                              Examples of leisure-activity pursuits: ski-touring, freeride, mountain biking,
                              rock climbing, hiking, running, rafting, surfing, diving to 40 m, and others.<br>
                              Rescue operation by mountain services or other rescue units worldwide, including the home country.<br>
                              Use of rescue techniques such as a helicopter, off-road vehicle, etc.<br>
                              Rescue, search, and extrication in an emergency situation, even if you are not injured but your life is at risk.
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- 2 -->
                  <div class="accordion-item coverage-item">
                    <h3 class="accordion-header" id="cov-h2">
                      <button class="accordion-button collapsed coverage-btn" type="button"
                              data-bs-toggle="collapse" data-bs-target="#cov-c2"
                              aria-expanded="false" aria-controls="cov-c2">
                        <span class="coverage-left">
                          <span class="coverage-icon" aria-hidden="true"></span>
                          <span class="coverage-title">Treatment and hospital stay abroad</span>
                        </span>
                        <span class="coverage-amount">up to 10 000 €</span>
                      </button>
                    </h3>

                    <div id="cov-c2" class="accordion-collapse collapse" aria-labelledby="cov-h2" data-bs-parent="#coverageAccordion">
                      <div class="accordion-body coverage-body">
                        <div class="coverage-bodygrid">
                          <div class="coverage-details">
                            <p>
                              Emergency medical care, including doctor-prescribed medication and transport to the nearest suitable hospital,
                              is covered up to €10,000. Of that amount, €2,000 is allocated for outpatient care, including prescribed medicines.
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- 3 -->
                  <div class="accordion-item coverage-item">
                    <h3 class="accordion-header" id="cov-h3">
                      <button class="accordion-button collapsed coverage-btn" type="button"
                              data-bs-toggle="collapse" data-bs-target="#cov-c3"
                              aria-expanded="false" aria-controls="cov-c3">
                        <span class="coverage-left">
                          <span class="coverage-icon" aria-hidden="true"></span>
                          <span class="coverage-title">Transport of an injured person from abroad</span>
                        </span>
                        <span class="coverage-amount">Unlimited</span>
                      </button>
                    </h3>

                    <div id="cov-c3" class="accordion-collapse collapse" aria-labelledby="cov-h3" data-bs-parent="#coverageAccordion">
                      <div class="accordion-body coverage-body">
                        <div class="coverage-bodygrid">
                          <div class="coverage-details">
                            <p>
                              Transportation back to your home country is covered without limit for both you and a close companion
                              who accompanies you, under defined medical conditions.
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- 4 -->
                  <div class="accordion-item coverage-item">
                    <h3 class="accordion-header" id="cov-h4">
                      <button class="accordion-button collapsed coverage-btn" type="button"
                              data-bs-toggle="collapse" data-bs-target="#cov-c4"
                              aria-expanded="false" aria-controls="cov-c4">
                        <span class="coverage-left">
                          <span class="coverage-icon" aria-hidden="true"></span>
                          <span class="coverage-title">European third party liability</span>
                        </span>
                        <span class="coverage-amount">up to 3 000 000 €</span>
                      </button>
                    </h3>

                    <div id="cov-c4" class="accordion-collapse collapse" aria-labelledby="cov-h4" data-bs-parent="#coverageAccordion">
                      <div class="accordion-body coverage-body">
                        <div class="coverage-bodygrid">
                          <div class="coverage-details">
                            <p>
                              Coverage includes the obligation to compensate for damages caused to health and property,
                              up to €3 million. Deductible for property damage is €200.
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- 5 -->
                  <div class="accordion-item coverage-item">
                    <h3 class="accordion-header" id="cov-h5">
                      <button class="accordion-button collapsed coverage-btn" type="button"
                              data-bs-toggle="collapse" data-bs-target="#cov-c5"
                              aria-expanded="false" aria-controls="cov-c5">
                        <span class="coverage-left">
                          <span class="coverage-icon" aria-hidden="true"></span>
                          <span class="coverage-title">Criminal-law protection (court costs) in Europe</span>
                        </span>
                        <span class="coverage-amount">up to 35 000 €</span>
                      </button>
                    </h3>

                    <div id="cov-c5" class="accordion-collapse collapse" aria-labelledby="cov-h5" data-bs-parent="#coverageAccordion">
                      <div class="accordion-body coverage-body">
                        <div class="coverage-bodygrid">
                          <div class="coverage-details">
                            <p>
                              Legal expenses (experts, interpreters, court fees, etc.) are covered under the policy conditions.
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div><!-- /accordion -->

              </div><!-- /coverage-table-box -->

            </div>
          </div>

        </div>
      </section>
      <!--================= Coverage Overview Table end =================-->


      <!--================= Tour Package Area start =================-->
      <section class="vs-tour-package space" style="background-color: #fdf8f5;">
        <div class="container">
          <div class="row">
            <div class="col-lg-auto mx-auto">
              <div class="title-area text-center">
                <span class="sec-subtitle text-capitalize fade-anim" data-direction="top">Insurance guide</span>
                <h2 class="sec-title fade-anim" data-direction="bottom">
                  The complete insurance terms are available here
                </h2>
                <h2 class="sec-title fade-anim" data-direction="bottom">
                  <a href="insurance.php#php" style="color: #75754f;">Introduction to insurence</a>
                </h2>
              </div>
            </div>
          </div>

          <div class="row g-4">

            <!-- CARD 1 -->
            <div class="col-md-6">
              <div class="insurance-guide-card" data-card>
                <div class="insurance-guide-head">
                  <div class="insurance-guide-icon">
                    <!-- Helicopter / rescue (cartoon style) -->
                    <svg width="64" height="64" viewBox="0 0 64 64" role="img" aria-label="Rescue icon" xmlns="http://www.w3.org/2000/svg">
                      <g stroke="#2F2F2F" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                        <!-- rotor -->
                        <path d="M14 16h36" />
                        <path d="M32 13v10" />
                        <!-- tail -->
                        <path d="M42 26h10l4 4" fill="none"/>
                        <!-- body -->
                        <path d="M18 26h22c4 0 7 3 7 7v2c0 4-3 7-7 7H22c-4 0-7-3-7-7v-2c0-4 3-7 7-7z" fill="#F2C94C"/>
                        <!-- cockpit -->
                        <path d="M24 28h10c2 0 4 2 4 4v4H24c-2 0-4-2-4-4v-1c0-2 2-3 4-3z" fill="#8EC5FF"/>
                        <!-- skids -->
                        <path d="M18 44h26" />
                        <path d="M20 48h22" />
                        <path d="M20 44v4M42 44v4" />
                        <!-- winch -->
                        <path d="M40 35v12" />
                        <path d="M40 47c0 3 4 3 4 0" />
                      </g>
                    </svg>
                  </div>

                  <div class="insurance-guide-main">
                    <button type="button"
                      class="insurance-guide-title js-ins-toggle"
                      data-target="insGuide1"
                      aria-controls="insGuide1"
                      aria-expanded="false">
                      Rescue or search operation (including the use of a helicopter)
                    </button>

                    <div class="insurance-guide-meta">
                      <div class="insurance-guide-amount">up to 25 000 €</div>

                      <button type="button"
                        class="vs-btn style9 js-ins-toggle"
                        data-target="insGuide1"
                        aria-controls="insGuide1"
                        aria-expanded="false">
                        <span>MORE INFO</span>
                      </button>
                    </div>
                  </div>
                </div>

                <div class="collapse insurance-guide-collapse" id="insGuide1">
                  <div class="insurance-guide-body">
                    <p>
                      Year-round, worldwide, during leisure time; Rescue costs are those costs incurred by local rescue
                      organisations (including the costs of rescue organisations from the neighbouring country in the event
                      of incidents near borders), which are necessary if the insured party has an emergency/accident or must
                      be rescued from mountain or aquatic distress or from off-road terrain, either injured or uninjured
                      (the same applies accordingly in the event of death).
                    </p>

                    <a class="insurance-guide-link" href="insurance.php#rescue" rel="noopener">
                      Complete terms &gt; Rescue operations from off-road terrain
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <!-- CARD 2 -->
            <div class="col-md-6">
              <div class="insurance-guide-card" data-card>
                <div class="insurance-guide-head">
                  <div class="insurance-guide-icon">
                    <!-- Hospital (cartoon style) -->
                    <svg width="64" height="64" viewBox="0 0 64 64" role="img" aria-label="Hospital icon" xmlns="http://www.w3.org/2000/svg">
                      <g stroke="#2F2F2F" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 20h28c3 0 5 2 5 5v24c0 3-2 5-5 5H18c-3 0-5-2-5-5V25c0-3 2-5 5-5z" fill="#E9EEF2"/>
                        <!-- windows -->
                        <g fill="#8EC5FF" stroke="none">
                          <rect x="20" y="28" width="6" height="6" rx="1.2"/>
                          <rect x="29" y="28" width="6" height="6" rx="1.2"/>
                          <rect x="38" y="28" width="6" height="6" rx="1.2"/>
                          <rect x="20" y="37" width="6" height="6" rx="1.2"/>
                          <rect x="38" y="37" width="6" height="6" rx="1.2"/>
                        </g>
                        <!-- door -->
                        <path d="M30 39h8v15h-8z" fill="#FDF8F5"/>
                        <!-- cross sign -->
                        <path d="M28 14h12v10H28z" fill="#FDF8F5"/>
                        <path d="M34 15.5v7" stroke="#D0021B"/>
                        <path d="M30.5 19h7" stroke="#D0021B"/>
                      </g>
                    </svg>
                  </div>

                  <div class="insurance-guide-main">
                    <button type="button"
                      class="insurance-guide-title js-ins-toggle"
                      data-target="insGuide2"
                      aria-controls="insGuide2"
                      aria-expanded="false">
                      Hospital stay abroad (in case of injury or illness)
                    </button>

                    <div class="insurance-guide-meta">
                      <div class="insurance-guide-amount">up to 10 000 €</div>

                      <button type="button"
                        class="vs-btn style9 js-ins-toggle"
                        data-target="insGuide2"
                        aria-controls="insGuide2"
                        aria-expanded="false">
                        <span>MORE INFO</span>
                      </button>
                    </div>
                  </div>
                </div>

                <div class="collapse insurance-guide-collapse" id="insGuide2">
                  <div class="insurance-guide-body">
                    <p>
                      It applies during the first 8 weeks (56 days) of each trip abroad for the costs of urgent,
                      necessary medical treatment—including medication prescribed by a doctor—and for essential
                      medical transport to the nearest suitable hospital, up to €10,000. From that amount, €2,000 is
                      allocated for outpatient care, including prescribed drugs. When receiving hospital treatment,
                      you must present the European Health Insurance Card (EHIC) and contact Europ Assistance. If you
                      travel to a country (e.g., the United States, Turkey, the Canary Islands, Australia) where the
                      €10,000 limit may be insufficient you can purchase additional
                      <a href="#" target="_blank" rel="noopener">coverage for a higher sum</a>.
                    </p>

                    <a class="insurance-guide-link" href="insurance.php#hospital" rel="noopener">
                      Complete terms &gt; Medical treatment abroad and transport
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <!-- CARD 3 -->
            <div class="col-md-6">
              <div class="insurance-guide-card" data-card>
                <div class="insurance-guide-head">
                  <div class="insurance-guide-icon">
                    <!-- Plane / transport (cartoon style) -->
                    <svg width="64" height="64" viewBox="0 0 64 64" role="img" aria-label="Transport icon" xmlns="http://www.w3.org/2000/svg">
                      <g stroke="#2F2F2F" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                        <!-- runway -->
                        <path d="M12 50h40" />
                        <path d="M18 46h16" opacity="0.8"/>
                        <!-- plane -->
                        <path d="M18 32l25-7c2-.6 4 .6 4.6 2.6l.6 2-12 3 9 9-3 3-11-8-5 1.2 2 7-3 .8-5-7-5 1.2c-1.8.4-3.6-.7-4-2.5l-.6-2.2c-.4-1.8.7-3.6 2.5-4z" fill="#F2C94C"/>
                        <!-- window -->
                        <circle cx="41" cy="28" r="2" fill="#8EC5FF" stroke="none"/>
                      </g>
                    </svg>
                  </div>

                  <div class="insurance-guide-main">
                    <button type="button"
                      class="insurance-guide-title js-ins-toggle"
                      data-target="insGuide3"
                      aria-controls="insGuide3"
                      aria-expanded="false">
                      Transport of an injured person from abroad
                    </button>

                    <div class="insurance-guide-meta">
                      <div class="insurance-guide-amount">in unlimited amount</div>

                      <button type="button"
                        class="vs-btn style9 js-ins-toggle"
                        data-target="insGuide3"
                        aria-controls="insGuide3"
                        aria-expanded="false">
                        <span>MORE INFO</span>
                      </button>
                    </div>
                  </div>
                </div>

                <div class="collapse insurance-guide-collapse" id="insGuide3">
                  <div class="insurance-guide-body">
                    <p>
                      It applies during the first 8 weeks (56 days) of each trip abroad. The costs for medically
                      justified transport of a sick person from abroad to a hospital in the home country (repatriation)
                      are covered for the insured individual and also for a close accompanying person, without any limit
                      on the amount.
                    </p>

                    <a class="insurance-guide-link" href="insurance.php#transport" rel="noopener">
                      Complete terms &gt; Transport of a sick person from abroad
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <!-- CARD 4 -->
            <div class="col-md-6">
              <div class="insurance-guide-card" data-card>
                <div class="insurance-guide-head">
                  <div class="insurance-guide-icon">
                    <!-- Liability (person + document, cartoon style) -->
                    <svg width="64" height="64" viewBox="0 0 64 64" role="img" aria-label="Liability icon" xmlns="http://www.w3.org/2000/svg">
                      <g stroke="#2F2F2F" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                        <!-- document -->
                        <path d="M34 16h16c2 0 3 1 3 3v26c0 2-1 3-3 3H34c-2 0-3-1-3-3V19c0-2 1-3 3-3z" fill="#FDF8F5"/>
                        <path d="M37 23h10M37 28h10M37 33h7" opacity="0.85"/>
                        <!-- person -->
                        <circle cx="20" cy="26" r="6" fill="#E9EEF2"/>
                        <path d="M10 48c2-10 26-10 28 0" fill="#E9EEF2"/>
                        <!-- accent badge -->
                        <circle cx="48" cy="46" r="7" fill="#F2C94C"/>
                        <path d="M45 46h6M48 43v6" />
                      </g>
                    </svg>
                  </div>

                  <div class="insurance-guide-main">
                    <button type="button"
                      class="insurance-guide-title js-ins-toggle"
                      data-target="insGuide4"
                      aria-controls="insGuide4"
                      aria-expanded="false">
                      European third party liability
                    </button>

                    <div class="insurance-guide-meta">
                      <div class="insurance-guide-amount">up to 3 000 000 €</div>

                      <button type="button"
                        class="vs-btn style9 js-ins-toggle"
                        data-target="insGuide4"
                        aria-controls="insGuide4"
                        aria-expanded="false">
                        <span>MORE INFO</span>
                      </button>
                    </div>
                  </div>
                </div>

                <div class="collapse insurance-guide-collapse" id="insGuide4">
                  <div class="insurance-guide-body">
                    <p>
                      If you cause damage to another person – coverage includes the obligation to compensate for injuries
                      to health and property damage up to €3 million. The deductible (co-payment) for property damage is €200.
                    </p>

                    <p>
                      If someone causes damage to you – the insurance protection covers the cost of your lawyer’s advice
                      up to €500 when you pursue a claim for compensation after an incident that resulted in personal injury.
                    </p>

                    <a class="insurance-guide-link" href="insurance.php#liability" rel="noopener">
                      Complete terms &gt; European third party liability
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <!-- CARD 5 -->
            <div class="col-md-6">
              <div class="insurance-guide-card" data-card>
                <div class="insurance-guide-head">
                  <div class="insurance-guide-icon">
                    <!-- Legal protection (gavel, cartoon style) -->
                    <svg width="64" height="64" viewBox="0 0 64 64" role="img" aria-label="Legal protection icon" xmlns="http://www.w3.org/2000/svg">
                      <g stroke="#2F2F2F" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                        <!-- gavel head -->
                        <path d="M16 28h16v10H16z" fill="#C79A5B"/>
                        <path d="M20 22h16v10H20z" fill="#D7B07A"/>
                        <!-- handle -->
                        <path d="M30 34l18 18" />
                        <path d="M34 38l10-10" opacity="0.9"/>
                        <!-- base -->
                        <path d="M14 50h28v5H14z" fill="#E9EEF2"/>
                      </g>
                    </svg>
                  </div>

                  <div class="insurance-guide-main">
                    <button type="button"
                      class="insurance-guide-title js-ins-toggle"
                      data-target="insGuide5"
                      aria-controls="insGuide5"
                      aria-expanded="false">
                      European criminal law legal protection
                    </button>

                    <div class="insurance-guide-meta">
                      <div class="insurance-guide-amount">up to 35 000 €</div>

                      <button type="button"
                        class="vs-btn style9 js-ins-toggle"
                        data-target="insGuide5"
                        aria-controls="insGuide5"
                        aria-expanded="false">
                        <span>MORE INFO</span>
                      </button>
                    </div>
                  </div>
                </div>

                <div class="collapse insurance-guide-collapse" id="insGuide5">
                  <div class="insurance-guide-body">
                    <p>
                      Insurance protection applies from the moment criminal proceedings begin—starting with the indictment
                      in court proceedings and from the first prosecutorial act in criminal cases before administrative authorities.
                    </p>

                    <a class="insurance-guide-link" href="insurance.php#legal" rel="noopener">
                      Complete terms &gt; European criminal law legal protection
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <!-- CARD 6 -->
            <div class="col-md-6">
              <div class="insurance-guide-card" data-card>
                <div class="insurance-guide-head">
                  <div class="insurance-guide-icon">
                    <!-- Exclusions (clipboard + warning X, cartoon style) -->
                    <svg width="64" height="64" viewBox="0 0 64 64" role="img" aria-label="Exclusions icon" xmlns="http://www.w3.org/2000/svg">
                      <g stroke="#2F2F2F" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                        <!-- clipboard -->
                        <path d="M18 16h26c3 0 5 2 5 5v28c0 3-2 5-5 5H18c-3 0-5-2-5-5V21c0-3 2-5 5-5z" fill="#E9EEF2"/>
                        <path d="M24 14h14v6H24z" fill="#FDF8F5"/>
                        <path d="M20 28h22M20 34h22" opacity="0.85"/>
                        <!-- warning badge -->
                        <circle cx="46" cy="46" r="8" fill="#F2C94C"/>
                        <path d="M42.5 42.5l7 7M49.5 42.5l-7 7" stroke="#D0021B"/>
                      </g>
                    </svg>
                  </div>

                  <div class="insurance-guide-main">
                    <button type="button"
                      class="insurance-guide-title js-ins-toggle"
                      data-target="insGuide6"
                      aria-controls="insGuide6"
                      aria-expanded="false">
                      Exclusions from insurance coverage for rescue and medical treatment
                    </button>

                    <div class="insurance-guide-meta">
                      <div class="insurance-guide-amount">Professionals, aviation, <br> and motor sports</div>

                      <button type="button"
                        class="vs-btn style9 js-ins-toggle"
                        data-target="insGuide6"
                        aria-controls="insGuide6"
                        aria-expanded="false">
                        <span>MORE INFO</span>
                      </button>
                    </div>
                  </div>
                </div>

                <div class="collapse insurance-guide-collapse" id="insGuide6">
                  <div class="insurance-guide-body">
                    <h5 class="mb-2">Exclusions – Rescue Operations</h5>
                    <p class="mb-2">Simplified list:</p>
                    <ul class="mb-4">
                      <li>Air/ fly activities</li>
                      <li>activities 6,000 m above sea level</li>
                      <li>Activities performed in the course of a profession</li>
                      <li>Motorsport activities</li>
                      <li>
                        The complete list of exclusions for rescue operations is
                        <a href="#" target="_blank" rel="noopener">available here</a>.
                      </li>
                    </ul>

                    <h5 class="mb-2">Exclusions for repatriation and medical treatment</h5>
                    <ul class="mb-0">
                      <li>
                        The complete list is
                        <a href="#" target="_blank" rel="noopener">available here</a>.
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </section>
      <!--================= Tour Package Area end =================-->



      <!--================= Insurance Intro (TAB 1 / Rescue Protection) =================-->
      <section class="insurance-intro space" style="background-color: #fdf8f5;" data-bg-src="assets/img/bg/destination.png">
        <div class="container">

          <div class="row">
            <div class="col-12">
              <div class="title-area text-center">
                <span
                  class="sec-subtitle text-capitalize fade-anim"
                  data-direction="top"
                  >Alpenverein Insurance</span
                >
                <h2 class="sec-title fade-anim" data-direction="bottom">
                  Current fees are listed on the <a href="#" style="color: #75754f;">Pricing page</a> 
                </h2>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="insurance-intro__inner">
                <p>
                  The insurance coverage is <strong>valid worldwide</strong>, including for interventions by the
                  <strong>mountain rescue service</strong>. The insurance for the membership year 2026 is established
                  after paying the annual fee and ends on
                  <a href="#" class="insurance-intro__link">January 31, 2027</a>.
                  The insurer of Alpenverein members is GENERALI insurance company.
                </p>

                <p class="mb-0">
                  Insurance for <strong>rescue/search</strong> from inaccessible terrain covers <strong>all leisure
                  activities and sports</strong> except for the following
                  <a href="#" class="insurance-intro__link">eight exceptions</a>, which are performed
                  <strong>off-track in open terrain</strong>, including participation in hobby sporting competitions
                  and <strong>while on vacation</strong> (including water activities such as diving to 40 m, swimming,
                  rafting, surfing, canyoning). The exclusions for treatment are
                  <a href="#" class="insurance-intro__link">listed here</a>. Coverage for treatment/hospitalisation
                  abroad applies to each trip abroad for the first 8 weeks (56 days). Coverage for rescue from
                  inaccessible terrain abroad is provided year-round and is not limited by the number of days since
                  departure from the home country.
                </p>
              </div>
            </div>
          </div>

        </div>
      </section>
      <!--================= Insurance Intro end =================-->


      <!--================= Useful Links (TAB 1) =================-->
      <section class="insurance-links space" style="background-color: #fdf8f5;">
        <div class="container">

          <div class="row">
                  <div class="col-12">
                    <div class="title-area text-center">
                      <span
                        class="sec-subtitle text-capitalize fade-anim"
                        data-direction="top"
                        >BERG Membership</span
                      >
                      <h2 class="sec-title fade-anim" data-direction="bottom">
                        Useful Links 
                      </h2>
                    </div>
                  </div>
                </div>

          <div class="row">
            <div class="col-12">
              <div class="insurance-links__wrap">

                <!-- ITEM 1 -->
                <div class="insurance-link-item">
                  <div class="insurance-link-item__icon">
                    <img src="assets/img/icons/insurance-phone.svg" alt="Order membership">
                  </div>

                  <div class="insurance-link-item__content">
                    <h4 class="insurance-link-item__title">
                      Order membership with Alpenverein insurance.
                    </h4>
                    <div class="insurance-link-item__desc">
                      <span class="insurance-link-item__bullet">›</span>
                      Order / form for the current membership year.
                    </div>
                  </div>

                  <div class="insurance-link-item__cta">
                    <a href="membership.php" class="vs-btn style4">
                      <span>BUY NOW</span>
                    </a>
                  </div>
                </div>

                <!-- ITEM 2 -->
                <div class="insurance-link-item">
                  <div class="insurance-link-item__icon">
                    <img src="assets/img/icons/insurance-shield.svg" alt="Insurance certificate">
                  </div>

                  <div class="insurance-link-item__content">
                    <h4 class="insurance-link-item__title">
                      Alpenverein insurance certificate
                    </h4>
                    <div class="insurance-link-item__desc">
                      <span class="insurance-link-item__bullet">›</span>
                      Confirmation in English for visa purposes or other reasons related to travel to the country
                    </div>
                  </div>

                  <div class="insurance-link-item__cta">
                    <a href="membership.php" class="vs-btn style4">
                      <span>REQUEST</span>
                    </a>
                  </div>
                </div>

                <!-- ITEM 3 -->
                <div class="insurance-link-item">
                  <div class="insurance-link-item__icon">
                    <img src="assets/img/icons/insurance-italy.svg" alt="Certificate of Liability in Italy">
                  </div>

                  <div class="insurance-link-item__content">
                    <h4 class="insurance-link-item__title">
                      PDF - Certificate of Liability in Italy
                    </h4>
                    <div class="insurance-link-item__desc">
                      <span class="insurance-link-item__bullet">›</span>
                      The confirmation must be presented at the ticket office when purchasing a ski pass or when checking on
                      the slope (together with the membership card)
                    </div>
                  </div>

                  <div class="insurance-link-item__cta">
                    <a href="assets/pdf/generali-italy.pdf" class="vs-btn style4" download="Certificate_of_Liability_Italy.pdf">
                      <span>DOWNLOAD</span>
                    </a>
                  </div>
                </div>

                <!-- ITEM 4 -->
                <div class="insurance-link-item">
                  <div class="insurance-link-item__icon">
                    <img src="assets/img/icons/insurance-brochure.svg" alt="Insurance brochure PDF">
                  </div>

                  <div class="insurance-link-item__content">
                    <h4 class="insurance-link-item__title">
                      PDF - Alpenverein insurance brochure
                    </h4>
                    <div class="insurance-link-item__desc">
                      <span class="insurance-link-item__bullet">›</span>
                      Valid until 31 December 2027
                    </div>
                  </div>

                  <div class="insurance-link-item__cta">
                    <a href="assets/pdf/alpenverein.pdf" class="vs-btn style4" download="Alpenverein_Insurance_Brochure.pdf">
                      <span>DOWNLOAD</span>
                    </a>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Useful Links end =================-->

      <!--================= Insurance Conditions (Segments) =================-->
      <section class="insurance-links space" style="background-color: #fdf8f5;" id="insurance-conditions">
        <div class="container">

          <div class="row">
            <div class="col-12">
              <div class="text-center">
                <span class="sec-subtitle text-capitalize fade-anim" data-direction="top">BERG Membership</span>
                <h2 class="sec-title fade-anim" data-direction="bottom">Insurance conditions</h2>
              </div>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-12">
              <div class="ic-layout" data-ic-root>

                <!-- SIDEBAR -->
                <aside class="ic-sidebar" aria-label="Insurance conditions navigation">
                  <div class="ic-nav" role="tablist" aria-orientation="vertical">

                    <button
                      type="button"
                      class="ic-nav-item is-active"
                      id="ic-tab-duration"
                      role="tab"
                      aria-selected="true"
                      aria-controls="ic-panel-duration"
                      data-ic-tab="duration"
                      data-ic-hash="insurance-duration"
                    >
                      <span class="ic-step">1</span>
                      <span class="ic-label">Insurance duration</span>
                    </button>

                    <button
                      type="button"
                      class="ic-nav-item"
                      id="ic-tab-event"
                      role="tab"
                      aria-selected="false"
                      aria-controls="ic-panel-event"
                      data-ic-tab="event"
                      data-ic-hash="insured-event"
                    >
                      <span class="ic-step">2</span>
                      <span class="ic-label">Insured event</span>
                    </button>

                    <button
                      type="button"
                      class="ic-nav-item"
                      id="ic-tab-who"
                      role="tab"
                      aria-selected="false"
                      aria-controls="ic-panel-who"
                      data-ic-tab="who"
                      data-ic-hash="who-is-insured"
                    >
                      <span class="ic-step">3</span>
                      <span class="ic-label">Who is insured?</span>
                    </button>

                    <button
                      type="button"
                      class="ic-nav-item"
                      id="ic-tab-basis"
                      role="tab"
                      aria-selected="false"
                      aria-controls="ic-panel-basis"
                      data-ic-tab="basis"
                      data-ic-hash="basics-of-the-contract"
                    >
                      <span class="ic-step">4</span>
                      <span class="ic-label">Basics of the contract</span>
                    </button>

                    <button
                      type="button"
                      class="ic-nav-item"
                      id="ic-tab-gdpr"
                      role="tab"
                      aria-selected="false"
                      aria-controls="ic-panel-gdpr"
                      data-ic-tab="gdpr"
                      data-ic-hash="gdpr-personal-data-protection"
                    >
                      <span class="ic-step">5</span>
                      <span class="ic-label">GDPR – personal data protection</span>
                    </button>

                  </div>
                </aside>

                <!-- CONTENT -->
                <div class="ic-content">

                  <!-- PANEL 1 -->
                  <section
                    class="ic-panel is-active"
                    id="ic-panel-duration"
                    role="tabpanel"
                    aria-labelledby="ic-tab-duration"
                    tabindex="0"
                    data-ic-panel="duration"
                  >
                    <span id="insurance-duration" class="ic-anchor" aria-hidden="true"></span>

                    <div class="ic-breadcrumb">
                      Insurance overview <span class="ic-sep">›</span> Terms and documentation <span class="ic-sep">›</span> Insurance conditions
                    </div>

                    <h3 class="ic-title">Duration of insurance</h3>

                    <div class="ic-body">
                      <!-- PASTE IDENTICAL TEXT HERE (from: https://alpenverein-slovensko.sk/en/support/duration-of-insurance/) -->
                      <p class="ic-placeholder">
                        The insurance cover is guaranteed provided that the ongoing membership fee is paid prior to any event resulting in a claim. <strong> An exception applies every January:</strong> if any event resulting in a claim occurs during this period and if the fee for the respective calendar year has not yet been paid, <strong>such a claim will only be honoured if the fee is then paid</strong> and if the membership fee for the previous year was also paid. If the fee is paid after 31 January, insurance protection begins with the first minute of the day following the date on which the fee was paid. New members who join after 1 September of any year also count as being insured up to 1 January of the following year, although no membership fee is charged for this period.
                      </p>
                    </div>
                  </section>

                  <!-- PANEL 2 -->
                  <section
                    class="ic-panel"
                    id="ic-panel-event"
                    role="tabpanel"
                    aria-labelledby="ic-tab-event"
                    tabindex="0"
                    data-ic-panel="event"
                    hidden
                  >
                    <span id="insured-event" class="ic-anchor" aria-hidden="true"></span>

                    <div class="ic-breadcrumb">
                      Insurance overview <span class="ic-sep">›</span> Terms and documentation <span class="ic-sep">›</span> Insurance conditions
                    </div>

                    <h3 class="ic-title">What should be done in the event of an insurance claim?</h3>

                    <div class="ic-body">
                      <!-- PASTE IDENTICAL TEXT HERE (from: https://alpenverein-slovensko.sk/en/support/what-should-be-done-in-the-event-of-an-insurance-claim/) -->
                      <p class="ic-placeholder">
                        <strong>Note:</strong> before repatriation, transport, in-patient medical treatment abroad or transport within the country of main place of residence (not in event of rescue), you must contact the 24h emergency service (or max. EUR750 will be compensated):
                         <br>
                         <br>
                        <strong>Europ Assistance,</strong> <br>
                        tel: +43/1/253 3798, fax +43/1/313 89 1304, email: aws@alpenverein.at
                        <br>
                        <br>
                        In the event of rescue, repatriation, transfer and medical treatment, please send a claim form to:
                        <br>
                        <br>
                        <strong>KNOX Versicherungsmanagement GmbH,</strong> <br>
                        Resselstraße 33, 6020 Innsbruck, <br>
                        T +43/512/238300-30, F +43/512/238300-15, <br>
                        M AV-service@knox.co.at <br>
                        <br>
                        In case of liability and legal expenses, please send a
                        claim form to:
                        <br>
                        <br>
                        <strong>KNOX Versicherungsmanagement GmbH,</strong> <br>
                        Resselstraße 33, 6020 Innsbruck, <br>
                        T +43/512/238300-30, F +43/512/238300-15, <br>
                        M AV-service@knox.co.at <br>
                        <br>
                        Damage claim forms are available online, see: <br>
                        <a href="www.alpenverein.at/versicherung" target="_blank">www.alpenverein.at/versicherung</a> 
                      </p>
                    </div>
                  </section>

                  <!-- PANEL 3 -->
                  <section
                    class="ic-panel"
                    id="ic-panel-who"
                    role="tabpanel"
                    aria-labelledby="ic-tab-who"
                    tabindex="0"
                    data-ic-panel="who"
                    hidden
                  >
                    
                    <span id="who-is-insured" class="ic-anchor" aria-hidden="true"></span>


                    <div class="ic-breadcrumb">
                      Insurance overview <span class="ic-sep">›</span> Terms and documentation <span class="ic-sep">›</span> Insurance conditions
                    </div>

                    <h3 class="ic-title">Who is insured?</h3>

                    <div class="ic-body">
                      <!-- PASTE IDENTICAL TEXT HERE (from: https://alpenverein-slovensko.sk/en/support/who-is-insured/) -->
                      <p class="ic-placeholder">
                        All members of the Österreichischer Alpenverein who pay their membership fees for the current insurance period are insured. Non-fee-paying members such as children and young people without an income up to the max. age of 27, both of whose parents are mem- bers (or one of whose parents is a member in the case of single parents), are fully insured provided that they are registered with the association and therefore have a valid membership card. Members of the Alpenverein whose main place of residence is outside Austria or who are foreign nationals are also fully insured. In this case, the term “abroad” in the terms of insurance refers to the respective main place of residence.
                        <br>
                        <br>
                        <strong>Main place of residence</strong> 
                        <br>
                        <br>
                        A person’s main place of residence is generally established at the place where he/she settled with the intention of making it his/her centre of vital interests. If this material condition applies to multiple places of residence on overall consideration of a person’s professional, economic and social vital interests, they must refer to the place of residence to which they have primary proximity as their main place of residence.
                      </p>
                    </div>

                  </section>

                  <!-- PANEL 4 -->
                  <section
                    class="ic-panel"
                    id="ic-panel-basis"
                    role="tabpanel"
                    aria-labelledby="ic-tab-basis"
                    tabindex="0"
                    data-ic-panel="basis"
                    hidden
                  >
                        
                    <span id="basics-of-the-contract" class="ic-anchor" aria-hidden="true"></span>

                    <div class="ic-breadcrumb">
                      Insurance overview <span class="ic-sep">›</span> Terms and documentation <span class="ic-sep">›</span> Insurance conditions
                    </div>

                    <h3 class="ic-title">Contractual basis</h3>

                    <div class="ic-body">
                      <!-- PASTE IDENTICAL TEXT HERE (from: https://alpenverein-slovensko.sk/en/support/contractual-basis/) -->
                      <p class="ic-placeholder">
                        The contractual basis consists of the framework contracts agreed between the Österreichischer Alpenverein and the insurers, as well as the general conditions to which the respective contract is subject. The insurance cover provided under this contract is only subsidiary to other insurance cover. Other service obligations take precedence if insurance cover is also provided by a different insurer for the same risks.
                        A claim cannot be made if a service has been or were to
                        be provided to the insured person free of charge.
                        <br>
                        <br>
                        The underlying contractual documents are available to download, see: <a href="www.alpenverein.at/versicherung" target="_blank">www.alpenverein.at/versicherung</a> 
                        <br>
                        <br>
                        The present contract is an Austrian contract to which Austrian law must be applied in any case, with the exclusion of the Austrian Private International Law and International Reference Provisions. Neither Österreichischer Alpenverein nor KNOX Versicherungsmanagement GmbH have legal liability for the accuracy or content of any other than the information available in the German ver- sion of the website or on the German information folder. In case of uncertainty, only the original German version is legally binding on Österreichischer Alpenverein. Translations are merely offered as a service for the members of Österreichischer Alpenverein and without legal obligation. For all contracts concluded with Österreichischer Alpenverein, Austrian law must be applied, with the exclusion of the Austrian Private International Law and International Reference Provisions.
                      </p>
                    </div>
                  </section>

                  <!-- PANEL 5 -->
                  <section
                    class="ic-panel"
                    id="ic-panel-gdpr"
                    role="tabpanel"
                    aria-labelledby="ic-tab-gdpr"
                    tabindex="0"
                    data-ic-panel="gdpr"
                    hidden
                  >

                  <span id="gdpr-personal-data-protection" class="ic-anchor" aria-hidden="true"></span>

                    <div class="ic-breadcrumb">
                      Insurance overview <span class="ic-sep">›</span> Terms and documentation <span class="ic-sep">›</span> Insurance conditions
                    </div>

                    <h3 class="ic-title">GDPR – personal data protection</h3>

                    <div class="ic-body">
                      <p><strong>Operator</strong></p>
                      <p>
                        The operator of the Alpine Club website&nbsp;Alpenverein
                        (<a href="https://www.alpenverein-slovensko.sk" target="_blank" rel="noopener">www.alpenverein-slovensko.sk</a>)
                        is <strong>Horský klub, s.r.o.</strong>, Pobrežná&nbsp;477,&nbsp;031&nbsp;04&nbsp;Liptovský&nbsp;Mikuláš, Slovak Republic,
                        Company ID&nbsp;47494794, registered in the Commercial Register of the District Court Žilina&nbsp;60580/L
                        (hereinafter referred to as the “operator”).
                      </p>

                      <p><strong>Responsible Person</strong></p>
                      <p>
                        The responsible person of the operator is the director of Horský klub&nbsp;s.r.o.; the mailing address is identical
                        to the operator’s registered address, and the electronic address is&nbsp;
                        <a href="mailto:info@alpenverein-slovensko.sk">info@alpenverein-slovensko.sk</a>.
                      </p>

                      <p><strong>Purpose and Legal Basis</strong></p>
                      <p>
                        The purpose and legal basis for processing personal data is membership in the Alpine Club&nbsp;Alpenverein.
                        Membership includes insurance concluded under framework agreements between the Austrian Alpine Club
                        Österreichischer Alpenverein (“ÖAV”) and the insurer <strong>Generali Versicherung&nbsp;AG</strong> represented by
                        <strong>KNOX Versicherungsmanagement&nbsp;GmbH</strong>. Austrian law (including Austrian international reference standards)
                        governs these contracts. Supplying personal data is necessary for arranging and concluding an insurance contract for an
                        Alpenverein member; without such data membership cannot be established. The operator sends important notices and alerts
                        concerning membership validity to the member’s e-mail address.
                      </p>

                      <p><strong>Data Subject and Processed Personal Data</strong></p>
                      <p>
                        The data subject is the club member. The personal data processed for the data subject include: first name, last name,
                        permanent or temporary residence, date of birth, nationality, title, gender, telephone number, and e-mail address.
                        If additional personal data are processed for example, health-related information such data are handled only to the extent
                        necessary for providing the service in the event of a claim.
                      </p>

                      <p><strong>Recipients of Personal Data</strong></p>
                      <p>Personal data may be disclosed primarily to:</p>
                      <ul>
                        <li><strong>Österreichischer Alpenverein (“ÖAV”)</strong>, Vienna, Austria</li>
                        <li><strong>KNOX Versicherungsmanagement&nbsp;GmbH</strong>, Innsbruck, Austria (insurance intermediary)</li>
                        <li><strong>Generali Versicherung&nbsp;AG</strong>, Landskrongasse&nbsp;1-3,&nbsp;1010&nbsp;Vienna, Austria (insurer)</li>
                      </ul>
                      <p>
                        During the membership period the insurer may change; the current insurer is indicated on the website
                        <a href="https://www.alpenverein-slovensko.sk" target="_blank" rel="noopener">www.alpenverein-slovensko.sk</a>
                        under the “Insurance” section. The data may also be shared with companies acting on behalf of the member for the exercise
                        of rights related to assistance services and insurance benefits within the Alpine Club membership.
                      </p>

                      <p><strong>Retention Period</strong></p>
                      <p>
                        The operator will retain the member’s personal data for the duration of the Alpine Club membership and, after termination
                        of membership, for at least 15&nbsp;years from the end of the contractual relationship with the data subject.
                      </p>

                      <p><strong>Rights of the Data Subject</strong></p>
                      <p>
                        The data subject has the following rights with respect to the processing of his/her personal data:
                      </p>

                      <ol>
                        <li>
                          <strong>Right of Confirmation &amp; Access</strong> – to obtain confirmation whether personal data concerning him/her are being
                          processed and, if so, to receive a copy of those data together with the information set out in this notice.
                        </li>
                        <li>
                          <strong>Right to Rectification</strong> – to have inaccurate personal data corrected and incomplete data completed.
                        </li>
                        <li>
                          <strong>Right to Erasure (“right to be forgotten”)</strong> – to have personal data deleted when they are no longer necessary for
                          the purposes for which they were collected or otherwise processed.
                        </li>
                        <li>
                          <strong>Right to Restriction of Processing</strong> – to limit processing when:
                          <ul>
                            <li>the data subject contests the accuracy of the data during the verification period;</li>
                            <li>processing is unlawful and the data subject opposes erasure but requests restriction instead; or</li>
                            <li>the data are no longer needed for the original purpose but the data subject requires them to assert, exercise, or defend a claim.</li>
                          </ul>
                        </li>
                        <li>
                          <strong>Right to Data Portability</strong> – to receive the personal data provided by him/her in a structured, commonly used,
                          machine-readable format and to transmit those data to another controller.
                        </li>
                        <li>
                          <strong>Right to Object</strong> – to object to processing of his/her personal data by the insurer.
                        </li>
                        <li>
                          <strong>Right to Lodge a Complaint</strong> – with the Slovak Office for Personal Data Protection if the data subject believes that
                          processing by the operator violates applicable data-protection legislation.
                        </li>
                        <li>
                          <strong>Right to Human Review</strong> – if a decision affecting the data subject is based solely on automated processing, the data
                          subject may request that the operator review the decision by a human. The operator must comply, with its employees conducting the
                          review, and must inform the data subject of the review method and outcome within 30&nbsp;days of receiving the request.
                        </li>
                        <li>
                          <strong>Right to Verification of Identity</strong> – to request proof of identity of the person authorized to obtain the data.
                        </li>
                        <li>
                          <strong>Right to Source Information</strong> – if the data were not obtained directly from the data subject, the data subject may
                          request information about the source of the data, including whether they originated from publicly accessible sources.
                        </li>
                        <li>
                          <strong>Right to Exercise All Rights in Writing</strong> – at the insurer’s registered address or via e-mail
                          <a href="mailto:info@alpenverein-slovensko.sk">info@alpenverein-slovensko.sk</a>.
                        </li>
                      </ol>

                      <p>The personal data will <strong>not be published.</strong></p>

                      <p><strong>Transfer of Personal Data</strong></p>
                      <p>
                        The operator expects to transfer the personal data to the recipients listed above within the European Union, to EEA-contracting
                        states, and to Switzerland (recipients identified in point&nbsp;6 of this notice). Transfers to third-country jurisdictions will occur
                        only if the European Commission has decided that the country ensures an adequate level of protection, or, lacking such a decision,
                        only if the operator or intermediary provides appropriate safeguards and the data subject retains enforceable rights and effective
                        legal remedies.
                      </p>
                    </div>


                    
                  </section>

                </div>
              </div>
            </div>
          </div>

          <!-- CTA -->
          <div class="row">
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
      <!--================= Insurance Conditions end =================-->
      
      <!--================= Insurance Intro (TAB 1 / Rescue Protection) =================-->
      <section class="insurance-intro space" style="background-color: #fdf8f5;">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="insurance-intro__inner">
                <p style="color:red">
                  All insurance information above are provided for informational purposes only!
                Before submitting my application for membership, I confirm that I have thoroughly reviewed and familiarized myself with the brochure available at the link HERE, and I hereby accept and agree to all terms and conditions stated therein.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Insurance Intro end =================-->

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
