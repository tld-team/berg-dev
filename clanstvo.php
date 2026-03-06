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
<html class="no-js" lang="sr">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="author" content="https://is.gd/a33FWT" />
    <title>BERG Membership Program - Članstvo</title>

    <meta name="description" content="BERG Membership Program - Članstvo" />
    <meta name="keywords" content="BERG Membership Program - Članstvo" />
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
        Koristite <strong>zastareli</strong> pregledač. Molimo vas da
        <a href="https://browsehappy.com/">ažurirate pregledač</a> radi boljeg
        iskustva i bezbednosti.
      </p>
    <![endif]-->

    <?php require __DIR__ . '/header-sr.php'; ?>

    <main class="main">
      <!--================= Breadcrumb Area start =================-->
      <section class="vs-breadcrumb" data-bg-src="./assets/img/berg-membership-membership.png">
        <div class="container">
          <div class="row text-center">
            <div class="col-12">
              <div class="breadcrumb-content">
                <h1 class="breadcrumb-title">Članstvo</h1>
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
                </p> -->
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

      <!-- MEMBERSHIP ORDER -->
      <section class="vs-tour-package space pb-5" id="membership-programs" style="background-color: #fdf8f5">
        <div class="container">
          <div class="row justify-content-between align-items-center">
            <div class="col-12">
              <div class="title-area text-center">
                <span class="sec-subtitle fade-anim" data-direction="bottom">ČLANSKI PROGRAMI</span>
                <h2 class="sec-title fade-anim" data-direction="top">Izaberite program koji odgovara vašem stilu avanture.</h2>
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
        <p class="mb-10"><strong>Pokrivenost:</strong> Širom sveta</p>
        <p class="mb-0"><strong>SAR nadmorska visina:</strong> do 6000 m</p>
      </div>

      <div class="berg-plan-select">
        <label class="form-label mb-2"><strong>Izaberite tip člana</strong></label>

        <div class="berg-select-ui" data-sync-select="explorerType">
          <button type="button" class="berg-select-ui__btn" aria-haspopup="listbox" aria-expanded="false">
            <span class="berg-select-ui__value">
              <span class="berg-opt-left">
                Odrasli <span class="berg-opt-meta">(rođ. 1998 - 1962)</span>
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
              <span class="berg-opt-left">Odrasli <span class="berg-opt-meta">(rođ. 1998 - 1962)</span></span>
              <span class="berg-opt-right">
                <strong class="berg-opt-price">
                  <span style="text-decoration: line-through; opacity:0.6;">95 €</span> 85 €
                </strong>
              </span>
            </li>

            <li class="berg-select-ui__opt" role="option" data-value="senior">
              <span class="berg-opt-left">Senior <span class="berg-opt-meta">(rođ. 1961 i stariji)</span></span>
              <span class="berg-opt-right">
                <strong class="berg-opt-price">
                  <span style="text-decoration: line-through; opacity:0.6;">74 €</span> 68 €
                </strong>
              </span>
            </li>

            <li class="berg-select-ui__opt" role="option" data-value="junior">
              <span class="berg-opt-left">Junior <span class="berg-opt-meta">(rođ. 1999 - 2007)</span></span>
              <span class="berg-opt-right">
                <strong class="berg-opt-price">
                  <span style="text-decoration: line-through; opacity:0.6;">74 €</span> 68 €
                </strong>
              </span>
            </li>

            <li class="berg-select-ui__opt" role="option" data-value="mountain_rescuer">
              <span class="berg-opt-left">Gorski spasilac <span class="berg-opt-meta">(sertifikovana aktivna gorska služba spasavanja)</span></span>
              <span class="berg-opt-right">
                <strong class="berg-opt-price">
                  <span style="text-decoration: line-through; opacity:0.6;">74 €</span> 68 €
                </strong>
              </span>
            </li>

            <li class="berg-select-ui__opt" role="option" data-value="child">
              <span class="berg-opt-left">Dete <span class="berg-opt-meta">(rođ. 2008 i mlađi)</span></span>
              <span class="berg-opt-right">
                <strong class="berg-opt-price">
                  <span style="text-decoration: line-through; opacity:0.6;">41 €</span> 38 €
                </strong>
              </span>
            </li>

            <li class="berg-select-ui__opt" role="option" data-value="disabled">
              <span class="berg-opt-left">Osoba sa invaliditetom <span class="berg-opt-meta">(preko 50% i uključujući 50%)</span></span>
              <span class="berg-opt-right">
                <strong class="berg-opt-price">
                  <span style="text-decoration: line-through; opacity:0.6;">41 €</span> 38 €
                </strong>
              </span>
            </li>

          </ul>

          <select class="form-select berg-select berg-select-native" data-role="explorerType" hidden aria-hidden="true">
            <option value="adult" selected>Odrasli (rođ. 1998 - 1962) 85 €</option>
            <option value="senior">Senior (rođ. 1961 i stariji) 68 €</option>
            <option value="junior">Junior (rođ. 1999 - 2007) 68 €</option>
            <option value="mountain_rescuer">Gorski spasilac (sertifikovana aktivna gorska služba spasavanja) 68 €</option>
            <option value="child">Dete (rođ. 2008 i mlađi) 38 €</option>
            <option value="disabled">Osoba sa invaliditetom (preko 50% i uključujući 50%) 38 €</option>
          </select>

        </div>
      </div>

      <div class="berg-plan-footer">
        <p class="mb-0">
          Zvanični
          <img src="assets/img/partners/alpenverein.png" style="height: 50px" alt="" />
          partner
        </p>
      </div>

      <div class="berg-plan-actions">
        <a href="#berg-order-start" class="vs-btn style7 w-100 berg-buy-btn" role="button">KUPI ODMAH</a>
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
        <p class="mb-10"><strong>Pokrivenost:</strong> Širom sveta</p>
        <p class="mb-0"><strong>SAR nadmorska visina:</strong> do 6000 m</p>
      </div>

      <div class="berg-plan-select">
        <label class="form-label mb-2"><strong>Izaberite porodičnu opciju</strong></label>

        <div class="berg-select-ui" data-sync-select="familyType">
          <button type="button" class="berg-select-ui__btn" aria-haspopup="listbox" aria-expanded="false">
            <span class="berg-select-ui__value">
              <span class="berg-opt-left">
                Bračni par ili partneri <span class="berg-opt-meta">(deca besplatno)</span>
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
              <span class="berg-opt-left">Bračni par ili partneri <span class="berg-opt-meta">(deca besplatno)</span></span>
              <span class="berg-opt-right">
                <strong class="berg-opt-price">
                  <span style="text-decoration: line-through; opacity:0.6;">169 €</span> 154 €
                </strong>
              </span>
            </li>

            <li class="berg-select-ui__opt" role="option" data-value="single">
              <span class="berg-opt-left">Samohrani roditelj sa decom <span class="berg-opt-meta">(razveden/a, udovac/udovica, itd.)</span></span>
              <span class="berg-opt-right">
                <strong class="berg-opt-price">
                  <span style="text-decoration: line-through; opacity:0.6;">95 €</span> 85 €
                </strong>
              </span>
            </li>

          </ul>

          <select class="form-select berg-select berg-select-native" data-role="familyType" hidden aria-hidden="true">
            <option value="couple" selected>Bračni par ili partneri (deca besplatno) 154 €</option>
            <option value="single">Samohrani roditelj sa decom (razveden/a, udovac/udovica, itd.) 85 €</option>
          </select>

        </div>
      </div>

      <div class="berg-plan-footer">
        <p class="mb-0">
          Zvanični
          <img src="assets/img/partners/alpenverein.png" style="height: 50px" alt="" />
          partner
        </p>
      </div>

      <div class="berg-plan-actions">
        <a href="#berg-order-start" class="vs-btn style7 w-100 berg-buy-btn" role="button">KUPI ODMAH</a>
      </div>
    </div>
  </div>

</div>

              <div class="text-center mt-25">
                <p class="mb-30">
                  Svi programi uključuju istu pokrivenost putovanja i gorskog spasavanja širom sveta do 6.000 m.
                </p>
              </div>

              <div class="col-12 mt-50 mb-25 text-center">
                <a href="benefits.php" class="vs-btn style7">POGLEDAJ SVE POGODNOSTI</a>
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
                      <span class="berg-step-label">IZABERITE KATEGORIJU</span>
                    </div>
                    <div class="berg-step" data-step="2">
                      <span class="berg-step-num">2</span>
                      <span class="berg-step-label">LIČNI PODACI</span>
                    </div>
                    <div class="berg-step" data-step="3">
                      <span class="berg-step-num">3</span>
                      <span class="berg-step-label">KONTAKT</span>
                    </div>
                  </div>

                  <!-- STEP 1 -->
                  <div class="berg-step-panel" data-step-panel="1">
                    <div class="berg-panel-card berg-panel-card--step1">
                      <div class="berg-step1-wrap">
                        <h4 class="mb-15 text-left">1. Izaberite kategoriju</h4>

                        <div class="berg-summary berg-summary--step1">
                          <p><strong>Izabrani program:</strong> <span id="bergSelectedPlan">—</span></p>
                          <p><strong>Opcija:</strong> <span id="bergSelectedOption">—</span></p>
                          <p><strong>Cena:</strong> <span id="bergSelectedPrice">—</span></p>
                        </div>

                        <div class="berg-actions-row berg-actions-row--step1">
                          <button type="button" class="vs-btn style7 berg-next" data-next="2">Sledeći korak</button>
                          <button type="button" class="vs-btn style7 berg-cancel">Otkaži</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- STEP 2 -->
                  <div class="berg-step-panel" data-step-panel="2" hidden>
                    <div class="berg-panel-card">
                      <h4 class="mb-15 text-center">2. Lični podaci</h4>

                      <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label">Ime *</label>
                          <input class="form-control" type="text" name="first_name" required />
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Prezime *</label>
                          <input class="form-control" type="text" name="last_name" required />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Datum rođenja *</label>
                            <input class="form-control" type="date" id="birth_date" required />
                            <input type="hidden" name="birth_year" required />
<input type="hidden" name="birth_month" required />
<input type="hidden" name="birth_day" required />

                        </div>


                        <div class="col-md-6">
                          <label class="form-label">Pol *</label>
                          <select class="form-select" name="gender" required>
                            <option value="">—</option>
                            <option value="male">Muški</option>
                            <option value="female">Ženski</option>
                          </select>
                        </div>
                      </div>

                      <!-- PARTNER -->
                      <div id="bergPartnerBlock" class="berg-subblock mt-25" hidden>
                        <h5 class="mb-15">Suprug/supruga ili partner</h5>

                        <div class="row g-3">
                          <div class="col-md-6">
                            <label class="form-label">Ime *</label>
                            <input class="form-control" type="text" name="partner_first_name" />
                          </div>
                          <div class="col-md-6">
                            <label class="form-label">Prezime *</label>
                            <input class="form-control" type="text" name="partner_last_name" />
                          </div>

                          <div class="col-md-6">
                            <label class="form-label">Datum rođenja *</label>
                            <input class="form-control" type="date" id="partner_birth_date" />
                            <input type="hidden" name="partner_birth_year" />
                            <input type="hidden" name="partner_birth_month" />
                            <input type="hidden" name="partner_birth_day" />


                          </div>


                          <div class="col-md-6">
                            <label class="form-label">Pol *</label>
                            <select class="form-select" name="partner_gender">
                              <option value="">—</option>
                              <option value="male">Muški</option>
                              <option value="female">Ženski</option>
                            </select>
                          </div>
                        </div>

                        <!-- CHILDREN -->
                        <div class="mt-25">
                          <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <h5 class="mb-0">Deca</h5>
                            <button type="button" class="vs-btn style7 berg-add-child">Dodaj dete</button>
                          </div>

                          <div id="bergChildrenList" class="mt-15"></div>

                          <template id="bergChildTpl">
                            <div class="berg-child-card">
                              <div class="d-flex align-items-center justify-content-between">
                                <h6 class="mb-0 berg-child-title">Dete</h6>
                                <button type="button" class="berg-child-remove" aria-label="Remove child">×</button>
                              </div>

                              <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                  <label class="form-label">Kategorija *</label>
                                  <select class="form-select" name="child_category[]">
                                    <option value="student">Student uzrasta od 19 do 27 godina</option>
                                    <option value="child">Dete do 18 godina</option>
                                  </select>
                                </div>

                                <div class="col-md-6">
                                  <label class="form-label">Ime *</label>
                                  <input class="form-control" type="text" name="child_first_name[]" />
                                </div>
                                <div class="col-md-6">
                                  <label class="form-label">Prezime *</label>
                                  <input class="form-control" type="text" name="child_last_name[]" />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Datum rođenja *</label>
                                    <input class="form-control" type="date" class="child-birth-date" />
                                    <input type="hidden" name="child_birth_year[]" />
<input type="hidden" name="child_birth_month[]" />
<input type="hidden" name="child_birth_day[]" />

                                </div>


                                <div class="col-md-6">
                                  <label class="form-label">Pol *</label>
                                  <select class="form-select" name="child_gender[]">
                                    <option value="">—</option>
                                    <option value="male">Muški</option>
                                    <option value="female">Ženski</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </template>
                        </div>
                      </div>

                      <div class="berg-actions-row mt-25">
                        <button type="button" class="vs-btn style7 berg-prev" data-prev="1">Nazad</button>
                        <button type="button" class="vs-btn style7 berg-next" data-next="3">Sledeći korak</button>
                      </div>
                    </div>
                  </div>

                  <!-- STEP 3 -->
                  <div class="berg-step-panel" data-step-panel="3" hidden>
                    <div class="berg-panel-card">
                      <h4 class="mb-15 text-center">3. Kontakt</h4>

                      <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label">Email *</label>
                          <input class="form-control" type="email" name="email" required />
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Telefon *</label>
                          <input class="form-control" type="tel" name="phone" required />
                        </div>

                        <div class="col-md-8">
                          <label class="form-label">Ulica *</label>
                          <input class="form-control" type="text" name="street" required />
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Broj *</label>
                          <input class="form-control" type="text" name="house_number" required />
                        </div>

                        <div class="col-md-6">
                          <label class="form-label">Grad *</label>
                          <input class="form-control" type="text" name="city" required />
                        </div>
                        <div class="col-md-3">
                          <label class="form-label">Poštanski broj *</label>
                          <input class="form-control" type="text" name="zip" required />
                        </div>
                        <div class="col-md-3">
                          <label class="form-label">Država *</label>
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
      Podnošenjem prijave za članstvo potvrđujem da sam pročitao/la
      <a
        href="https://www.alpenverein.at/portal_wAssets/docs/service/versicherung/AWS-Folder_E_2023_ebook.pdf"
        target="_blank"
        rel="noopener"
        style="color:#75764e;"
      >brošuru</a>
      i prihvatam sve uslove i odredbe sadržane u njoj.
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
                        <button type="button" class="vs-btn style7 berg-prev" data-prev="2">Nazad</button>
                        <button type="submit" class="vs-btn style7 berg-submit">Potvrdi porudžbinu</button>
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

                  <div class="berg-pop__kicker">ČLANSTVO</div>
                  <h3 id="bergThankYouTitle" class="berg-pop__title">Hvala!</h3>

                  <p class="berg-pop__text">
                    Vaša prijava je primljena. Uputstva za plaćanje biće poslata putem emaila, a mi ćemo vas kontaktirati uskoro nakon obrade vaše prijave.
                    Za sva pitanja, slobodno nam pišite na
                    <a href="mailto:info@bergmembership.com">info@bergmembership.com</a>
                  </p>

                  <center><button type="button" class="vs-btn style7 w-100" id="bergThankYouOk">U REDU</button></center>
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
    
<script>
(function () {
  function showOrderSection() {
    const order = document.getElementById('berg-order');
    if (order) {
      order.hidden = false;
      order.removeAttribute('hidden');
      // ako neki CSS ili JS koristi klase, neće smetati
      order.style.display = '';
    }
  }

  function setStep(step) {
    // Steps header
    document.querySelectorAll('.berg-step').forEach(s => {
      s.classList.toggle('is-active', s.getAttribute('data-step') === String(step));
    });
    // Panels
    document.querySelectorAll('.berg-step-panel').forEach(p => {
      const isTarget = p.getAttribute('data-step-panel') === String(step);
      p.hidden = !isTarget;
      if (isTarget) p.removeAttribute('hidden');
    });
  }

  function getSelectedOptionText(card) {
    // uzmi native select vrednost (pošto je custom UI sync često komplikovan)
    const native = card.querySelector('select.berg-select-native');
    if (!native) return { option: '—', price: '—' };

    const opt = native.options[native.selectedIndex];
    const label = (opt && opt.textContent || '').trim();

    // pokušaj da izvučeš cenu (npr "95 €") iz teksta
    const m = label.match(/(\d+[.,]?\d*)\s*€/);
    return {
      option: label || '—',
      price: m ? (m[0].replace(/\s+/g, ' ').trim()) : '—'
    };
  }

  function humanPlanName(plan) {
    // mapiraj ako želiš lepši naziv
    if (plan === 'explorer') return 'BERG EXPLORER';
    if (plan === 'family') return 'BERG FAMILY';
    return plan || '—';
  }

  document.addEventListener('click', function (e) {
    const btn = e.target.closest('a.berg-buy-btn');
    if (!btn) return;

    // Uvek preuzmi kontrolu: i scroll i otvaranje sekcije
    e.preventDefault();
    e.stopImmediatePropagation();

    const card = btn.closest('.berg-plan-card');
    const plan = card ? card.getAttribute('data-plan') : '';
    const { option, price } = card ? getSelectedOptionText(card) : { option: '—', price: '—' };

    // popuni summary (da ne ostane prazno)
    const planText = humanPlanName(plan);
    const spPlan  = document.getElementById('bergSelectedPlan');
    const spOpt   = document.getElementById('bergSelectedOption');
    const spPrice = document.getElementById('bergSelectedPrice');

    if (spPlan)  spPlan.textContent  = planText;
    if (spOpt)   spOpt.textContent   = option;
    if (spPrice) spPrice.textContent = price;

    // popuni hidden inpute koji idu u form
    const inPlan  = document.getElementById('bergPlanValue');
    const inOpt   = document.getElementById('bergOptionValue');
    const inPrice = document.getElementById('bergPriceValue');

    if (inPlan)  inPlan.value  = planText;
    if (inOpt)   inOpt.value   = option;
    if (inPrice) inPrice.value = price;

    // otvori order i vrati na step 1
    showOrderSection();
    setStep(1);

    // skroluj na anchor (ili direktno na order)
    const anchor = document.getElementById('berg-order-start') || document.getElementById('berg-order');
    if (anchor) {
      anchor.scrollIntoView({ behavior: 'smooth', block: 'start' });
      history.replaceState(null, '', '#berg-order-start');
    }
  }, true); // capture da pobedi ostale handlere
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
