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
    
    <style>
        .berg-order-start { scroll-margin-top: 180px; }
    </style>
  </head>

  <body class="vs-body">
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser.
        Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.
      </p>
    <![endif]-->

<?php require __DIR__ . '/header-en.php'; ?>

      <!-- Breadcrumb -->
      <section class="vs-breadcrumb" data-bg-src="./assets/img/berg-membership-membership.png">
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
                  member savings, and practical access that supports your outdoor lifestyle.
                </p>
              </div>
              <div class="fade-anim mt-5" data-delay="0.77" data-direction="top">
                <a href="membership.php" class="vs-btn style4"><span>CHOOSE A MEMBERSHIP</span></a>
                <a href="benefits.php" class="vs-btn style4-secundary"><span>RESCUE PROTECTION</span></a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- MEMBERSHIP ORDER -->
      <section class="vs-tour-package space pb-5" id="membership-programs" style="background-color: #fdf8f5">
        <div class="container">
          <div class="row justify-content-between align-items-center">
            <div class="col-12">
              <div class="title-area text-center">
                <span class="sec-subtitle fade-anim" data-direction="bottom">MEMBERSHIP PROGRAMS</span>
                <h2 class="sec-title fade-anim" data-direction="top">Choose the program that fits your adventure style.</h2>
              </div>
            </div>

            <!-- PLAN CARDS -->
            <div class="col-12">
              <div class="berg-order-plans">

  <!-- CARD 1: EXPLORER -->
  <div class="berg-plan-card tour-package-box bg-white-color text-center" data-plan="explorer">
    <div class="tour-package-thumb">
      <img src="assets/img/berg-membership-berg-explorer.png" alt="BERG Explorer" class="w-100" />
    </div>

    <div class="berg-plan-body tour-package-content">
      <h3 class="title"><span>BERG EXPLORER</span></h3>

      <div class="berg-plan-meta">
        <p class="mb-10"><strong>Cover:</strong> Worldwide</p>
        <p class="mb-0"><strong>SAR altitude:</strong> up to 6000m</p>
      </div>

      <div class="berg-plan-select">
        <label class="form-label mb-2"><strong>Choose member type</strong></label>

        <div class="berg-select-ui" data-sync-select="explorerType">
          <button type="button" class="berg-select-ui__btn" aria-haspopup="listbox" aria-expanded="false">
            <span class="berg-select-ui__value">
              <span class="berg-opt-left">
                Adult <span class="berg-opt-meta">(birth 1998 - 1962)</span>
              </span>
              <span class="berg-opt-right">
                <strong class="berg-opt-price">
                  <span style="text-decoration: line-through; opacity:0.6;">95 €</span> 85 €
                </strong>
              </span>
            </span>
            <span class="berg-select-ui__chev" aria-hidden="true"></span>
          </button>

          <ul class="berg-select-ui__list" role="listbox">
            <li class="berg-select-ui__opt" role="option" data-value="adult" aria-selected="true">
              <span class="berg-opt-left">Adult <span class="berg-opt-meta">(birth 1998 - 1962)</span></span>
              <span class="berg-opt-right"><strong class="berg-opt-price"><span style="text-decoration: line-through; opacity:0.6;">95 €</span> 85 €</strong></span>
            </li>

            <li class="berg-select-ui__opt" role="option" data-value="senior">
              <span class="berg-opt-left">Senior <span class="berg-opt-meta">(birth 1961 and older)</span></span>
              <span class="berg-opt-right"><strong class="berg-opt-price"><span style="text-decoration: line-through; opacity:0.6;">74 €</span> 68 €</strong></span>
            </li>

            <li class="berg-select-ui__opt" role="option" data-value="junior">
              <span class="berg-opt-left">Junior <span class="berg-opt-meta">(birth 1999 - 2007)</span></span>
              <span class="berg-opt-right"><strong class="berg-opt-price"><span style="text-decoration: line-through; opacity:0.6;">74 €</span> 68 €</strong></span>
            </li>

            <li class="berg-select-ui__opt" role="option" data-value="mountain_rescuer">
              <span class="berg-opt-left">Mountain rescuer <span class="berg-opt-meta">(certified active mountain rescue)</span></span>
              <span class="berg-opt-right"><strong class="berg-opt-price"><span style="text-decoration: line-through; opacity:0.6;">74 €</span> 68 €</strong></span>
            </li>

            <li class="berg-select-ui__opt" role="option" data-value="child">
              <span class="berg-opt-left">Child <span class="berg-opt-meta">(birth 2008 and younger)</span></span>
              <span class="berg-opt-right"><strong class="berg-opt-price"><span style="text-decoration: line-through; opacity:0.6;">41 €</span> 38 €</strong></span>
            </li>

            <li class="berg-select-ui__opt" role="option" data-value="disabled">
              <span class="berg-opt-left">Disabled <span class="berg-opt-meta">(over 50% and including 50%)</span></span>
              <span class="berg-opt-right"><strong class="berg-opt-price"><span style="text-decoration: line-through; opacity:0.6;">41 €</span> 38 €</strong></span>
            </li>
          </ul>

          <select class="form-select berg-select berg-select-native" data-role="explorerType" hidden aria-hidden="true">
            <option value="adult" selected>Adult (birth 1998 - 1962) 85 €</option>
            <option value="senior">Senior (birth 1961 and older) 68 €</option>
            <option value="junior">Junior (birth 1999 - 2007) 68 €</option>
            <option value="mountain_rescuer">Mountain rescuer (certified active mountain rescue) 68 €</option>
            <option value="child">Child (birth 2008 and younger) 38 €</option>
            <option value="disabled">Disabled (over 50% and including 50%) 38 €</option>
          </select>
        </div>
      </div>

      <div class="berg-plan-footer">
        <p class="mb-0">
          Official
          <img src="assets/img/partners/alpenverein.png" style="height: 50px" alt="" />
          partner
        </p>
      </div>

      <div class="berg-plan-actions">
        <a href="#berg-order-start" class="vs-btn style7 w-100 berg-buy-btn" role="button">BUY NOW</a>
      </div>
    </div>
  </div>

  <!-- CARD 2: FAMILY -->
  <div class="berg-plan-card tour-package-box bg-white-color text-center" data-plan="family">
    <div class="tour-package-thumb">
      <img src="assets/img/berg-membership-berg-family.png" alt="BERG Family" class="w-100" />
    </div>

    <div class="berg-plan-body tour-package-content">
      <h3 class="title text-center"><span>BERG FAMILY</span></h3>

      <div class="berg-plan-meta">
        <p class="mb-10"><strong>Cover:</strong> Worldwide</p>
        <p class="mb-0"><strong>SAR altitude:</strong> up to 6000m</p>
      </div>

      <div class="berg-plan-select">
        <label class="form-label mb-2"><strong>Choose family option</strong></label>

        <div class="berg-select-ui" data-sync-select="familyType">
          <button type="button" class="berg-select-ui__btn" aria-haspopup="listbox" aria-expanded="false">
            <span class="berg-select-ui__value">
              <span class="berg-opt-left">
                Married couple or partners <span class="berg-opt-meta">(children free)</span>
              </span>
              <span class="berg-opt-right">
                <strong class="berg-opt-price">
                  <span style="text-decoration: line-through; opacity:0.6;">169 €</span> 154 €
                </strong>
              </span>
            </span>
            <span class="berg-select-ui__chev" aria-hidden="true"></span>
          </button>

          <ul class="berg-select-ui__list" role="listbox">
            <li class="berg-select-ui__opt" role="option" data-value="couple" aria-selected="true">
              <span class="berg-opt-left">Married couple or partners <span class="berg-opt-meta">(children free)</span></span>
              <span class="berg-opt-right"><strong class="berg-opt-price"><span style="text-decoration: line-through; opacity:0.6;">169 €</span> 154 €</strong></span>
            </li>

            <li class="berg-select-ui__opt" role="option" data-value="single">
              <span class="berg-opt-left">Single parent with children <span class="berg-opt-meta">(divorced, widowed, etc.)</span></span>
              <span class="berg-opt-right"><strong class="berg-opt-price"><span style="text-decoration: line-through; opacity:0.6;">95 €</span> 85 €</strong></span>
            </li>
          </ul>

          <select class="form-select berg-select berg-select-native" data-role="familyType" hidden aria-hidden="true">
            <option value="couple" selected>Married couple or partners (children free) 154 €</option>
            <option value="single">Single parent with children (divorced, widowed, etc.) 85 €</option>
          </select>
        </div>
      </div>

      <div class="berg-plan-footer">
        <p class="mb-0">
          Official
          <img src="assets/img/partners/alpenverein.png" style="height: 50px" alt="" />
          partner
        </p>
      </div>

      <div class="berg-plan-actions">
        <a href="#berg-order-start" class="vs-btn style7 w-100 berg-buy-btn" role="button">BUY NOW</a>
      </div>
    </div>
  </div>

</div>

              <div class="text-center mt-25">
                <p class="mb-30">
                  All programs include the same worldwide travel and mountain rescue coverage up to 6,000 m.
                </p>
              </div>

              <div class="col-12 mt-50 mb-25 text-center">
                <a href="benefits.php" class="vs-btn style7">EXPLORE ALL BENEFITS</a>
              </div>
            </div>

            <!-- ORDER FLOW -->
            <div class="col-12">
              <form
                id="bergMembershipForm"
                action="https://formsubmit.co/info@bergmembership.com"
                method="POST"
                target="bergHiddenFrame"
              >
                <!-- FormSubmit settings -->
                <input type="hidden" name="_subject" value="BERG Membership - Membership Programs Form" />
                <input type="hidden" name="_template" value="table" />
                <input type="hidden" name="_captcha" value="false" />
                <input type="text" name="_honey" style="display:none" tabindex="-1" autocomplete="off" />
                <input type="hidden" name="source" value="Membership Programs" />
                <input type="hidden" name="_webhook" value="https://bergmembership.com/webhooks/membership-confirm.php?token=43fGH517weGht" />

                <!-- opcionalno: da imaš isti “Reference” u oba mejla -->
                <input type="hidden" name="order_reference" id="bergOrderRef" value="" />

                <div id="berg-order-start"></div>

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
                    <div class="berg-panel-card berg-panel-card--step1">
                      <div class="berg-step1-wrap">
                        <h4 class="mb-15 text-left">1. Choose category</h4>

                        <div class="berg-summary berg-summary--step1">
                          <p><strong>Selected program:</strong> <span id="bergSelectedPlan">—</span></p>
                          <p><strong>Option:</strong> <span id="bergSelectedOption">—</span></p>
                          <p><strong>Price:</strong> <span id="bergSelectedPrice">—</span></p>
                        </div>

                        <div class="berg-actions-row berg-actions-row--step1">
                          <button type="button" class="vs-btn style7 berg-next" data-next="2">Next step</button>
                          <button type="button" class="vs-btn style7 berg-cancel">Cancel</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- STEP 2 -->
                  <div class="berg-step-panel" data-step-panel="2" hidden>
                    <div class="berg-panel-card">
                      <h4 class="mb-15 text-center">2. Personal data</h4>

                      <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label">First name *</label>
                          <input class="form-control" type="text" name="first_name" required />
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Last name *</label>
                          <input class="form-control" type="text" name="last_name" required />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Date of birth *</label>
                            <input class="form-control" type="date" id="birth_date" required />
                            <input type="hidden" name="birth_year" required />
<input type="hidden" name="birth_month" required />
<input type="hidden" name="birth_day" required />

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

                      <!-- PARTNER -->
                      <div id="bergPartnerBlock" class="berg-subblock mt-25" hidden>
                        <h5 class="mb-15">Husband/wife or partner</h5>

                        <div class="row g-3">
                          <div class="col-md-6">
                            <label class="form-label">First name *</label>
                            <input class="form-control" type="text" name="partner_first_name" />
                          </div>
                          <div class="col-md-6">
                            <label class="form-label">Last name *</label>
                            <input class="form-control" type="text" name="partner_last_name" />
                          </div>

                          <div class="col-md-6">
                            <label class="form-label">Date of birth *</label>
                            <input class="form-control" type="date" id="partner_birth_date" />
                            <input type="hidden" name="partner_birth_year" />
                            <input type="hidden" name="partner_birth_month" />
                            <input type="hidden" name="partner_birth_day" />


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
                          <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <h5 class="mb-0">Children</h5>
                            <button type="button" class="vs-btn style7 berg-add-child">Add child</button>
                          </div>

                          <div id="bergChildrenList" class="mt-15"></div>

                          <template id="bergChildTpl">
                            <div class="berg-child-card">
                              <div class="d-flex align-items-center justify-content-between">
                                <h6 class="mb-0 berg-child-title">Child</h6>
                                <button type="button" class="berg-child-remove" aria-label="Remove child">×</button>
                              </div>

                              <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                  <label class="form-label">Category *</label>
                                  <select class="form-select" name="child_category[]">
                                    <option value="student">Student aged 19 to 27 years</option>
                                    <option value="child">Child up to 18 years</option>
                                  </select>
                                </div>

                                <div class="col-md-6">
                                  <label class="form-label">First name *</label>
                                  <input class="form-control" type="text" name="child_first_name[]" />
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label">Last name *</label>
                                  <input class="form-control" type="text" name="child_last_name[]" />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Date of birth *</label>
                                    <input class="form-control" type="date" class="child-birth-date" />
                                    <input type="hidden" name="child_birth_year[]" />
<input type="hidden" name="child_birth_month[]" />
<input type="hidden" name="child_birth_day[]" />

                                </div>


                                <div class="col-md-6">
                                  <label class="form-label">Gender *</label>
                                  <select class="form-select" name="child_gender[]">
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
                        <button type="button" class="vs-btn style7 berg-prev" data-prev="1">Back</button>
                        <button type="button" class="vs-btn style7 berg-next" data-next="3">Next step</button>
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
                          <input class="form-control" type="email" name="email" required />
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Telephone *</label>
                          <input class="form-control" type="tel" name="phone" required />
                        </div>

                        <div class="col-md-8">
                          <label class="form-label">Street *</label>
                          <input class="form-control" type="text" name="street" required />
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">House number *</label>
                          <input class="form-control" type="text" name="house_number" required />
                        </div>

                        <div class="col-md-6">
                          <label class="form-label">City *</label>
                          <input class="form-control" type="text" name="city" required />
                        </div>
                        <div class="col-md-3">
                          <label class="form-label">ZIP *</label>
                          <input class="form-control" type="text" name="zip" required />
                        </div>
                        <div class="col-md-3">
                          <label class="form-label">Country *</label>
                          <input class="form-control" type="text" name="country" required />
                        </div>
                      </div>

                      <!-- TERMS CHECKBOX (REQUIRED) -->
<div class="mt-25">
  <label class="berg-terms" for="termsConfirm">
    <input
      type="checkbox"
      name="terms_confirm"
      id="termsConfirm"
      required
      class="berg-terms__input"
    />
    <span class="berg-terms__box" aria-hidden="true"></span>

    <span class="berg-terms__text">
      By submitting my membership application, I confirm that I have reviewed the
      <a
        href="https://www.alpenverein.at/portal_wAssets/docs/service/versicherung/AWS-Folder_E_2023_ebook.pdf"
        target="_blank"
        rel="noopener"
        style="color:#75764e;"
      >brochure</a>
      and accept all terms and conditions contained therein.
    </span>
  </label>
</div>

<style>
  .berg-terms{
    display:flex;
    align-items:flex-start;
    gap:12px;
    cursor:pointer;
    user-select:none;
  }

  /* sakrij input vizuelno, ali ostavi ga aktivnog (required radi) */
  .berg-terms__input{
    position:absolute !important;
    width:1px !important;
    height:1px !important;
    padding:0 !important;
    margin:-1px !important;
    overflow:hidden !important;
    clip:rect(0,0,0,0) !important;
    white-space:nowrap !important;
    border:0 !important;
  }

  /* vidljiva “kutija” */
  .berg-terms__box{
    width:18px;
    height:18px;
    border:2px solid #cfcfcf;
    border-radius:5px;
    background:#fff;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    margin-top:3px;
    flex:0 0 18px;
  }

  /* check mark */
  .berg-terms__input:checked + .berg-terms__box{
    border-color:#75764e;
    background:#75764e;
  }
  .berg-terms__input:checked + .berg-terms__box::after{
    content:"";
    width:9px;
    height:5px;
    border-left:2px solid #fff;
    border-bottom:2px solid #fff;
    transform:rotate(-45deg);
    margin-top:-1px;
  }

  /* fokus (tab) */
  .berg-terms__input:focus-visible + .berg-terms__box{
    outline:3px solid rgba(117,118,78,.25);
    outline-offset:2px;
  }

  .berg-terms__text{
    font-size:14px;
    line-height:1.4;
  }
  .berg-invalid {
  border: 2px solid #e53935 !important;
  background-color: #fff6f6;
}
</style>


                      <div class="berg-actions-row mt-25">
                        <button type="button" class="vs-btn style7 berg-prev" data-prev="2">Back</button>
                        <button type="submit" class="vs-btn style7 berg-submit">Place order</button>
                      </div>
                    </div>
                  </div>

                  <!-- Hidden fields -->
                  <input type="hidden" id="bergPlanValue" name="selected_plan" />
                  <input type="hidden" id="bergOptionValue" name="selected_option" />
                  <input type="hidden" id="bergPriceValue" name="selected_price" />
                </div>
              </form>

              <!-- Hidden iframe: prevents redirect -->
              <iframe
                name="bergHiddenFrame"
                id="bergHiddenFrame"
                style="display:none;width:0;height:0;border:0;"
                aria-hidden="true"
              ></iframe>

              <!-- Thank You popup -->
              <div id="bergThankYouPop" class="berg-pop" hidden>
                <div class="berg-pop__backdrop" data-berg-close></div>

                <div class="berg-pop__dialog" role="dialog" aria-modal="true" aria-labelledby="bergThankYouTitle">
                  <button type="button" class="berg-pop__close" data-berg-close aria-label="Close">×</button>

                  <div class="berg-pop__kicker">MEMBERSHIP</div>
                  <h3 id="bergThankYouTitle" class="berg-pop__title">Thank You!</h3>

                  <p class="berg-pop__text">
                    Your application has been received, Payment instructions will be sent via email, and we will contact you shortly after processing your submission.
                    For any questions, feel free to reach out to us at
                    <a href="mailto:info@bergmembership.com">info@bergmembership.com</a>
                  </p>

                  <center><button type="button" class="vs-btn style7 w-100" id="bergThankYouOk">OK</button></center>
                </div>
              </div>

              <style>
  /* Popup wrapper: uvek preko celog ekrana i uvek centriran */
.berg-pop{
  position: fixed !important;
  inset: 0 !important;
  z-index: 99999 !important;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 16px;
}

  .berg-pop[hidden]{display:none}

  .berg-pop__backdrop{
    position:absolute;
    inset:0;
    background:rgba(0,0,0,.45);
  }

  /* Modal box */
  .berg-pop__dialog{
    position: relative;
    z-index: 1;                /* iznad backdrop-a */
    background:#fff;
    border-radius:14px;
    width: min(720px, calc(100vw - 32px));
    max-height: calc(100vh - 32px);
    overflow: auto;            /* ako tekst bude duži */
    padding:28px 28px 22px;
    box-shadow:0 20px 60px rgba(0,0,0,.25);
  }

  /* close btn */
  .berg-pop__close{
    position:absolute;
    top:14px;
    right:14px;
    width:36px;
    height:36px;
    border:1px solid #e9e9e9;
    border-radius:10px;
    background:#fff;
    font-size:18px;
    line-height:1;
    z-index:2;
  }

  .berg-pop__kicker{letter-spacing:.18em;font-size:11px;opacity:.6;text-align:center;margin-bottom:10px}
  .berg-pop__title{text-align:center;margin:0 0 10px}
  .berg-pop__text{text-align:center;margin:0 0 18px;font-size:15px;line-height:1.5}

  /* Mobilni browseri: stabilnija visina */
  @supports (height: 100dvh){
    .berg-pop{ inset: 0; }
    .berg-pop__dialog{ max-height: calc(100dvh - 32px); }
  }
</style>


            </div>
          </div>
        </div>
      </section>

    </main>

<?php require __DIR__ . '/footer-en.php'; ?>

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

    <script>
      (function () {
        const form = document.getElementById('bergMembershipForm');
        const orderWrap = document.getElementById('berg-order');

        const planOut   = document.getElementById('bergSelectedPlan');
        const optOut    = document.getElementById('bergSelectedOption');
        const priceOut  = document.getElementById('bergSelectedPrice');

        const planHidden  = document.getElementById('bergPlanValue');
        const optHidden   = document.getElementById('bergOptionValue');
        const priceHidden = document.getElementById('bergPriceValue');

        const ref = document.getElementById('bergOrderRef');

        const partnerBlock = document.getElementById('bergPartnerBlock');
        const childrenList = document.getElementById('bergChildrenList');

        const iframe = document.getElementById('bergHiddenFrame');
        const pop = document.getElementById('bergThankYouPop');
        // Move popup to <body> so fixed works even if parents use transform/filter
if (pop && pop.parentElement !== document.body) {
  document.body.appendChild(pop);
}

        const okBtn = document.getElementById('bergThankYouOk');

        if (!form) return;

        const planLabels = {
          explorer: 'BERG EXPLORER',
          family: 'BERG FAMILY',
        };

        function getNativeSelectForPlan(plan) {
          if (plan === 'explorer') return document.querySelector('select[data-role="explorerType"]');
          if (plan === 'family') return document.querySelector('select[data-role="familyType"]');
          return null;
        }

        function extractPrice(text) {
          const t = (text || '').replace(/\s+/g, ' ').trim();
          let m = t.match(/(\d+(?:[.,]\d{1,2})?)\s*(€|EUR)\b/i);
          if (m) return m[1].replace(',', '.') + ' €';
          m = t.match(/\b(€|EUR)\s*(\d+(?:[.,]\d{1,2})?)/i);
          if (m) return m[2].replace(',', '.') + ' €';
          return '';
        }

        function getActiveCustomOpt(plan) {
          const root = (plan === 'explorer')
            ? document.querySelector('.berg-plan-card[data-plan="explorer"] .berg-select-ui[data-sync-select="explorerType"]')
            : document.querySelector('.berg-plan-card[data-plan="family"] .berg-select-ui[data-sync-select="familyType"]');

          if (!root) return null;
          return root.querySelector('.berg-select-ui__opt[aria-selected="true"]');
        }

        function getOptionText(plan) {
          const active = getActiveCustomOpt(plan);
          if (active) return (active.textContent || '').replace(/\s+/g,' ').trim();

          const sel = getNativeSelectForPlan(plan);
          if (sel && sel.selectedOptions && sel.selectedOptions[0]) {
            return (sel.selectedOptions[0].textContent || '').trim();
          }
          return '';
        }

        function getOptionValue(plan) {
          const active = getActiveCustomOpt(plan);
          if (active) return active.getAttribute('data-value') || '';

          const sel = getNativeSelectForPlan(plan);
          return sel ? (sel.value || '') : '';
        }

        function getPrice(plan) {
          const active = getActiveCustomOpt(plan);
          if (active) {
            const priceEl = active.querySelector('.berg-opt-price');
            const p = priceEl ? (priceEl.textContent || '').trim() : '';
            if (p) return p.includes('€') ? p : (extractPrice(p) || p);
            return extractPrice(active.textContent || '');
          }

          const sel = getNativeSelectForPlan(plan);
          if (sel && sel.selectedOptions && sel.selectedOptions[0]) {
            return extractPrice(sel.selectedOptions[0].textContent || '');
          }
          return '';
        }

        function shouldShowPartner(plan) {
          if (plan !== 'family') return false;
          const famSel = getNativeSelectForPlan('family');
          if (!famSel) return true;
          return famSel.value === 'couple';
        }

        function setPartnerRequired(isRequired) {
          if (!partnerBlock) return;
          const fields = partnerBlock.querySelectorAll(
            'input[name^="partner_"], select[name^="partner_"], textarea[name^="partner_"]'
          );
          fields.forEach(el => {
            if (isRequired) el.setAttribute('required', 'required');
            else el.removeAttribute('required');
          });
        }

        function setChildrenRequired() {
          if (!childrenList) return;
          childrenList.querySelectorAll('.berg-child-card').forEach(card => {
            card.querySelectorAll('input, select, textarea').forEach(el => {
              el.setAttribute('required', 'required');
            });
          });
        }

        function updateSummary(plan) {
          const planName = planLabels[plan] || plan || '—';
          const optionText = getOptionText(plan);
          const optionValue = getOptionValue(plan);
          const price = getPrice(plan);

          if (planOut) planOut.textContent = planName;
          if (optOut) optOut.textContent = optionText || '—';
          if (priceOut) priceOut.textContent = price || '—';

          if (planHidden) planHidden.value = plan || '';
          if (optHidden) optHidden.value = optionValue || '';
          if (priceHidden) priceHidden.value = price || '';

          if (partnerBlock) {
            const showPartner = shouldShowPartner(plan);
            partnerBlock.hidden = !showPartner;
            setPartnerRequired(showPartner);
          }

          setChildrenRequired();
        }

        // OPEN order on BUY NOW
        document.addEventListener('click', function (e) {
          const btn = e.target.closest('.berg-buy-btn');
          if (!btn) return;

          const card = btn.closest('.berg-plan-card');
          const plan = card ? (card.getAttribute('data-plan') || '') : '';
          if (!plan) return;

          if (orderWrap) orderWrap.hidden = false;
          updateSummary(plan);

          // scroll to start
          const anchor = document.getElementById('berg-order-start');
          setTimeout(() => {
            if (anchor) anchor.scrollIntoView({ behavior: 'smooth', block: 'start' });
          }, 30);
        });

        // If family option changes -> partner required toggles + summary updates (when order is open)
        document.addEventListener('change', function (e) {
          const sel = e.target.closest('select.berg-select-native');
          if (!sel) return;
          if (!orderWrap || orderWrap.hidden) return;

          const plan = planHidden ? planHidden.value : '';
          if (!plan) return;

          // if family select changed, update summary for family
          if (sel.matches('select[data-role="familyType"]')) {
            updateSummary('family');
            return;
          }

          // explorer select changed
          if (sel.matches('select[data-role="explorerType"]')) {
            updateSummary('explorer');
            return;
          }
        });

        // If custom UI changed (click on option) -> sync to native + update summary if open
        document.addEventListener('click', function (e) {
          const opt = e.target.closest('.berg-select-ui__opt');
          if (!opt) return;

          const root = opt.closest('.berg-select-ui');
          if (!root) return;

          const syncKey = root.getAttribute('data-sync-select') || '';
          const value = opt.getAttribute('data-value') || '';

          // set aria-selected
          root.querySelectorAll('.berg-select-ui__opt').forEach(li => li.setAttribute('aria-selected', li === opt ? 'true' : 'false'));

          // set button display (copy this opt's HTML)
          const btnVal = root.querySelector('.berg-select-ui__value');
          if (btnVal) {
            btnVal.innerHTML = opt.innerHTML;
          }

          // close dropdown if you have CSS that uses aria-expanded
          const btn = root.querySelector('.berg-select-ui__btn');
          if (btn) btn.setAttribute('aria-expanded', 'false');

          // sync native select
          const nativeSel = root.querySelector('select.berg-select-native');
          if (nativeSel) {
            nativeSel.value = value;
            nativeSel.dispatchEvent(new Event('change', { bubbles: true }));
          }

          // update summary if open
          if (orderWrap && !orderWrap.hidden) {
            const plan = planHidden ? planHidden.value : '';
            if (plan) updateSummary(plan);
          }
        });

        // Generate ref + validate required rules before submit
        form.addEventListener('submit', function () {
          // browser handles validation UI
          if (!form.checkValidity()) return;

          if (ref && !ref.value) {
            ref.value = String(Math.floor(100000 + Math.random() * 900000));
          }

          // ensure required logic is synced
          setChildrenRequired();
          const plan = planHidden ? planHidden.value : '';
          if (partnerBlock) {
            const showPartner = shouldShowPartner(plan);
            partnerBlock.hidden = !showPartner;
            setPartnerRequired(showPartner);
          }

          // ensure summary values exist
          if (plan) updateSummary(plan);

          // mark submit for iframe load
          form.dataset.submitted = '1';
        });

        // Show popup on iframe load (no redirect)
        if (iframe) {
          iframe.addEventListener('load', function () {
            if (form.dataset.submitted !== '1') return;
            form.dataset.submitted = '0';
            if (pop) pop.hidden = false;
          });
        }

        function closePop() {
          if (pop) pop.hidden = true;
        }

        if (okBtn) okBtn.addEventListener('click', closePop);

        document.addEventListener('click', function (e) {
          if (e.target && e.target.hasAttribute('data-berg-close')) closePop();
        });

        document.addEventListener('keydown', function (e) {
          if (e.key === 'Escape') closePop();
        });

        function splitDateToFields(dateStr, yearEl, monthEl, dayEl) {
  if (!dateStr) {
    yearEl.value = '';
    monthEl.value = '';
    dayEl.value = '';
    return;
  }
  const d = new Date(dateStr + 'T00:00:00');
  if (isNaN(d.getTime())) return;

  const y = d.getFullYear();
  const m = d.toLocaleString('en-US', { month: 'long' }); // "January"...
  const day = String(d.getDate());

  yearEl.value = String(y);
  monthEl.value = m;
  dayEl.value = day;
}

// Main member
const birthDate = document.getElementById('birth_date');
const birthYear = form.querySelector('input[name="birth_year"]');
const birthMonth = form.querySelector('input[name="birth_month"]');
const birthDay = form.querySelector('input[name="birth_day"]');

if (birthDate && birthYear && birthMonth && birthDay) {
  birthDate.addEventListener('change', () => {
    splitDateToFields(birthDate.value, birthYear, birthMonth, birthDay);
  });
}

// Partner
const partnerDate = document.getElementById('partner_birth_date');
const pYear = form.querySelector('input[name="partner_birth_year"]');
const pMonth = form.querySelector('input[name="partner_birth_month"]');
const pDay = form.querySelector('input[name="partner_birth_day"]');

if (partnerDate && pYear && pMonth && pDay) {
  partnerDate.addEventListener('change', () => {
    splitDateToFields(partnerDate.value, pYear, pMonth, pDay);
  });
}

// Children (each child card)
function wireChildDate(card) {
  const dateEl = card.querySelector('.child-birth-date');
  const y = card.querySelector('input[name="child_birth_year[]"]');
  const m = card.querySelector('input[name="child_birth_month[]"]');
  const d = card.querySelector('input[name="child_birth_day[]"]');
  if (!dateEl || !y || !m || !d) return;

  dateEl.addEventListener('change', () => {
    splitDateToFields(dateEl.value, y, m, d);
  });
}

// whenever a child is added, call wireChildDate(newCard)
// if you already have code that creates child cards, after you append the new card:
// wireChildDate(newCard);

// Also wire existing children (if any)
if (childrenList) {
  childrenList.querySelectorAll('.berg-child-card').forEach(wireChildDate);
}

// On submit ensure hidden fields are filled (in case user never blurs)
form.addEventListener('submit', function () {
  if (birthDate && birthYear && birthMonth && birthDay) {
    splitDateToFields(birthDate.value, birthYear, birthMonth, birthDay);
  }
  if (partnerDate && pYear && pMonth && pDay) {
    splitDateToFields(partnerDate.value, pYear, pMonth, pDay);
  }
  if (childrenList) {
    childrenList.querySelectorAll('.berg-child-card').forEach(card => {
      wireChildDate(card);
      const dateEl = card.querySelector('.child-birth-date');
      const y = card.querySelector('input[name="child_birth_year[]"]');
      const m = card.querySelector('input[name="child_birth_month[]"]');
      const d = card.querySelector('input[name="child_birth_day[]"]');
      if (dateEl && y && m && d) splitDateToFields(dateEl.value, y, m, d);
    });
  }
});



      })();
    </script>
     
 <script>   
    document.addEventListener("DOMContentLoaded", function () {

  const form = document.getElementById("bergMembershipForm");

  form.addEventListener("submit", function (e) {

    const requiredFields = form.querySelectorAll("[required]");
    let firstInvalid = null;

    requiredFields.forEach(field => {

      field.classList.remove("berg-invalid");

      if (!field.checkValidity()) {

        field.classList.add("berg-invalid");

        if (!firstInvalid) {
          firstInvalid = field;
        }
      }

    });

    if (firstInvalid) {

      e.preventDefault();

      const stepPanel = firstInvalid.closest(".berg-step-panel");
      if (stepPanel && stepPanel.hasAttribute("hidden")) {
        stepPanel.hidden = false;
      }

      firstInvalid.scrollIntoView({
        behavior: "smooth",
        block: "center"
      });

      firstInvalid.focus();

    }

  });

});

document.querySelectorAll("#bergMembershipForm [required]").forEach(field => {

  field.addEventListener("input", function () {
    if (field.checkValidity()) {
      field.classList.remove("berg-invalid");
    }
  });

});
</script>
  </body>
</html>
