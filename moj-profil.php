<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

$isUserLoggedIn = !empty($_SESSION['user_id']);

if (!$isUserLoggedIn) {
  header('Location: login.php');
  exit;
}

// DB konekcija: zameni sa tvojim fajlom/varijablom
require_once 'admin/db.php'; // očekujem da ovde dobiješ $mysqli (mysqli konekciju)

$userId = (int)$_SESSION['user_id'];

// CSRF
if (empty($_SESSION['csrf_emergency'])) {
  $_SESSION['csrf_emergency'] = bin2hex(random_bytes(16));
}
$csrf = $_SESSION['csrf_emergency'];

$flash = ''; // poruka posle update-a

// 1) Učitaj osnovne podatke user-a (ime/prezime + id)
$stmt = $mysqli->prepare("SELECT id, first_name, last_name FROM user WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
  // ako user_id u sesiji ne postoji u bazi
  header('Location: logout.php');
  exit;
}

// 2) Update emergency podataka
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update_emergency') {
  $postedCsrf = (string)($_POST['csrf'] ?? '');
  if (!hash_equals($csrf, $postedCsrf)) {
    $flash = 'Bezbednosna provera nije uspela. Osveži stranicu i pokušaj ponovo.';
  } else {
    $blood = trim((string)($_POST['blood_group'] ?? ''));
    $allergies = trim((string)($_POST['allergies'] ?? ''));
    $chronic = trim((string)($_POST['chronic_conditions'] ?? ''));
    $meds = trim((string)($_POST['medications'] ?? ''));
    $prev = trim((string)($_POST['previous_surgeries'] ?? ''));
    $addr = trim((string)($_POST['address'] ?? ''));
    $ec1 = trim((string)($_POST['emergency_contact1'] ?? ''));
    $ec2 = trim((string)($_POST['emergency_contact2'] ?? ''));

    // opcionalno: ograničenja dužine za kontakte/krvnu grupu
    $blood = mb_substr($blood, 0, 10);
    $ec1 = mb_substr($ec1, 0, 255);
    $ec2 = mb_substr($ec2, 0, 255);

    $sql = "
      INSERT INTO user_emergency
        (user_id, blood_group, allergies, chronic_conditions, medications, previous_surgeries, address, emergency_contact1, emergency_contact2)
      VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?)
      ON DUPLICATE KEY UPDATE
        blood_group = VALUES(blood_group),
        allergies = VALUES(allergies),
        chronic_conditions = VALUES(chronic_conditions),
        medications = VALUES(medications),
        previous_surgeries = VALUES(previous_surgeries),
        address = VALUES(address),
        emergency_contact1 = VALUES(emergency_contact1),
        emergency_contact2 = VALUES(emergency_contact2)
    ";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param(
      "issssssss",
      $userId,
      $blood,
      $allergies,
      $chronic,
      $meds,
      $prev,
      $addr,
      $ec1,
      $ec2
    );
    $ok = $stmt->execute();
    $stmt->close();

    $flash = $ok ? 'Emergency ID kartica je ažurirana.' : 'Ažuriranje nije uspelo. Pokušaj ponovo.';
  }
}

// 3) Učitaj emergency podatke (posle update-a ili inicijalno)
$stmt = $mysqli->prepare("SELECT * FROM user_emergency WHERE user_id = ? LIMIT 1");
$stmt->bind_param("i", $userId);
$stmt->execute();
$em = $stmt->get_result()->fetch_assoc() ?: [];
$stmt->close();

// 4) Izračunaj Emergency ID
$year = 2026; // ako hoćeš automatski: (int)date('Y')
$emergencyId = sprintf('#%04d-%d', $userId, $year);

$fullName = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
if ($fullName === '') $fullName = 'Član';




// opcionalno: za redirect nazad na istu stranicu posle logout-a
$currentUrl = (string)($_SERVER['REQUEST_URI'] ?? '/');
$logoutHref = 'logout.php?next=' . urlencode($currentUrl);
$loginHref  = 'login.php';

$authHref = $isUserLoggedIn ? $logoutHref : $loginHref;
$authText = $isUserLoggedIn ? 'Odjava' : 'Prijava';

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
    <title>BERG Membership Program - Moj profil</title>

    <meta name="description" content="BERG Membership Program - Benefiti" />
    <meta name="keywords" content="BERG Membership Program - Benefiti" />
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
    <!-- <link rel="manifest" href="assets/img/favicons/manifest.json" /> -->
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
    
    <link rel="manifest" href="/manifest-emergency.webmanifest">
    <link rel="apple-touch-icon" href="/assets/img/pwa/apple-touch-icon.png">
    <meta name="theme-color" content="#75754f">


    <style>
        .ma-pop[hidden]{display:none !important;}
.ma-pop{
  position: fixed !important;
  inset: 0 !important;
  z-index: 999999 !important;
}
.ma-pop__backdrop{
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,.55);
}

.ma-pop__dialog{
  position: absolute !important;
  left: 50% !important;
  top: 50% !important;
  transform: translate(-50%, -50%) !important;
  width: min(720px, calc(100vw - 32px)) !important;
  max-height: calc(100vh - 32px) !important;
  overflow: auto !important;
}

    </style>
  </head>

  <body class="vs-body">
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        Koristiš <strong>zastareli</strong> browser. Molimo te
        <a href="https://browsehappy.com/">nadogradi browser</a> kako bi poboljšao/la
        iskustvo i bezbednost.
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
        data-bg-src="./assets/img/berg-membership-courses.png"
      >
        <div class="container">
          <div class="row text-center">
            <div class="col-12">
              <div class="breadcrumb-content">
                <h1 class="breadcrumb-title">Moj profil</h1>
              </div>
              <div class="breadcrumb-content">
                <h5 class="mt-4" style="color: white">
                  Sve što ti treba za bezbednu avanturu u prirodi, na jednoj kartici.
                </h5>
              </div>
              <div class="breadcrumb-content">
                <p class="mt-4" style="color: white">
                  Pogledaj šta dobijaš uz BERG: zaštitu pri spasavanju širom sveta,
                  pogodnosti za članove i praktičan pristup koji podržava tvoj
                  outdoor stil života.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!--================= Breadcrumb Area end =================-->

      <!--================= MEMBER ACCESS / MY PROFILE (4 TILES + PANEL) start =================-->
    <section
    class="vs-tour-package space pb-5"
    id="member-access"
    data-bg-src="assets/img/bg/destination.png"
    >
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-12">
            <div class="title-area text-center">
            <span class="sec-subtitle fade-anim" data-direction="bottom">MOJ PROFIL</span>
            <h2 class="sec-title fade-anim" data-direction="top">
                Tvoj hitan pristup, SOS i dokumenti na jednom mestu.
            </h2>
            </div>
        </div>
        </div>

        <div id="memberProfile" class="ma-wrap mt-30">

        <!-- II) 4 BIG TILES (2x2 on desktop AND phone) -->
        <div class="ma-tiles" role="tablist" aria-label="Emergency tabs">
            <!-- 1) SOS -->
            <button type="button" class="ma-tile ma-tile--sos is-active" data-key="sos" role="tab" aria-selected="true">
            <div class="ma-tile__badge">1</div>
            <div class="ma-tile__title">SOS</div>
            <div class="ma-tile__hint">Hitne radnje za spasavanje</div>
            </button>

            <!-- 2) MY EMERGENCY DOCUMENTS -->
            <button type="button" class="ma-tile ma-tile--strong" data-key="docs" role="tab" aria-selected="false">
            <div class="ma-tile__badge">2</div>
            <div class="ma-tile__title">MOJI HITNI DOKUMENTI</div>
            <div class="ma-tile__hint">ID + PDF osiguranja</div>
            </button>

            <!-- 3) Report Accident --><a href="https://alpenverein.sichermitknox.com/schadenmelden">
            <button type="button" class="ma-tile" data-key="accident" role="tab" aria-selected="false" onclick="https://alpenverein.sichermitknox.com/schadenmelden" style="width:100%;">
            <div class="ma-tile__badge">3</div>
            <div class="ma-tile__title">PRIJAVI NEZGODU</div>
            <div class="ma-tile__hint">Koraci i uputstvo za prijavu</div>
            </button></a>

            <!-- 4) Helpline -->
            <a href="https://alpenverein.sichermitknox.com/helpline-login">
            <button type="button" class="ma-tile" data-key="helpline" role="tab" aria-selected="false" style="width:100%;">
            <div class="ma-tile__badge">4</div>
            <div class="ma-tile__title">HELPLINE</div>
            <div class="ma-tile__hint">Aktivacija i kontakti</div>
            </button></a>
        </div>

        <!-- DETAILS PANEL (opens below tiles) -->
        <div class="ma-panel" id="maPanel" hidden>
            <div class="ma-panel__head">
            <h3 class="ma-panel__title" id="maPanelTitle">SOS</h3>

            <!-- X close -->
            <button type="button" class="ma-panel__close" id="maClosePanel" aria-label="Zatvori">×</button>
            </div>

            <div class="ma-panel__body">
            <!-- SOS PANEL (TAB 1) - REPLACE ENTIRE BLOCK -->
            <div class="ma-section ma-sos" data-section="sos">
            <h4 class="ma-h4 ma-sos__h1">Treba ti spasavanje odmah?</h4>

            <div class="ma-sos__actions">
                <a
                class="vs-btn style7 ma-sos__btn ma-sos__btn--primary"
                href="tel:112"
                id="btnCall112"
                >
                POZOVI 112 (EU hitni broj)
                </a>

                <button
                type="button"
                class="vs-btn style7 ma-sos__btn"
                id="btnLocalRescue"
                aria-expanded="true"
                aria-controls="maLocalRescueBox"
                ><a href="#lmrn" style="color: var(--berg-olive) !important;">
                Lokalni brojevi gorske službe spašavanja</a>
                </button>
            </div>

            <div class="ma-sos__banner" role="note">
                “112 radi u većini evropskih zemalja.”
            </div>

            <div class="ma-sos__mini" role="note">
                <div class="ma-sos__miniTitle">Nema signala?</div>
                <ul class="ma-sos__miniList">
                <li>Idi na viši teren ili greben.</li>
                <li>Obrati pažnju na smer vetra i ostani vidljiv/a.</li>
                <li>Ako možeš, pošalji lokaciju putem SMS-a.</li>
                </ul>
            </div>

            <!-- LOCAL RESCUE LIST (VISIBLE BY DEFAULT) -->
            <div class="ma-card mt-20 ma-sos__local" id="maLocalRescueBox">
                <div class="ma-sos__localTop">
                <div>
                    <div class="ma-card__title ma-sos__localTitle">Lokalni brojevi za spasavanje (offline lista)</div>
                    <div class="ma-sos__sub" id="maRescueHint" aria-live="polite"></div>
                </div>

                <div class="ma-sos__cachePill" id="maCachePill" title="Status offline keša">
                    <span class="ma-sos__dot" aria-hidden="true"></span>
                    <span id="maCacheText">Nije keširano</span>
                </div>
                </div>

                <div class="ma-sos__tools mt-12">
                <div class="ma-sos__searchWrap">
                    <input
                    type="text"
                    class="form-control ma-input ma-sos__search"
                    id="maRescueSearch"
                    placeholder="Pretraga po zemlji, ISO kodu, hitnom broju ili SAR (npr. Srbija / SRB / 112)..."
                    autocomplete="off"
                    />
                    <div class="ma-sos__count" id="maRescueCount">Prikazano: 0 rezultata</div>
                </div>

                <div class="ma-sos__dlWrap">
                    <button type="button" class="vs-btn style7 ma-docs__btn" id="maDownloadCsv">
                    Preuzmi kompletnu listu
                    </button>
                    <button type="button" class="vs-btn style7 ma-docs__btn" id="maDownloadPdf">
                    Preuzmi PDF
                    </button>
                    <button type="button" class="vs-btn style7 ma-docs__btn" id="maCacheList">
                    Sačuvaj listu offline
                    </button>
                </div>
                </div>

                <div class="ma-rescue-table mt-14" role="table" aria-label="Hitni i SAR brojevi po zemlji">
                <div class="ma-rescue-head" role="rowgroup">
                    <div class="ma-rescue-row ma-rescue-row--head" role="row" id="lmrn">
                    <div class="ma-rescue-cell" role="columnheader">ISO</div>
                    <div class="ma-rescue-cell" role="columnheader">Zemlja</div>
                    <div class="ma-rescue-cell ma-rescue-cell--right" role="columnheader">Hitni broj</div>
                    <div class="ma-rescue-cell ma-rescue-cell--right" role="columnheader">SAR</div>
                    </div>
                </div>

                <!-- FIRST ~10 are visible; rest scrolls -->
                <div class="ma-rescue-body" id="maRescueList" role="rowgroup" tabindex="0"></div>

                <div class="ma-rescue-empty" id="maRescueEmpty" hidden>
                    Nema poklapanja. Pokušaj drugi pojam.
                </div>
                </div>

                <!-- SAR + data disclaimer -->
                <details class="ma-sos__disclaimer mt-16">
                <summary class="ma-sos__disclaimerSummary">Napomena za SAR i tačnost podataka</summary>

                <div class="ma-sos__disclaimerBody">
                    <p>
                    <strong>SAR broj</strong> predstavlja kontakt specijalizovane službe Search and Rescue u zemljama gde takva služba ima poseban telefonski broj.
                    Ako zemlja nema poseban SAR broj, Search and Rescue se aktivira preko nacionalnog hitnog broja (npr. 112, 911, 999, 000).
                    </p>

                    <p><strong>Preporuka:</strong> uvek prvo pozovi nacionalni hitni broj, posebno kada:</p>
                    <ul>
                    <li>postoji rizik po život ili zdravlje,</li>
                    <li>signal je ograničen,</li>
                    <li>nije jasno da li postoji lokalna planinska jedinica,</li>
                    <li>pozivalac ne može da podeli tačnu lokaciju,</li>
                    <li>potrebna je koordinacija sa medicinskim službama, policijom ili vatrogascima.</li>
                    </ul>

                    <p>
                    Koristi SAR broj samo tamo gde je zvanično definisan i kada znaš da direktno zoveš specijalizovanu jedinicu.
                    Ako nisi siguran/na koji broj da pozoveš, koristi nacionalni hitni broj — to je jedina služba koja je zakonski obavezna da primi poziv,
                    koordinira i prosledi intervenciju nadležnim SAR timovima.
                    </p>

                    <p class="mb-0">
                    Svi hitni i SAR kontakti prikazani ovde služe samo u informativne svrhe. BERG i njegovi tehnički partneri ne garantuju potpunu tačnost,
                    ažurnost niti potpunost. Brojevi se mogu menjati usled propisa, nadležnosti, migracija i operativnih procedura.
                    BERG ne snosi odgovornost za netačnosti, kašnjenja u ažuriranju, nemogućnost uspostavljanja poziva, prekide mreže ili posledice oslanjanja na ove informacije.
                    </p>
                </div>
                </details>

                <!-- Reference -->
                <div class="ma-sos__ref mt-16">
                <div class="ma-sos__refTitle">Referenca / izvor podataka</div>
                <div class="ma-sos__refText">
                    Mnogi hitni brojevi zasnovani su na javno dostupnim međunarodnim zapisima koje objavljuje
                    <strong>ICAR – International Commission for Alpine Rescue</strong>.
                    ICAR listu možeš preuzeti i proveriti ovde:
                    <a class="ma-link" href="https://www.alpine-rescue.org/articles/269--mountain-rescue-service-emergency-phone-numbers" target="_blank" rel="noopener">
                    Emergency Phone Numbers za gorsku službu spašavanja
                    </a>.
                    Direktna PDF referenca: <em>„International Emergency Telephone Codes”</em> (poslednja javna verzija: 31.12.2023).
                </div>
                </div>
            </div>

            <!-- STICKY BOTTOM BANNER (ALWAYS VISIBLE INSIDE TAB) -->
            <div class="ma-bottom-banner ma-bottom-banner--sticky mt-18" role="note">
                <div class="ma-bottom-banner__inner">
                <div class="ma-bottom-banner__text">
                    <div class="ma-bottom-banner__title">
                    Pre repatrijacije ili transporta, moraš kontaktirati Europ Assistance, u suprotnom će maksimalno biti refundirano 750 EUR.
                    </div>
                    <div class="ma-bottom-banner__meta">
                    <span class="ma-bottom-banner__brand">Europ Assistance</span>
                    <a class="ma-bottom-banner__phone" href="tel:+4312533798">+43/1/253 3798</a>
                    </div>
                </div>

                <a
                    class="vs-btn style7 ma-bottom-banner__btn"
                    href="https://alpenverein.sichermitknox.com/schadenmelden"
                    target="_blank"
                    rel="noopener"
                >
                    PRIJAVI HITAN SLUČAJ
                </a>
                </div>
            </div>
            </div>
            <!-- /SOS PANEL -->



            <!-- DOCUMENTS PANEL (TAB 2) -->
            <div class="ma-section ma-docs" data-section="docs" hidden
                data-av-url="/assets/docs/alpenverein-card.pdf"
                data-brochure-url="/assets/docs/insurance-brochure.pdf">

            <h4 class="ma-h4 ma-docs__h1">Moji hitni dokumenti</h4>

            <div class="ma-docs__grid">
                <!-- LEFT: SHOW THIS TO RESCUERS -->
                <div class="ma-card ma-docs__card">
                <div class="ma-card__title">POKAŽI OVO SPASIOCIMA</div>
                <p class="ma-p ma-docs__p">
                    Kartica za brz pristup + brošura. Sačuvaj ih offline pre puta.
                </p>

                <div class="ma-docs__tools">
                    <div class="ma-docs__searchWrap">
                    <div class="ma-docs__hint" id="maDocsHint" aria-live="polite"></div>
                    </div>

                    <div class="ma-docs__actions">
                    <button type="button" class="vs-btn style7 ma-docs__btn" id="btnShowAlpenvereinCard">
                        Prikaži Alpenverein karticu
                    </button>

                    <a class="vs-btn style7 ma-docs__btn"
                            href="./brochure.pdf"
                            download="brochure.pdf" style="color: var(--berg-olive) !important; padding: 0px 0px !important;">
                    <button type="button" class="vs-btn style7 ma-docs__btn" id="btnOpenBrochure">
                        
                                Preuzmi brošuru osiguranja
                        
                    </button></a>

                    <button type="button" class="vs-btn style7 ma-docs__btn ma-docs__btn--ghost" id="btnCacheDocs">
                        Sačuvaj offline
                    </button>
                    </div>
                </div>

                <!-- Viewer (opens in the same tab) -->
                <div class="ma-docs__viewer" id="maDocsViewer" hidden>
                    <div class="ma-docs__viewerTop">
                    <div class="ma-docs__viewerTitle" id="maDocsViewerTitle">Dokument</div>
                    <button type="button" class="ma-docs__viewerClose" id="btnCloseDocsViewer" aria-label="Zatvori">✕</button>
                    </div>

                    <div class="ma-docs__viewerBody">
                    <div class="ma-docs__viewerNotice" id="maDocsViewerNotice" hidden></div>

                    <!-- iframe for PDF display (works with cached blob too) -->
                    <iframe class="ma-docs__iframe" id="maDocsFrame" title="Pregled dokumenta"></iframe>

                    <div class="ma-docs__viewerFooter">
                        <button type="button" class="vs-btn style7 ma-docs__btn ma-docs__btn--ghost" id="btnDownloadCurrent">
                        Preuzmi
                        </button>
                    </div>
                    </div>
                </div>
                </div>

                <!-- RIGHT: EMERGENCY ID -->
                <div class="ma-card ma-docs__card">
                <div class="ma-card__title">EMERGENCY ID</div>
                <p class="ma-p ma-docs__p">
                    Osnovni hitni podaci koji se prikazuju spasiocima ili medicinskom osoblju (placeholder dok korisnik ne unese podatke).
                </p>

                <!-- ID CARD -->
                <div class="ma-idcard" id="maEmergencyIdCard">
  <div class="ma-idcard__top">
    <div class="ma-idcard__photo">
      <img src="assets/avatar.webp" alt="Profilna fotografija" />
    </div>
    <div class="ma-idcard__who">
      <div class="ma-idcard__name"><?= h($fullName) ?></div>
      <div class="ma-idcard__meta">Emergency ID • <strong><?= h($emergencyId) ?></strong></div>

      <?php if (!empty($flash)): ?>
        <div style="margin-top:6px; font-size:13px; opacity:.9;">
          <?= h($flash) ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <form method="POST" class="ma-idcard__form" style="margin-top:12px;">
    <input type="hidden" name="action" value="update_emergency" />
    <input type="hidden" name="csrf" value="<?= h($csrf) ?>" />

    <div class="ma-kv ma-idcard__kv">
      <div class="ma-kv__row">
        <span>Krvna grupa</span>
        <strong style="min-width:180px;">
          <input class="form-control" type="text" name="blood_group" placeholder="npr. O+"
                 value="<?= h((string)($em['blood_group'] ?? '')) ?>" />
        </strong>
      </div>

      <div class="ma-kv__row">
        <span>Alergije</span>
        <strong style="min-width:180px;">
          <input class="form-control" name="allergies"  type="text"
                    placeholder="npr. Penicilin" value="<?= h((string)($em['allergies'] ?? '')) ?>"/>
        </strong>
      </div>

      <div class="ma-kv__row">
        <span>Hronična stanja</span>
        <strong style="min-width:180px;">
          <input class="form-control" name="chronic_conditions"  type="text"
                    placeholder="npr. Astma" value="<?= h((string)($em['chronic_conditions'] ?? '')) ?>"/>
        </strong>
      </div>

      <div class="ma-kv__row">
        <span>Terapija / lekovi</span>
        <strong style="min-width:180px;">
          <input class="form-control" name="medications"  type="text"
                    placeholder="npr. Inhalator" value="<?= h((string)($em['medications'] ?? '')) ?>"/>
        </strong>
      </div>

      <div class="ma-kv__row">
        <span>Prethodne operacije / povrede</span>
        <strong style="min-width:180px;">
          <input class="form-control" name="previous_surgeries"  type="text"
                    placeholder="npr. Operacija kolena 2021" value="<?= h((string)($em['previous_surgeries'] ?? '')) ?>"/>
        </strong>
      </div>

      <div class="ma-kv__row">
        <span>Adresa</span>
        <strong style="min-width:180px;">
          <input class="form-control" name="address"  type="text"
                    placeholder="Ulica, broj, grad" value="<?= h((string)($em['address'] ?? '')) ?>"/>
        </strong>
      </div>

      <div class="ma-kv__row">
        <span>Kontakt za hitne slučajeve 1</span>
        <strong style="min-width:180px;">
          <input class="form-control" type="text" name="emergency_contact1"
                 placeholder="Ime + telefon"
                 value="<?= h((string)($em['emergency_contact1'] ?? '')) ?>" />
        </strong>
      </div>

      <div class="ma-kv__row">
        <span>Kontakt za hitne slučajeve 2</span>
        <strong style="min-width:180px;">
          <input class="form-control" type="text" name="emergency_contact2"
                 placeholder="Ime + telefon"
                 value="<?= h((string)($em['emergency_contact2'] ?? '')) ?>" />
        </strong>
      </div>
    </div>

    <div class="ma-docs__note">
      Pokaži ovu karticu spasiocima ili medicinskom osoblju.
    </div>

    <div class="ma-docs__idActions" style="display:flex; gap:10px; flex-wrap:wrap;">
      <button type="submit" class="vs-btn style7 ma-docs__btn">
        Sačuvaj
      </button>

      <button type="button" class="vs-btn style7 ma-docs__btn" id="btnPrintEmergencyId">
        Preuzmi Emergency ID
      </button>
    </div>
  </form>
</div>

            </div>

            <!-- FIXED BOTTOM BANNER (same markup as other tabs) -->
            <div class="ma-bottom-banner mt-25" role="note">
                <div class="ma-bottom-banner__inner">
                <div class="ma-bottom-banner__text">
                    <div class="ma-bottom-banner__title">
                    Pre repatrijacije ili transporta, moraš kontaktirati Europ Assistance, u suprotnom će maksimalno biti refundirano 750 EUR.
                    </div>
                    <div class="ma-bottom-banner__meta">
                    <span class="ma-bottom-banner__brand">Europ Assistance</span>
                    <a class="ma-bottom-banner__phone" href="tel:+4312533798">+43/1/253 3798</a>
                    </div>
                </div>

                <center><a class="vs-btn style7 ma-bottom-banner__btn"
                    href="https://alpenverein.sichermitknox.com/schadenmelden"
                    target="_blank" rel="noopener">
                    PRIJAVI HITAN SLUČAJ
                </a></center
                </div>
            </div>
            </div>


            <!-- REPORT ACCIDENT PANEL (TAB 3) -->
            <div class="ma-section ma-accident" data-section="accident" hidden>
            <h4 class="ma-h4 ma-accident__h1">Prijavi nezgodu</h4>

            <!-- STEP 1 -->
            <div class="ma-card ma-accident__card">
                <div class="ma-card__title ma-accident__title">KORAK 1 — SPASAVANJE ŽIVOTA</div>
                <p class="ma-p ma-accident__p">
                Ako je neko u opasnosti — odmah pozovi spasilačku službu.
                </p>

                <div class="ma-accident__actions">
                <button type="button" class="vs-btn style7 ma-accident__btn" data-jump="sos">
                    IDI NA SOS
                </button>
                <a class="ma-accident__quick" href="tel:112" aria-label="Pozovi 112">Pozovi 112</a>
                </div>

                <div class="ma-accident__hint">
                Koristi SOS da pronađeš tačan lokalni broj gorske službe spašavanja za tvoju zemlju/region.
                </div>

                <!-- NEW: Battery saver block -->
                <div class="ma-accident__battery">
                <div class="ma-accident__batteryTitle">Ako ti se baterija brzo prazni</div>
                <div class="ma-accident__batteryText">
                    Ako je baterija telefona niska i brzo opada, uradi sledeće:
                </div>
                <ul class="ma-accident__batteryList">
                    <li>Pošalji lokaciju samo jednom — ne koristi uživo praćenje.</li>
                    <li>Zatvori aplikacije koje nisu hitno potrebne.</li>
                    <li>Isključi mobilne podatke, Wi-Fi i Bluetooth.</li>
                    <li>Uključi avion režim kada ne obavljaš pozive.</li>
                    <li>Drži telefon u unutrašnjem džepu da ga greje toplota tela.</li>
                    <li>Izbegavaj slanje poruka, videa i fotografija dok čekaš pomoć.</li>
                </ul>
                <div class="ma-accident__batteryNote">
                    “Čuvanje baterije dok čekaš spasioce može odlučiti ishod.”
                </div>
                </div>
            </div>

            <!-- STEP 2 -->
            <div class="ma-card ma-accident__card mt-15">
                <div class="ma-card__title ma-accident__title">KORAK 2 — TRANSPORT / PODRŠKA U BOLNICI</div>
                <p class="ma-p ma-accident__p">
                Kada si bezbedan/na, stabilizovan/a u bolnici i potreban ti je transport do druge bolnice ili kući:
                </p>

                <div class="ma-accident__contact">
                <div class="ma-accident__brand">Europ Assistance</div>

                <div class="ma-accident__contactLine">
                    <span class="ma-accident__label">Telefon</span>
                    <a class="ma-accident__value" href="tel:+4312533798">+43/1/253 3798</a>
                </div>

                <div class="ma-accident__contactLine">
                    <span class="ma-accident__label">Email</span>
                    <a class="ma-accident__value" href="mailto:aws@alpenverein.at">aws@alpenverein.at</a>
                </div>

                <div class="ma-accident__micro">
                    Transport mora biti organizovan preko Europ Assistance. U suprotnom, maksimalno će biti refundirano 750 EUR.
                </div>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="ma-card ma-accident__card mt-15">
                <div class="ma-card__title ma-accident__title">KORAK 3 — PRIJAVA ŠTETE I IZVEŠTAJ</div>

                <p class="ma-p ma-accident__p">
                Podnesi prijavu putem zvaničnog online formulara.
                </p>

                <div class="ma-accident__online" id="maAccidentOnlineNote" role="note">
                <span class="ma-accident__onlineDot" aria-hidden="true"></span>
                <span id="maAccidentOnlineText">Online status: Provera…</span>
                </div>

                <div class="ma-accident__actions">
                <a
                    class="vs-btn style7 ma-accident__btn ma-accident__btn--wide"
                    href="https://alpenverein.sichermitknox.com/schadenmelden"
                    target="_blank"
                    rel="noopener"
                    id="btnReportEmergency"
                >
                    PRIJAVI HITAN SLUČAJ
                </a>
                </div>

                <div class="ma-accident__offline" id="maAccidentOfflineMsg" hidden>
                Ovaj formular zahteva internet. Pošalji čim budeš imao/la signal.
                </div>

                <div class="ma-accident__divider"></div>

                <div class="ma-accident__details">
                <div class="ma-accident__detailsTitle">Šta raditi u slučaju nezgode?</div>

                <p class="ma-accident__detailsP">
                    Ako je potrebno spasavanje iz nepristupačnog terena, uvek pozovi hitnu liniju lokalne gorske službe spašavanja ili drugi
                    hitni broj u zemlji/regionu. U Evropi je to najčešće <a class="ma-link" href="tel:112">112</a>.
                    <button type="button" class="ma-accident__inlineJump" data-jump="sos">Otvori SOS</button>
                    da pronađeš tačan lokalni broj.
                </p>

                <p class="ma-accident__detailsP">
                    U životno ugrožavajućim situacijama, odmah pozovi pomoć kako bi spasilački tim stigao što brže i efikasnije.
                </p>

                <p class="ma-accident__detailsP">
                    Ako si već bezbedan/na, stabilizovan/a u bolnici i potreban ti je transport do druge bolnice (najbliže mestu stalnog prebivališta),
                    ili do mesta stalnog prebivališta, to mora biti organizovano preko ugovorenog asistenta navedenog na tvojoj Alpenverein
                    članskoj kartici: <strong>Europ Assistance</strong> —
                    <a class="ma-link" href="tel:+4312533798">+43/1/253 3798</a>,
                    <a class="ma-link" href="mailto:aws@alpenverein.at">aws@alpenverein.at</a>.
                    U suprotnom, maksimalno će ti biti refundirano <strong>750 EUR</strong> za ovaj transport.
                </p>
                </div>
            </div>

            <!-- Fixed bottom banner (same markup as other tabs) -->
            <div class="ma-bottom-banner mt-25" role="note">
                <div class="ma-bottom-banner__inner">
                <div class="ma-bottom-banner__text">
                    <div class="ma-bottom-banner__title">
                    Pre repatrijacije ili transporta, moraš kontaktirati Europ Assistance, u suprotnom će maksimalno biti refundirano 750 EUR.
                    </div>
                    <div class="ma-bottom-banner__meta">
                    <span class="ma-bottom-banner__brand">Europ Assistance</span>
                    <a class="ma-bottom-banner__phone" href="tel:+4312533798">+43/1/253 3798</a>
                    </div>
                </div>

                <center><a
                    class="vs-btn style7 ma-bottom-banner__btn"
                    href="https://alpenverein.sichermitknox.com/schadenmelden"
                    target="_blank"
                    rel="noopener"
                >
                    PRIJAVI HITAN SLUČAJ
                </a></center>
                </div>
            </div>
            </div>


            
            <!-- HELPLINE PANEL (TAB 4) -->
            <div class="ma-section ma-helpline" data-section="helpline" hidden>
            <h4 class="ma-h4 ma-helpline__h1">Helpline</h4>

            <!-- Activation card -->
            <div class="ma-card">
                <div class="ma-helpline__top">
                <div>
                    <div class="ma-card__title ma-helpline__title">POTREBNA AKTIVACIJA</div>
                    <p class="ma-p ma-helpline__sub">
                    Aktiviraj Helpline pre odlaska u prirodu. Tvoji kontakti za hitne slučajeve mogu koristiti ovu liniju da dobiju informacije o tebi ako se nešto desi.
                    </p>
                </div>

                <div class="ma-helpline__pill" aria-label="Activation status">
                    <span class="ma-helpline__pillDot" aria-hidden="true"></span>
                    Nije keširano
                </div>
                </div>

                <div class="ma-helpline__actions">
                <a
                    class="vs-btn style7 ma-helpline__btn ma-helpline__btn--primary"
                    href="https://alpenverein.sichermitknox.com/helpline-login"
                    target="_blank"
                    rel="noopener"
                    id="btnActivateHelpline"
                >
                    AKTIVIRAJ HELPLINE
                </a>

                <a
                    class="vs-btn style7 ma-helpline__btn ma-helpline__btn--call"
                    href="tel:+430501015"
                    id="btnHelplineOffline"
                >
                    HELPLINE (OFFLINE POZIV): +43 (0) 50 10 15
                </a>
                </div>

                <div class="ma-note mt-15" role="note">
                <strong>Preporuka:</strong> preporučujemo da aktiviraš Helpline pre svakog puta.
                <br />
                <span style="opacity:.9;">
                    Više informacija i video:
                    <a
                    class="ma-helpline__link"
                    href="https://alpenverein.sichermitknox.com/service"
                    target="_blank"
                    rel="noopener"
                    >
                    Otvori HelpLine stranicu
                    </a>
                </span>
                </div>
            </div>

            <!-- Explanation card -->
            <div class="ma-card mt-15">
                <div class="ma-card__title">Helpline: Informacije kada su najvažnije</div>
                <div class="ma-helpline__explain ma-p">
                <p class="ma-p" style="margin-bottom:10px;">
                    “Ako se nešto desi, neću saznati.”
                </p>
                <p class="ma-p" style="margin-bottom:0;">
                    Ni bolnice ni policija ne smeju da daju informacije, a pacijenti često nisu u mogućnosti da to urade.
                    Tada počinje teško snalaženje kroz poverljivost i zaštitu podataka.
                    HelpLine rasterećuje tvoje kontakte za hitne slučajeve te neizvesnosti i reguliše njihovo pravo na informacije.
                </p>
                </div>
            </div>

            <!-- Extra tip card (bottom part requested) -->
            <div class="ma-card mt-15">
                <div class="ma-card__title">SAVET ZA BATERIJU (VISINA I HLADNOĆA)</div>
                <div class="ma-helpline__tip">
                <div class="ma-helpline__tipTitle">Sačuvaj energiju za poziv koji je bitan</div>
                <p class="ma-helpline__tipText">
                    Na većim visinama i po hladnom vremenu telefoni troše bateriju mnogo brže.
                    Kombinacija hladnog vetra, slabog signala i zahtevnog terena može isprazniti bateriju i nekoliko puta brže nego u gradu.
                    Drži telefon u unutrašnjem džepu uz telo, isključi funkcije koje ti ne trebaju i štedi energiju da bi mogao/la da pozoveš pomoć ako zatreba.
                </p>
                </div>
            </div>

            <!-- FIXED BOTTOM BANNER (same markup you already use on other tabs) -->
            <div class="ma-bottom-banner mt-25" role="note">
                <div class="ma-bottom-banner__inner">
                <div class="ma-bottom-banner__text">
                    <div class="ma-bottom-banner__title">
                    Pre repatrijacije ili transporta, moraš kontaktirati Europ Assistance, u suprotnom će maksimalno biti refundirano 750 EUR.
                    </div>
                    <div class="ma-bottom-banner__meta">
                    <span class="ma-bottom-banner__brand">Europ Assistance</span>
                    <a class="ma-bottom-banner__phone" href="tel:+4312533798">+43/1/253 3798</a>
                    </div>
                </div>

                <center><a
                    class="vs-btn style7 ma-bottom-banner__btn"
                    href="https://alpenverein.sichermitknox.com/schadenmelden"
                    target="_blank"
                    rel="noopener"
                >
                    PRIJAVI HITAN SLUČAJ
                </a></center>
                </div>
            </div>
            </div>

            </div>

            <!-- Panel bottom navigation -->
            <div class="ma-panel__footer">
            <button type="button" class="vs-btn style7" id="maPrev">NAZAD</button>
            <button type="button" class="vs-btn style7" id="maNext">DALJE</button>
            </div>
        </div>

        <!-- IV) GET READY FOR THE TOUR -->
        <div class="ma-prep mt-25">
        <div class="ma-prep__title">PRIPREMI SE ZA TURU</div>
        <div class="ma-prep__text">
            Pre nego što kreneš u planine ili na zahtevniji teren, uradi sledeće:
        </div>

        <ul class="ma-prep__list">
            <li>Sačuvaj offline sve dokumente i kartice u BERG-u kako bi bili dostupni i bez interneta</li>
            <li>Napuni telefon na 100% i ponesi pun power bank</li>
            <li>Uključi režim štednje baterije pre nego što kreneš</li>
            <li>Obavesti kontakte za hitne slučajeve gde ideš, s kim ideš, koliko ostaješ i kada planiraš povratak</li>
            <li>Uključi avion režim kada nemaš mrežu ili ti ne treba mobilni internet — telefon tada troši mnogo manje</li>
            <li>Isključi mobilne podatke, Wi-Fi, Bluetooth i zatvori pozadinske aplikacije koje ti nisu hitno potrebne</li>
            <li>Po hladnoći drži telefon u unutrašnjem džepu uz telo — niske temperature drastično smanjuju trajanje baterije</li>
            <li>Ako si u grupi, dogovorite se da jedan telefon ostane uključen, a drugi bude rezerva za hitne slučajeve</li>
            <li>Izbegavaj stalno GPS praćenje, navigaciju i slanje foto/video sadržaja — to ekstremno troši bateriju i signal</li>
        </ul>

        <div class="ma-prep__note">
            <strong>Napomena:</strong><br />
            “Nekoliko minuta pripreme pre polaska može biti presudno za tvoju bezbednost u planini.”
        </div>
        </div>

        <!-- V Rotating tips (Home / My Profile style) -->
        <div class="ma-tips mt-20" aria-label="Rotating safety tips">
        <div class="ma-tips__head">
            <div class="ma-tips__label">BRZI SAVETI ZA BEZBEDNOST</div>

            <div class="ma-tips__nav" aria-label="Carousel controls">
            <button type="button" class="ma-tips__arrow" id="maTipsPrev" aria-label="Prethodni saveti">
                ‹
            </button>
            <button type="button" class="ma-tips__arrow" id="maTipsNext" aria-label="Sledeći saveti">
                ›
            </button>
            </div>
        </div>

        <div class="ma-tips__viewport" id="maTipsViewport" tabindex="0" aria-roledescription="carousel">
            <div class="ma-tips__track" id="maTipsTrack">
            <article class="ma-tip-card" aria-label="Savet 1">
                <div class="ma-tip-card__inner">
                <div class="ma-tip-card__title">Hladnoća i visina brže troše bateriju</div>
                <div class="ma-tip-card__text">
                    Telefon troši bateriju mnogo brže po hladnom vremenu i na većoj nadmorskoj visini.
                    Drži ga u unutrašnjem džepu i uključi štednju baterije čim kreneš.
                </div>
                </div>
            </article>

            <article class="ma-tip-card" aria-label="Savet 2">
                <div class="ma-tip-card__inner">
                <div class="ma-tip-card__title">Nema signala = veća potrošnja</div>
                <div class="ma-tip-card__text">
                    U planini telefon stalno traži signal i može trošiti bateriju višestruko brže nego u gradu.
                    Kada nema pokrivenosti, uključi avion režim i sačuvaj energiju za hitne slučajeve.
                </div>
                </div>
            </article>

            <article class="ma-tip-card" aria-label="Savet 3">
                <div class="ma-tip-card__inner">
                <div class="ma-tip-card__title">Sačuvaj BERG offline pre polaska</div>
                <div class="ma-tip-card__text">
                    Sačuvaj offline sve BERG dokumente i kartice pre nego što kreneš.
                    Ne oslanjaj se na to da ćeš imati internet kada ti bude najpotrebniji.
                </div>
                </div>
            </article>

            <article class="ma-tip-card" aria-label="Savet 4">
                <div class="ma-tip-card__inner">
                <div class="ma-tip-card__title">Sačuvaj bateriju za poziv spasiocima</div>
                <div class="ma-tip-card__text">
                    Sačuvaj bateriju za poziv u pomoć.
                    Izbegavaj GPS praćenje uživo i objavljivanje foto/video sadržaja dok si u planini.
                </div>
                </div>
            </article>
            </div>
        </div>

        <div class="ma-tips__dots" id="maTipsDots" aria-label="Paginacija saveta"></div>
        </div>



        </div>
    </div>
    </section>

    <!-- I) REQUIRED POPUP ON PAGE OPEN -->
    <div class="ma-pop" id="maOfflinePopup" hidden>
    <div class="ma-pop__backdrop" data-pop-close></div>

    <div class="ma-pop__dialog" role="dialog" aria-modal="true" aria-labelledby="maPopTitle">
        <button type="button" class="ma-pop__close" data-pop-close aria-label="Zatvori">×</button>

        <div class="ma-pop__title" id="maPopTitle">Sačuvaj dokumente za offline korišćenje</div>

        <ul class="ma-pop__list">
        <li>Preuzmi hitne PDF dokumente</li>
        <li>Sačuvaj ID kartice za offline pregled</li>
        <li>Dodaj aplikaciju na početni ekran</li>
        </ul>

        <div class="ma-pop__note">
        “BERG Emergency Mode radi i bez interneta.<br />
        Pre nego što kreneš napolje, obavezno sačuvaj podatke offline.”
        </div>
        
        
        <!-- IOS -->
        
        <div class="ma-pop__note" id="maPopHelp"></div>

        <!-- IOS -->

        <div class="ma-pop__actions">
        <button type="button" class="vs-btn style7 w-100" id="maPopInstall" style="display:none;">DODAJ NA POČETNI EKRAN</button>
        <button type="button" class="vs-btn style7 w-100" id="maPopCacheNow">Sačuvaj offline</button>
        <div class="ma-pop__disclaimer" id="maPopStatus">Proces traje 10–20 sekundi.</div>
        </div>

    </div>
    </div>



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
    
    <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>

    
    <script>
(() => {
  const pop = document.getElementById("maOfflinePopup");
  const helpEl = document.getElementById("maPopHelp");
  const statusEl = document.getElementById("maPopStatus");
  const installBtn = document.getElementById("maPopInstall");
  const cacheBtn = document.getElementById("maPopCacheNow");

  if (pop && pop.parentElement !== document.body) document.body.appendChild(pop);

  const ua = navigator.userAgent || "";
  const isIOS = /iPad|iPhone|iPod/.test(ua) && !window.MSStream;
  const isStandalone =
    window.matchMedia("(display-mode: standalone)").matches ||
    window.navigator.standalone === true;

  let deferredPrompt = null;

  window.addEventListener("beforeinstallprompt", (e) => {
    e.preventDefault();
    deferredPrompt = e;
    renderHelp();
  });

  function renderHelp() {
    if (isStandalone) {
      helpEl.innerHTML = 'Ikonica je već instalirana na početnom ekranu.<br>Sada jednom dodirni <b>Sačuvaj offline</b> dok si online.';
      installBtn.style.display = "none";
      return;
    }
    if (isIOS) {
      helpEl.innerHTML =
        'iPhone/iPad (Safari):<br>' +
        '1) Otvori u <b>Safari</b><br>' +
        '2) Dodirni <b>Share</b><br>' +
        '3) Dodirni <b>Add to Home Screen</b><br>' +
        '<br>Zatim jednom dodirni <b>Sačuvaj offline</b> dok si online.';
      installBtn.style.display = "none";
      return;
    }
    if (deferredPrompt) {
      helpEl.innerHTML =
        'Android: Dodirni <b>DODAJ NA POČETNI EKRAN</b>.<br>' +
        'Posle instalacije, jednom dodirni <b>Sačuvaj offline</b> dok si online.';
      installBtn.style.display = "inline-flex";
      return;
    }
    helpEl.innerHTML =
      'Ručna instalacija:<br>' +
      'Android (Chrome): Meni (⋮) → <b>Install app</b> / <b>Add to Home screen</b><br>' +
      'iOS: Safari → Share → <b>Add to Home Screen</b><br>' +
      '<br>Zatim jednom dodirni <b>Sačuvaj offline</b> dok si online.';
    installBtn.style.display = "none";
  }

  renderHelp();

  installBtn?.addEventListener("click", async () => {
    if (!deferredPrompt) return;
    deferredPrompt.prompt();
    const res = await deferredPrompt.userChoice;
    deferredPrompt = null;
    if (res && res.outcome === "accepted") {
      statusEl.textContent = "Instalirano. Sada dodirni „Sačuvaj offline“ da preuzmeš podatke za offline.";
      installBtn.style.display = "none";
    }
  });

  function withTimeout(promise, ms) {
    return Promise.race([
      promise,
      new Promise((_, rej) => setTimeout(() => rej(new Error("timeout")), ms))
    ]);
  }

  async function waitForActivated(reg, ms = 8000) {
    if (reg.active && reg.active.state === "activated") return;

    const sw = reg.installing || reg.waiting || reg.active;
    if (!sw) throw new Error("no-sw");

    await withTimeout(new Promise((resolve) => {
      const onState = () => {
        if (reg.active && reg.active.state === "activated") {
          sw.removeEventListener("statechange", onState);
          resolve();
        }
      };
      sw.addEventListener("statechange", onState);
      onState();
    }), ms);
  }

  async function ensureSW() {
    if (!("serviceWorker" in navigator)) throw new Error("no-sw-support");

    const reg = await navigator.serviceWorker.register("/sw-emergency.js", { scope: "/" });
    await waitForActivated(reg, 8000);

    // Sačekaj da stranica dobije kontrolu (controller), ali ne zauvek
    if (!navigator.serviceWorker.controller) {
      await withTimeout(new Promise((resolve) => {
        navigator.serviceWorker.addEventListener("controllerchange", () => resolve(), { once: true });
      }), 3000).catch(() => {});
    }

    return reg;
  }

  function collectOfflineUrls() {
    const urls = new Set();

    // obavezno
    urls.add("/emergency/profile.php");
    urls.add("/emergency/profile.php?source=a2hs");
    urls.add("/emergency/offline.html");
    urls.add("/manifest-emergency.webmanifest");
    urls.add("/assets/img/pwa/berg-emergency-192.png");
    urls.add("/assets/img/pwa/berg-emergency-512.png");
    urls.add("/assets/img/pwa/apple-touch-icon.png");

    // CSS + JS
    document.querySelectorAll('link[rel="stylesheet"][href]').forEach(el => urls.add(el.getAttribute("href")));
    document.querySelectorAll('script[src]').forEach(el => urls.add(el.getAttribute("src")));

    // slike
    document.querySelectorAll('img[src]').forEach(el => urls.add(el.getAttribute("src")));

    // data-bg-src (tvoj template ga koristi)
    document.querySelectorAll('[data-bg-src]').forEach(el => urls.add(el.getAttribute("data-bg-src")));

    // PDF linkovi iz docs taba (data atributi)
    const docs = document.querySelector('.ma-docs[data-av-url][data-brochure-url]');
    if (docs) {
      urls.add(docs.getAttribute("data-av-url"));
      urls.add(docs.getAttribute("data-brochure-url"));
    }

    // normalizuj na same-origin absolute path
    const out = [];
    for (const u of urls) {
      if (!u) continue;
      try {
        const abs = new URL(u, location.origin);
        if (abs.origin !== location.origin) continue;
        abs.hash = "";
        out.push(abs.pathname + abs.search);
      } catch (_) {}
    }
    return Array.from(new Set(out));
  }

  cacheBtn?.addEventListener("click", async () => {
    statusEl.textContent = "Keširanje… ostavi ovu stranicu otvorenom (10–20s).";

    try {
      await ensureSW();

      const urls = collectOfflineUrls();

      const onMsg = (e) => {
        if (e.data && e.data.type === "CACHE_DONE") {
          const ok = e.data.okCount ?? 0;
          const fail = e.data.failCount ?? 0;
          statusEl.textContent = `Gotovo ✅ Sačuvano: ${ok}, neuspešno: ${fail}. Test: uključi Airplane Mode + otvori ikonicu.`;
          navigator.serviceWorker.removeEventListener("message", onMsg);
        }
      };
      navigator.serviceWorker.addEventListener("message", onMsg);

      const sw = navigator.serviceWorker.controller || (await navigator.serviceWorker.getRegistration())?.active;
      if (!sw) {
        statusEl.textContent = "Service Worker još ne kontroliše ovu stranicu. Osveži jednom i probaj ponovo.";
        return;
      }

      sw.postMessage({ type: "CACHE_NOW", urls });

    } catch (err) {
      console.warn(err);
      statusEl.textContent = "Service Worker nije uspeo. Ovo radi samo na HTTPS (ili localhost). Proveri i da nema 404 fajlova u DevTools.";
    }
  });
})();



//Cached
(() => {
  const cacheNowBtn = document.getElementById("maPopCacheNow"); // "Cache Now" u popup-u
  const pill = document.getElementById("maCachePill");         // pill u SOS listi
  const dot = pill?.querySelector(".ma-sos__dot");
  const text = document.getElementById("maCacheText");         // "Not cached" tekst

  if (!cacheNowBtn || !pill || !dot || !text) return;

  const LS_KEY = "berg_cache_sos_list";

  function setCachedUI() {
    dot.style.backgroundColor = "#22c55e"; // zeleno
    dot.style.borderColor = "#22c55e";
    text.textContent = "Keširano";
    try { localStorage.setItem(LS_KEY, "1"); } catch (_) {}
  }

  // Ako je ranije već keširano (da ostane zeleno posle refresh-a)
  try {
    if (localStorage.getItem(LS_KEY) === "1") setCachedUI();
  } catch (_) {}

  // Kad korisnik klikne "Cache Now" (može i odmah, ali ne moraš)
  cacheNowBtn.addEventListener("click", () => {
    // Ako želiš da se promeni tek kad se završi, obriši sledeću liniju:
    // setCachedUI();
  });

  // Kad service worker javi da je keširanje završeno (tvoj existing message: CACHE_DONE)
  if ("serviceWorker" in navigator) {
    navigator.serviceWorker.addEventListener("message", (e) => {
      if (e?.data?.type === "CACHE_DONE") setCachedUI();
    });
  }
})();



(() => {
  const btn = document.getElementById("btnPrintEmergencyId");
  if (!btn) return;

  function val(name) {
    const el = document.querySelector(`[name="${name}"]`);
    return (el && typeof el.value === "string" && el.value.trim()) ? el.value.trim() : "—";
  }

  function textFrom(selector) {
    const el = document.querySelector(selector);
    return el ? (el.textContent || "").trim() : "";
  }

  btn.addEventListener("click", () => {
    const jspdf = window.jspdf;
    if (!jspdf || !jspdf.jsPDF) {
      alert("Generator PDF-a nije učitan (jsPDF). Proveri da li je jsPDF <script> tag uključen.");
      return;
    }

    const { jsPDF } = jspdf;
    const doc = new jsPDF({ unit: "pt", format: "a4" });

    // Podaci sa strane (iz tvog markup-a + input-a)
    const fullName = textFrom("#maEmergencyIdCard .ma-idcard__name") || "Član";
    const emId = (textFrom("#maEmergencyIdCard .ma-idcard__meta") || "").replace("Emergency ID •", "").trim();

    const rows = [
      ["Krvna grupa", val("blood_group")],
      ["Alergije", val("allergies")],
      ["Hronična stanja", val("chronic_conditions")],
      ["Terapija / lekovi", val("medications")],
      ["Prethodne operacije / povrede", val("previous_surgeries")],
      ["Adresa", val("address")],
      ["Kontakt za hitne slučajeve 1", val("emergency_contact1")],
      ["Kontakt za hitne slučajeve 2", val("emergency_contact2")]
    ];

    // Layout
    const pageW = doc.internal.pageSize.getWidth();
    const left = 48;
    let y = 60;

    doc.setFont("helvetica", "bold");
    doc.setFontSize(16);
    doc.text("EMERGENCY ID", left, y);
    y += 18;

    doc.setDrawColor(180);
    doc.line(left, y, pageW - left, y);
    y += 22;

    doc.setFont("helvetica", "bold");
    doc.setFontSize(14);
    doc.text(fullName, left, y);
    y += 16;

    doc.setFont("helvetica", "normal");
    doc.setFontSize(11);
    doc.text(`Emergency ID: ${emId || "—"}`, left, y);
    y += 22;

    doc.setDrawColor(220);
    doc.line(left, y, pageW - left, y);
    y += 18;

    // “Tabela”
    const labelX = left;
    const valueX = 280;
    const maxValueWidth = pageW - left - valueX;

    doc.setFontSize(11);

    for (const [label, value] of rows) {
      doc.setFont("helvetica", "normal");
      doc.text(label, labelX, y);

      doc.setFont("helvetica", "bold");
      const lines = doc.splitTextToSize(String(value), maxValueWidth);
      doc.text(lines, valueX, y);

      // visina reda (u zavisnosti od wrap-a)
      y += Math.max(18, lines.length * 14);

      // separator linija
      doc.setDrawColor(235);
      doc.line(left, y - 10, pageW - left, y - 10);

      // ako se približi dnu, nova strana
      if (y > 760) {
        doc.addPage();
        y = 60;
      }
    }

    // Footer
    doc.setFont("helvetica", "normal");
    doc.setFontSize(9);
    doc.setTextColor(120);
    doc.text("Generisano iz BERG Membership Emergency profila", left, 820);

    // filename
    const safeId = (emId || "emergency-id").replace(/[^\w\-#]+/g, "_");
    doc.save(`${safeId}.pdf`);
  });
})();


(() => {
  const btn = document.getElementById("btnShowAlpenvereinCard");
  if (!btn) return;

  btn.addEventListener("click", () => {
    window.location.href = "download_alpenverein_card.php";
  });
})();

</script>


    
    
    
  </body>
</html>
