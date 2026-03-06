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
    <title>BERG Membership Program - Insurance</title>

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
        data-bg-src="./assets/img/berg-membership-courses.png"
      >
        <div class="container">
          <div class="row text-center">
            <div class="col-12">
              <div class="breadcrumb-content">
                <h1 class="breadcrumb-title">Insurance</h1>
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

      <!--================= Scope of coverage (Segments / Template) =================-->
      <section class="insurance-scope space" style="background-color:#fdf8f5" id="insurance-scope">
        <div class="container">

          <!-- Title -->
          <div class="row">
            <div class="col-12">
              <div class="text-center">
                <span class="sec-subtitle text-capitalize fade-anim" data-direction="top">BERG Membership</span>
                <h2 class="sec-title fade-anim" data-direction="bottom">Scope of coverage</h2>
              </div>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-12">
              <div class="ic-layout ic-layout--scope" data-ic-root data-ic-default="intro">

                <!-- SIDEBAR -->
                <aside class="ic-sidebar" aria-label="Navigation - Scope of coverage">
                  <div class="ic-nav" role="tablist" aria-orientation="vertical">

                    <button type="button"
                      class="ic-nav-item is-active"
                      id="ic-scope-tab-intro"
                      role="tab"
                      aria-selected="true"
                      aria-controls="ic-scope-panel-intro"
                      data-ic-tab="intro"
                      data-ic-hash="intro"
                    >
                      <span class="ic-step">1</span>
                      <span class="ic-label">Introduction to insurance</span>
                    </button>

                    <button type="button"
                      class="ic-nav-item"
                      id="ic-scope-tab-rescue"
                      role="tab"
                      aria-selected="false"
                      aria-controls="ic-scope-panel-rescue"
                      data-ic-tab="rescue"
                      data-ic-hash="rescue"
                    >
                      <span class="ic-step">2</span>
                      <span class="ic-label">Rescue / search operation (helicopter)</span>
                    </button>

                    <button type="button"
                      class="ic-nav-item"
                      id="ic-scope-tab-hospital"
                      role="tab"
                      aria-selected="false"
                      aria-controls="ic-scope-panel-hospital"
                      data-ic-tab="hospital"
                      data-ic-hash="hospital"
                    >
                      <span class="ic-step">3</span>
                      <span class="ic-label">Hospital stay abroad</span>
                    </button>

                    <button type="button"
                      class="ic-nav-item"
                      id="ic-scope-tab-transport"
                      role="tab"
                      aria-selected="false"
                      aria-controls="ic-scope-panel-transport"
                      data-ic-tab="transport"
                      data-ic-hash="transport"
                    >
                      <span class="ic-step">4</span>
                      <span class="ic-label">Transport of an injured person from abroad</span>
                    </button>

                    <button type="button"
                      class="ic-nav-item"
                      id="ic-scope-tab-liability"
                      role="tab"
                      aria-selected="false"
                      aria-controls="ic-scope-panel-liability"
                      data-ic-tab="liability"
                      data-ic-hash="liability"
                    >
                      <span class="ic-step">5</span>
                      <span class="ic-label">European third-party liability</span>
                    </button>

                    <button type="button"
                      class="ic-nav-item"
                      id="ic-scope-tab-legal"
                      role="tab"
                      aria-selected="false"
                      aria-controls="ic-scope-panel-legal"
                      data-ic-tab="legal"
                      data-ic-hash="legal"
                    >
                      <span class="ic-step">6</span>
                      <span class="ic-label">Legal protection (criminal law)</span>
                    </button>

                  </div>
                </aside>

                <!-- CONTENT -->
                <div class="ic-content">

                  <!-- PANEL 1 -->
                  <section class="ic-panel is-active"
                    id="ic-scope-panel-intro"
                    role="tabpanel"
                    aria-labelledby="ic-scope-tab-intro"
                    tabindex="0"
                    data-ic-panel="intro"
                  >
                    <div class="ic-breadcrumb">
                      Insurance overview <span class="ic-sep">›</span> Terms and documentation <span class="ic-sep">›</span> Scope of coverage
                    </div>

                    <h3 class="ic-title">INTRODUCTION TO INSURANCE</h3>

                    <div class="ic-body">
                      <p>
                        <strong>The Alpenverein Weltweit Service (AWS)</strong> provides insurance cover for all members of
                        Österreichischer Alpenverein <strong>for rescues in the event of any accidents during leisure activities</strong>.
                        <br>
                        Protection abroad for services relating to repatriation and medical treatment <strong>covers leisure and occupational accidents as well as illness</strong>.
                        <br>
                        Alpenverein Weltweit Service is valid <strong>worldwide</strong>, with the exception of third party liability and criminal law insurance,
                        which are restricted to <strong>Europe</strong>. The insurer for the Alpenverein Weltweit Service is Generali Versicherung AG.
                      </p>
                    </div>

                  </section>

                  <!-- PANEL 2 -->
                  <section class="ic-panel"
                    id="ic-scope-panel-rescue"
                    role="tabpanel"
                    aria-labelledby="ic-scope-tab-rescue"
                    tabindex="0"
                    data-ic-panel="rescue"
                    hidden
                  >
                    <div class="ic-breadcrumb">
                      Insurance overview <span class="ic-sep">›</span> Terms and documentation <span class="ic-sep">›</span> Scope of coverage
                    </div>

                    <h3 class="ic-title">RESCUE / SEARCH OPERATION (HELICOPTER)</h3>

                    <div class="ic-body">
                      <h4 class="mb-3">
                        Costs for rescue from off-road terrain domestically or abroad up to EUR 25,000 per person and insured event
                      </h4>

                      <h5 class="mb-2">Content</h5>
                      <ol class="mb-4">
                        <li>Costs for transport and transfer within one’s country of main place of residence</li>
                        <li>Exclusions relating to rescue costs</li>
                      </ol>

                      <p class="mb-3">
                        Year-round, worldwide, during leisure time; Rescue costs are those costs incurred by local rescue organisations
                        (including the costs of rescue organisations from the neighbouring country in the event of incidents near borders),
                        which are necessary if the insured party has an emergency/accident or must be rescued from mountain or aquatic distress
                        or from off-road terrain, either injured or uninjured (the same applies accordingly in the event of death).
                        Rescue costs are verified costs of searching for an insured party and his or her transport from off-road terrain
                      </p>

                      <p class="mb-4">
                        a) to the next accessible road or<br>
                        b) to the hospital closest to the site of the accident.
                      </p>

                      <h4 class="mt-4 mb-3">Costs for transport and transfer within one’s country of main place of residence</h4>
                      <p class="mb-3">
                        After a rescue covered by insurance, the costs of transfers of injured/ill persons and transfer costs for deceased persons
                        within the same country as the insured party’s main place of residence shall be covered without limitation on costs.
                        Transfer costs are costs of transport from one hospital to a hospital near the main place of residence or to the main place
                        of residence itself.
                      </p>

                      <p class="mb-3">
                        Transport costs are the costs of transporting a deceased party to his or her last main place of residence. Transport must be
                        organised by the contract organisation stated on the Alpenverein membership card. If this is not the case, max. EUR 750 shall
                        be compensated:
                      </p>

                      <p class="mb-4">
                        <strong>Europ Assistance,</strong> tel: +43/1/253 3798, fax +43/1/313 89 1304, email: aws@alpenverein.at
                      </p>

                      <h4 class="mt-4 mb-3">Exclusions relating to rescue costs</h4>

                      <p class="mb-2"><strong>The insurance protection does not extend to:</strong></p>

                      <ul class="mb-4">
                        <li>
                          Accidents/illnesses as part of work-related or other professional activities and accidents by members ofrescue organisations,
                          which occur as part of organised rescue deployments and training on behalf ofthe rescue organisation. However, accidents during
                          paid work by members of the Österreichischer Bergführer Verband as qualified mountain and ski guides, and as officially approved
                          and qualified hiking guides are insured.
                        </li>
                        <li>
                          Accidents when using motor vehicles, however motor vehicle accidents directly and indirectly on the way to and from meetings and
                          events of the Österreichische Alpenverein and on the way to and from statutory (including private) association activities (hikes,
                          snowshoe hikes, mountaineering, climbing, via ferrata, skiing, ski touring, cross-country skiing, snowboarding, white water canoeing,
                          canyoning and mountain biking/trekking tours as well as when using cable cars and lifts) are insured.
                        </li>
                        <li>
                          Accidents during participation in provincial, national or international competitions in Nordic and Alpine skiing, snowboarding and
                          freestyling, freeriding, bob, ski-bob, skeleton or luge and when training for such events;
                        </li>
                        <li>
                          Accidents involving insured persons as pilots (including Sports pilots, Operators of aviated devices, such as e.g. paragliders),
                          where they require a permit for this under Austrian law, and as other crew members of aircraft and when using spacecraft or as a
                          drone passenger;
                        </li>
                        <li>Dives featuring exceptional risk (dives of 40 m or more, ice diving, diving expeditions);</li>
                        <li>
                          Participation in mountain bike competitions (downhill, four cross, dirt jump), including the official training and qualification runs;
                        </li>
                        <li>Record attempts relating to speed, diving and aeronautics;</li>
                        <li>
                          Accidents/illnesses on trips with planned ascents of mountains with summits over 6,000 m in height and travel to the Arctic
                          (destinations north of he Arctic Circle), Antarctic (destinations south of the Antarctic Circle) and Greenland. *
                        </li>
                        <li>
                          Participation in expeditions – an expedition is defined as a trip to rarely-visited areas lacking permanent infrastructure (e.g. huts)
                          that lasts for several days or weeks and is undertaken for exploration or research purposes to a certain extent.
                        </li>
                      </ul>

                      <p class="mb-2"><strong>Clarification:</strong></p>

                      <p class="mb-3">
                        In accordance with the exceptions stated above, all mountaineering activities and trips that are undertaken with the aim of climbing a
                        mountain featuring a summit height below 6,000 m and that do not visitthe stated Arctic or Antarctic regions or Greenland are nevertheless
                        insured even if these are designated as expeditions by an organiser. However, journeys with any kind of commercial background (professional
                        activity) are exclused from the insurance coverfor the participant. Trips featuring planned ascents of mountains with a summit height above
                        6,000 m or trips to the stated Arctic or Antarctic regions or Greenland are classed as expeditions.
                      </p>

                      <p class="mb-3">
                        <strong>For ascents of mountains with a summit height above 6,000 m, a separate insurance is offered.</strong>
                        Information and documentation, see: www.alpenverein.at/versicherung
                      </p>

                      <p class="mb-3">
                        The insurance protection also extends to accidents that occur when taking part in the activity of mountain climbing with exceptional risk
                        (climbing at difficulty level 5 UIAA and up, free solo ascents (unsecured climbing) and icefall climbing).
                      </p>

                      <p class="mb-0">
                        * Travel to all parts of the mainland of Finland, Norway and Sweden is insured, even if north of the Arctic Circle. “Mainland” means that
                        part of those countries that is reachable overland, including by use of bridges and/or tunnels.
                      </p>
                    </div>

                  </section>

                  <!-- PANEL 3 -->
                  <section class="ic-panel"
                    id="ic-scope-panel-hospital"
                    role="tabpanel"
                    aria-labelledby="ic-scope-tab-hospital"
                    tabindex="0"
                    data-ic-panel="hospital"
                    hidden
                  >
                    <div class="ic-breadcrumb">
                      Insurance overview <span class="ic-sep">›</span> Terms and documentation <span class="ic-sep">›</span> Scope of coverage
                    </div>

                    <h3 class="ic-title">HOSPITAL STAY ABROAD</h3>

                    <div class="ic-body">
                      <h4>Repatriation and medical treatment costs abroad</h4>
                      <p>Valid worldwide during the first eight weeks of any journey abroad, for leisure and occupational accidents as well as illness.</p>

                      <ul>
                        <li>Repatriation service from abroad: unlimited coverage</li>
                        <li>Medically necessary therapeutic treatment abroad (incl. medically necessary transport to the hospital): up to EUR 10,000.</li>
                      </ul>

                      <ol>
                        <li>
                          <p>
                            The full costs of a medically justified patient transport from abroad to a hospital in the country of the main place of residence of the injured/ill party, or to the main place of residence, including the costs of transporting a person close to the insured party to be transported. The following requirements apply for repatriation, in addition to the insured party’s medical condition allowing transport:
                          </p>
                          <ul>
                            <li>that there is a life-threatening medical condition or</li>
                            <li>the locally available medical care does not ensure treatment of a standard corresponding to that available in the part’s country of main place of residence</li>
                            <li>that in-patient treatment of more than five days is to be expected. Transport must be organized by the contract organisation stated on the Alpenverein membership card. If this is not the case, max. EUR 750 shall be compensated:</li>
                          </ul>
                          <p><strong>Europ Assistance</strong>, tel: +43/1/253 3798, fax +43/1/313 89 1304, email: aws@alpenverein.at</p>
                        </li>

                        <li>
                          <p>
                            The costs occured abroad for urgent medically necessary treatment including therapeutic products prescribed by a physician, medically necessary transport to the nearest suitable hospital to a total insured sum of EUR 10,000, of which EUR 2,000 shall be available for out-patient treatments including therapeutic products prescribed by a physician. For out-patient treatments including therapeutic products prescribed by physicians, a deduction of EUR 70 per person and stay abroad shall apply. It shall always be deducted from the insurance payout of Generali Versicherung AG, even if another compulsory or private insurance policy is also obliged to make payments. The insurer shall compensate the documented costs of medically necessary in-patient treatment.
                          </p>

                          <ul>
                            <li>In Austria: at the general tariff class in public hospitals;</li>
                            <li>Outside Austria: in public hospitals.</li>
                          </ul>

                          <p>
                            If the urgency of in-patient treatment renders presentation at a public hospital impossible, or if the insured party was unable to influence the choice of hospital, the insurer shall compensate the documented costs of medically necessary therapeutic treatment even in non-public hospitals. This obligation on the part of the insurer to pay shall cease when transport to a public hospital is medically reasonable.
                          </p>

                          <p>
                            The costs of medically necessary in-patient treatment per clause 2.2. shall only be billed directly to the insurer up to the insured sum if the e-card/EHIC card is presented in the hospital and is processed by Europ Assistance.
                          </p>

                          <p><strong>Otherwise, max. EUR 750 shall be compensated.</strong></p>

                          <p>
                            If you do not have an EHIC card, you must immediately contact Europ Assistance to ensure the assumption of costs for an in-patient stay in hospital.
                          </p>

                          <p><strong>Europ Assistance</strong>, tel: +43/1/253 3798, fax +43/1/313 89 1304, email: aws@alpenverein.at</p>

                          <p>
                            For information on the European Health Insurance Card<br>
                            (EHIC), see: <a href="http://ec.europa.eu/social" target="_blank" rel="noopener">http://ec.europa.eu/social</a>
                          </p>
                        </li>

                        <li>
                          <p>
                            The full costs for transferring a deceased person to their last main place of residence. Transport must be organised by the contract organisation stated on the Alpenverein membership card. If this is not the case, max. EUR 750 shall be compensated:
                          </p>
                          <p><strong>Europ Assistance</strong>, tel: +43/1/253 3798, fax +43/1/313 89 1304, email: aws@alpenverein.at</p>
                        </li>
                      </ol>

                      <p>For trips abroad longer than eight weeks, a separate insurance is offered. Information and documentation.</p>

                      <p><strong>Exclusions relating to repatriation and medical treatment:</strong></p>
                      <p>The insurance protection does not extend to:</p>

                      <ul>
                        <li>Therapeutic treatments which have already started before starting a journey abroad;</li>
                        <li>Therapeutic treatments of chronic illnesses, except as a consequence of acute attacks or flare-ups;</li>
                        <li>Therapeutic treatments that are the purpose of the stay abroad;</li>
                        <li>Dental treatments that do not serve as initial care for immediate pain relief;</li>
                        <li>Abortions, pregnancy examinations and births, except for premature deliveries occurring at least two months prior to the natural due date. This also applies accordingly for premature babies;</li>
                        <li>Therapeutic treatments due to excess consumption of alcohol, misuse of narcotics or misuse of medicines;</li>
                        <li>Cosmetic treatments, spa treatments and rehabilitation measures;</li>
                        <li>Preventive inoculations;</li>
                        <li>Therapeutic treatments of illnesses and consequences of accidents arising from war events of any kind and from active participation in disorder or deliberate criminal acts;</li>
                        <li>Therapeutic treatments of illnesses and consequences of accidents arising from active paid participation in publicly-held sports competitions and training for such events;</li>
                        <li>Therapeutic treatments of illnesses and consequences of accidents arising from active participation in state, national or international competitions in Nordic and Alpine skiing, snowboarding and freestyling, freeriding, bob, ski-bob, skeleton or luge and when training for such events, as well as illnesses and consequences of accidents arising from active paid participation in publicly-held sports competitions and training for such events (with the exception of climbing competitions as a member of the Austrian Climbing Association);</li>
                        <li>Therapeutic treatments of illnesses and consequences of accidents arising from participation in motor sports competitions (even classification races and rally races) and the corresponding training runs;</li>
                        <li>Therapeutic treatments of illnesses and accidentswhen using aeronautical equipment (for examplehang-gliders, paragliders), aircraft (privatemotorised aircraft and gliders) and sky diving. However, the use of motorised aircraft approved for passenger transport (e.g. commercial aircraft)as a passenger is insured – with the exception of power gliders and ultra-lights; passengers are defined as those who are not in a causal relationship with the operation of the aircraft, are not a crewmember and do not perform a professional activity using the aircraft;</li>
                        <li>Therapeutic treatments of illnesses and consequences of accidents arising from the harmful effects of nuclear energy;</li>
                        <li>Therapeutic treatments of illnesses and consequences of accidents by members of rescue organisations, which occur as part of organised rescue deployments and training on behalf of the rescue organisation.</li>
                        <li>Dives featuring exceptional risk (dives of 40 m or more, ice diving, diving expeditions);</li>
                        <li>Participation in mountain bike competitions (downhill, four cross, dirt jump), including the official training and qualification runs;</li>
                        <li>Record attempts relating to speed, diving and aeronautics;</li>
                        <li>Accidents/illnesses on trips with planned ascents of mountains with summits over 6,000 m in height and travel to the Arctic (destinations north of the Arctic Circle), Antarctic (destinations south of the Antarctic Circle) and Greenland.</li>
                        <li>Participation in expeditions – an expedition is defined as a trip to rarely-visited areas lacking permanent infrastructure (e.g. huts) that lasts for several days or weeks and is undertaken for exploration or research purposes to a certain extent.</li>
                      </ul>

                      <p><strong>Clarification:</strong></p>
                      <p>
                        In accordance with the exceptions stated above, all mountaineering activities and trips that are undertaken with the aim of climbing a mountain featuring a summit height below 6,000 m and that do not visit the stated Arctic or Antarctic regions or Greenland are nevertheless insured even if these are designated as expeditions by an organiser. Trips featuring planned ascents of mountains with a summit height above 6,000 m or trips to the stated Arctic or Antarctic regions or Greenland are classed as expeditions.
                      </p>

                      <p><strong>For ascents of mountains with a summit height above 6,000 m, a separate insurance is offered.</strong></p>

                      <p>
                        The insurance protection also extends to accidents that occur when taking part in the activity of mountain climbing with exceptional risk (climbing at difficulty level 5 UIAA and up, free solo ascents (unsecured climbing) and icefall climbing).
                      </p>

                      <p>
                        Please note: motor vehicle accidents abroad are generally insured as per clause 2, unless they occur during participation in motor sports competitions (even classification races and rally races) and the corre- sponding training runs.
                      </p>

                    </div>

                  </section>

                  <!-- PANEL 4 -->
                  <section class="ic-panel"
                    id="ic-scope-panel-transport"
                    role="tabpanel"
                    aria-labelledby="ic-scope-tab-transport"
                    tabindex="0"
                    data-ic-panel="transport"
                    hidden
                  >
                    <div class="ic-breadcrumb">
                      Insurance overview <span class="ic-sep">›</span> Terms and documentation <span class="ic-sep">›</span> Scope of coverage
                    </div>

                    <h3 class="ic-title">TRANSPORT OF AN INJURED PERSON FROM ABROAD</h3>

                    <div class="ic-body">
                      <h4>Repatriation and medical treatment costs abroad</h4>
                      <p>Valid worldwide during the first eight weeks of any journey abroad, for leisure and occupational accidents as well as illness.</p>

                      <ul>
                        <li>Repatriation service from abroad: unlimited coverage</li>
                        <li>Medically necessary therapeutic treatment abroad (incl. medically necessary transport to the hospital): up to EUR 10,000.</li>
                      </ul>

                      <ol>
                        <li>
                          <p>
                            The full costs of a medically justified patient transport from abroad to a hospital in the country of the main place of residence of the injured/ill party, or to the main place of residence, including the costs of transporting a person close to the insured party to be transported. The following requirements apply for repatriation, in addition to the insured party’s medical condition allowing transport:
                          </p>
                          <ul>
                            <li>that there is a life-threatening medical condition or</li>
                            <li>the locally available medical care does not ensure treatment of a standard corresponding to that available in the part’s country of main place of residence</li>
                            <li>that in-patient treatment of more than five days is to be expected. Transport must be organized by the contract organisation stated on the Alpenverein membership card. If this is not the case, max. EUR 750 shall be compensated:</li>
                          </ul>
                          <p><strong>Europ Assistance</strong>, tel: +43/1/253 3798, fax +43/1/313 89 1304, email: aws@alpenverein.at</p>
                        </li>

                        <li>
                          <p>
                            The costs occured abroad for urgent medically necessary treatment including therapeutic products prescribed by a physician, medically necessary transport to the nearest suitable hospital to a total insured sum of EUR 10,000, of which EUR 2,000 shall be available for out-patient treatments including therapeutic products prescribed by a physician. For out-patient treatments including therapeutic products prescribed by physicians, a deduction of EUR 70 per person and stay abroad shall apply. It shall always be deducted from the insurance payout of Generali Versicherung AG, even if another compulsory or private insurance policy is also obliged to make payments. The insurer shall compensate the documented costs of medically necessary in-patient treatment.
                          </p>

                          <ul>
                            <li>In Austria: at the general tariff class in public hospitals;</li>
                            <li>Outside Austria: in public hospitals.</li>
                          </ul>

                          <p>
                            If the urgency of in-patient treatment renders presentation at a public hospital impossible, or if the insured party was unable to influence the choice of hospital, the insurer shall compensate the documented costs of medically necessary therapeutic treatment even in non-public hospitals. This obligation on the part of the insurer to pay shall cease when transport to a public hospital is medically reasonable.
                          </p>

                          <p>
                            The costs of medically necessary in-patient treatment per clause 2.2. shall only be billed directly to the insurer up to the insured sum if the e-card/EHIC card is presented in the hospital and is processed by Europ Assistance.
                          </p>

                          <p><strong>Otherwise, max. EUR 750 shall be compensated.</strong></p>

                          <p>
                            If you do not have an EHIC card, you must immediately contact Europ Assistance to ensure the assumption of costs for an in-patient stay in hospital.
                          </p>

                          <p><strong>Europ Assistance</strong>, tel: +43/1/253 3798, fax +43/1/313 89 1304, email: aws@alpenverein.at</p>

                          <p>
                            For information on the European Health Insurance Card<br>
                            (EHIC), see: <a href="http://ec.europa.eu/social" target="_blank" rel="noopener">http://ec.europa.eu/social</a>
                          </p>
                        </li>

                        <li>
                          <p>
                            The full costs for transferring a deceased person to their last main place of residence. Transport must be organised by the contract organisation stated on the Alpenverein membership card. If this is not the case, max. EUR 750 shall be compensated:
                          </p>
                          <p><strong>Europ Assistance</strong>, tel: +43/1/253 3798, fax +43/1/313 89 1304, email: aws@alpenverein.at</p>
                        </li>
                      </ol>

                      <p>For trips abroad longer than eight weeks, a separate insurance is offered. Information and documentation.</p>

                      <p><strong>Exclusions relating to repatriation and medical treatment:</strong></p>
                      <p>The insurance protection does not extend to:</p>

                      <ul>
                        <li>Therapeutic treatments which have already started before starting a journey abroad;</li>
                        <li>Therapeutic treatments of chronic illnesses, except as a consequence of acute attacks or flare-ups;</li>
                        <li>Therapeutic treatments that are the purpose of the stay abroad;</li>
                        <li>Dental treatments that do not serve as initial care for immediate pain relief;</li>
                        <li>Abortions, pregnancy examinations and births, except for premature deliveries occurring at least two months prior to the natural due date. This also applies accordingly for premature babies;</li>
                        <li>Therapeutic treatments due to excess consumption of alcohol, misuse of narcotics or misuse of medicines;</li>
                        <li>Cosmetic treatments, spa treatments and rehabilitation measures;</li>
                        <li>Preventive inoculations;</li>
                        <li>Therapeutic treatments of illnesses and consequences of accidents arising from war events of any kind and from active participation in disorder or deliberate criminal acts;</li>
                        <li>Therapeutic treatments of illnesses and consequences of accidents arising from active paid participation in publicly-held sports competitions and training for such events;</li>
                        <li>Therapeutic treatments of illnesses and consequences of accidents arising from active participation in state, national or international competitions in Nordic and Alpine skiing, snowboarding and freestyling, freeriding, bob, ski-bob, skeleton or luge and when training for such events, as well as illnesses and consequences of accidents arising from active paid participation in publicly-held sports competitions and training for such events (with the exception of climbing competitions as a member of the Austrian Climbing Association);</li>
                        <li>Therapeutic treatments of illnesses and consequences of accidents arising from participation in motor sports competitions (even classification races and rally races) and the corresponding training runs;</li>
                        <li>Therapeutic treatments of illnesses and accidentswhen using aeronautical equipment (for examplehang-gliders, paragliders), aircraft (privatemotorised aircraft and gliders) and sky diving. However, the use of motorised aircraft approved for passenger transport (e.g. commercial aircraft)as a passenger is insured – with the exception of power gliders and ultra-lights; passengers are defined as those who are not in a causal relationship with the operation of the aircraft, are not a crewmember and do not perform a professional activity using the aircraft;</li>
                        <li>Therapeutic treatments of illnesses and consequences of accidents arising from the harmful effects of nuclear energy;</li>
                        <li>Therapeutic treatments of illnesses and consequences of accidents by members of rescue organisations, which occur as part of organised rescue deployments and training on behalf of the rescue organisation.</li>
                        <li>Dives featuring exceptional risk (dives of 40 m or more, ice diving, diving expeditions);</li>
                        <li>Participation in mountain bike competitions (downhill, four cross, dirt jump), including the official training and qualification runs;</li>
                        <li>Record attempts relating to speed, diving and aeronautics;</li>
                        <li>Accidents/illnesses on trips with planned ascents of mountains with summits over 6,000 m in height and travel to the Arctic (destinations north of the Arctic Circle), Antarctic (destinations south of the Antarctic Circle) and Greenland.</li>
                        <li>Participation in expeditions – an expedition is defined as a trip to rarely-visited areas lacking permanent infrastructure (e.g. huts) that lasts for several days or weeks and is undertaken for exploration or research purposes to a certain extent.</li>
                      </ul>

                      <p><strong>Clarification:</strong></p>
                      <p>
                        In accordance with the exceptions stated above, all mountaineering activities and trips that are undertaken with the aim of climbing a mountain featuring a summit height below 6,000 m and that do not visit the stated Arctic or Antarctic regions or Greenland are nevertheless insured even if these are designated as expeditions by an organiser. Trips featuring planned ascents of mountains with a summit height above 6,000 m or trips to the stated Arctic or Antarctic regions or Greenland are classed as expeditions.
                      </p>

                      <p><strong>For ascents of mountains with a summit height above 6,000 m, a separate insurance is offered.</strong></p>

                      <p>
                        The insurance protection also extends to accidents that occur when taking part in the activity of mountain climbing with exceptional risk (climbing at difficulty level 5 UIAA and up, free solo ascents (unsecured climbing) and icefall climbing).
                      </p>

                      <p>
                        Please note: motor vehicle accidents abroad are generally insured as per clause 2, unless they occur during participation in motor sports competitions (even classification races and rally races) and the corre- sponding training runs.
                      </p>

                    </div>
                  </section>

                  <!-- PANEL 5 -->
                  <section class="ic-panel"
                    id="ic-scope-panel-liability"
                    role="tabpanel"
                    aria-labelledby="ic-scope-tab-liability"
                    tabindex="0"
                    data-ic-panel="liability"
                    hidden
                  >
                    <div class="ic-breadcrumb">
                      Insurance overview <span class="ic-sep">›</span> Terms and documentation <span class="ic-sep">›</span> Scope of coverage
                    </div>

                    <h3 class="ic-title">EUROPEAN THIRD-PARTY LIABILITY</h3>

                    <div class="ic-body">
                    <h4>European third party liability insurance up to EUR 3 000 000</h4>

                    <p><strong>Year-round, Europe-wide</strong></p>
                    <br>
                    <p>
                      It provides damage compensation liability insurance for injuries to persons and property damage.
                      Deduction for property damage EUR 200.
                    </p>
                    <br>
                    <p><strong>The services stated protect all domestic and foreign members in the event of claims arising from their association activities.</strong></p>

                    <ul>
                      <li>Participation in any events advertised by the sections of the Alpenverein;</li>
                      <li>
                        Taking part in the following sports (also privately, outside of section-events):
                        <strong>hiking, mountaineering, climbing, via ferrata, skiing, ski touring, cross-country skiing, snowboarding, white water canoeing, canyoning and mountain biking/trekking bike tours.</strong>
                        Mountain biking/trekking bike tours are defined as such tours that are undertaken on cycle paths, forest roads, forest trails, mountain trails and other unpaved paths as well as designated practice or training areas.
                        Accordingly, there is no insurance protection for trips outside of the above-mentioned forest roads and trails, such as on general public traffic areas governed by the Rules of the Road (StVO), pavements, access roads and access paths, etc.
                      </li>
                    </ul>

                  </div>

                  </section>

                  <!-- PANEL 6 -->
                  <section class="ic-panel"
                    id="ic-scope-panel-legal"
                    role="tabpanel"
                    aria-labelledby="ic-scope-tab-legal"
                    tabindex="0"
                    data-ic-panel="legal"
                    hidden
                  >
                    <div class="ic-breadcrumb">
                      Insurance overview <span class="ic-sep">›</span> Terms and documentation <span class="ic-sep">›</span> Scope of coverage
                    </div>

                    <h3 class="ic-title">LEGAL PROTECTION (CRIMINAL LAW)</h3>

                    <div class="ic-body">
                    <h4 class="h5 mb-2">European criminal law legal protection up to EUR 35 000</h4>
                    <p class="mb-3"><strong>Year-round, Europe-wide</strong></p>

                    <p class="mb-3">
                      Insurance protection applies for legal criminal proceedings as of prosecution, and as of the initial legal proceedings for administrative criminal cases.
                    </p>

                    <p class="mb-3">
                      <strong>The services stated protect all domestic and foreign members in the event of claims arising from their association activities.</strong>
                    </p>

                    <ul class="mb-4">
                      <li class="mb-2">Participation in any events advertised by the sections of the Alpenverein;</li>
                      <li>
                        Taking part in the following sports (also privately, outside of section events): hiking, mountaineering, climbing, via ferrata, skiing, ski touring, cross-country skiing, snowboarding, white water canoeing, canyoning and mountain biking/trekking bike tours. Mountain biking/trekking bike tours are defined as such tours that are undertaken on cycle paths, forest roads, forest trails, mountain trails and other unpaved paths as well as designated practice or training areas. Accordingly, there is no insurance protection for trips outside the above- mentioned forest roads and trails, such as on general public traffic areas governed by the Rules of the Road (StVO), pavements, access roads and access paths, etc.
                      </li>
                    </ul>

                    <h4 class="h5 mb-2">
                      European damage compensation legal protection with damage compensation claims after accidents involving personal injury to max. EUR 500 per insured event
                    </h4>

                    <p class="mb-3">
                      Insurance protection shall apply for assumption of legal costs for advice to assert damage compensation claims after events with personal injuries. There shall be no insurance protection for claims of pure property and financial damage.
                    </p>

                    <p class="mb-3">
                      The term Europe is defined geographically and also includes Iceland, Greenland, Svalbard, the Mediterranean islands, the Canary Islands, Madeira, Cyprus, the Azores and the Asian regions of Turkey and the current and former Member States of the CIS.
                    </p>

                    <p class="mb-3">
                      <strong>The services stated protect all domestic and foreign members in the event of claims arising from their association activities.</strong>
                    </p>

                    <ul class="mb-0">
                      <li class="mb-2">Participation in any events advertised by the sections of the Alpenverein;</li>
                      <li>
                        Taking part in the following sports (also privately, outside of section events): hiking, mountaineering, climbing, via ferrata, skiing, ski touring, cross-country skiing, snowboarding, white water canoeing, canyoning and mountain biking/trekking bike tours. Mountain biking/trekking bike tours are defined as such tours that are undertaken on cycle paths, forest roads, forest trails, mountain trails and other unpaved paths as well as designated practice or training areas. Accordingly, there is no insurance protection for trips outside the above- mentioned forest roads and trails, such as on general public traffic areas governed by the Rules of the Road (StVO), pavements, access roads and access paths, etc.
                      </li>
                    </ul>
                  </div>

                  </section>

                </div><!-- /ic-content -->

              </div><!-- /ic-layout -->
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
      <!--================= Scope of coverage end =================-->
      
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
