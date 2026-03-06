<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

$isUserLoggedIn = !empty($_SESSION['user_id']);

// opcionalno: za redirect nazad na istu stranicu posle logout-a
$currentUrl = (string)($_SERVER['REQUEST_URI'] ?? '/');
$logoutHref = 'logout.php?next=' . urlencode($currentUrl);
$loginHref  = 'prijava.php';

$authHref = $isUserLoggedIn ? $logoutHref : $loginHref;
$authText = $isUserLoggedIn ? 'Odjava' : 'Prijava';

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
    <title>BERG Membership Program - Osiguranje</title>

    <meta name="description" content="BERG Membership Program - Kursevi" />
    <meta name="keywords" content="BERG Membership Program, kursevi, članstvo, obuke" />
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
    <!--================= Header Area end =================-->

    <main class="main">
      <!--================= Breadcrumb Area start =================-->
      <section class="vs-breadcrumb" data-bg-src="./assets/img/berg-membership-courses.png">
        <div class="container">
          <div class="row text-center">
            <div class="col-12">
              <div class="breadcrumb-content">
                <h1 class="breadcrumb-title">Osiguranje</h1>
              </div>

              <div class="breadcrumb-content">
                <h5 class="mt-4" style="color: white">
                  Sve što ti treba za bezbedniju avanturu na otvorenom, u jednoj kartici.
                </h5>
              </div>

              <div class="breadcrumb-content">
                <p class="mt-4" style="color: white">
                  Saznaj šta dobijaš uz BERG: zaštitu spasavanja širom sveta,
                  uštede za članove i praktične pogodnosti koje podržavaju tvoj outdoor stil.
                </p>
              </div>

              <div class="fade-anim mt-5" data-delay="0.77" data-direction="top">
                <a href="clanstvo.php" class="vs-btn style4">
                  <span>IZABERI ČLANSTVO</span>
                </a>
                <a href="benefiti.php" class="vs-btn style4-secundary">
                  <span>ZAŠTITA SPASAVANJA</span>
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
                <h2 class="sec-title fade-anim" data-direction="bottom">Obim pokrića</h2>
                </div>
            </div>
            </div>

            <div class="row mt-4">
            <div class="col-12">
                <div class="ic-layout ic-layout--scope" data-ic-root data-ic-default="intro">

                <!-- SIDEBAR -->
                <aside class="ic-sidebar" aria-label="Navigacija - Obim pokrića">
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
                        <span class="ic-label">Uvod u osiguranje</span>
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
                        <span class="ic-label">Akcija spašavanja / potraga (helikopter)</span>
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
                        <span class="ic-label">Bolničko lečenje u inostranstvu</span>
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
                        <span class="ic-label">Transport povređene osobe iz inostranstva</span>
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
                        <span class="ic-label">Evropska odgovornost prema trećim licima</span>
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
                        <span class="ic-label">Pravna zaštita (krivično pravo)</span>
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
                        Pregled osiguranja <span class="ic-sep">›</span> Uslovi i dokumentacija <span class="ic-sep">›</span> Obim pokrića
                    </div>

                    <h3 class="ic-title">UVOD U OSIGURANJE</h3>

                    <div class="ic-body">
                    <p>
                        <strong>Alpenverein Weltweit Service (AWS)</strong> obezbeđuje osiguravajuće pokriće za sve članove
                        Österreichischer Alpenverein <strong>za spasavanja u slučaju bilo kakvih nezgoda tokom aktivnosti u slobodno vreme</strong>.
                        <br>
                        Zaštita u inostranstvu za usluge koje se odnose na repatrijaciju i medicinsko lečenje <strong>obuhvata nezgode u slobodno vreme i nezgode na radu, kao i oboljenja</strong>.
                        <br>
                        Alpenverein Weltweit Service važi <strong>širom sveta</strong>, izuzev osiguranja od odgovornosti prema trećim licima i osiguranja iz oblasti krivičnog prava,
                        koja su ograničena na <strong>Evropu</strong>. Osiguravač za Alpenverein Weltweit Service je Generali Versicherung AG.
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
                        Pregled osiguranja <span class="ic-sep">›</span> Uslovi i dokumentacija <span class="ic-sep">›</span> Obim pokrića
                    </div>

                    <h3 class="ic-title">AKCIJA SPAŠAVANJA / POTRAGA (HELIOKOPTER)</h3>

                    <div class="ic-body">
                        <h4 class="mb-3">
                            Troškovi spasavanja sa nepristupačnog terena u zemlji ili inostranstvu do 25.000 EUR po osobi i osiguranom slučaju
                        </h4>

                        <h5 class="mb-2">Sadržaj</h5>
                        <ol class="mb-4">
                            <li>Troškovi prevoza i premeštaja u okviru države prebivališta (glavnog mesta prebivališta)</li>
                            <li>Izuzeća u vezi sa troškovima spasavanja</li>
                        </ol>

                        <p class="mb-3">
                            Tokom cele godine, širom sveta, u slobodno vreme; Troškovi spasavanja su troškovi koje zaračunavaju lokalne spasilačke organizacije
                            (uključujući i troškove spasilačkih organizacija iz susedne države u slučaju događaja u blizini granice),
                            koji su neophodni ako osigurano lice doživi hitno stanje/nezgodu ili mora biti spaseno iz planinske ili vodene opasnosti
                            ili sa nepristupačnog terena, bilo povređeno ili nepovređeno (isto se shodno primenjuje i u slučaju smrti).
                            Troškovi spasavanja su dokazivi troškovi potrage za osiguranim licem i njegovog/njenog transporta sa nepristupačnog terena
                        </p>

                        <p class="mb-4">
                            a) do najbližeg mesta dostupnog za vozilo (najbližeg pristupačnog puta) ili<br>
                            b) do bolnice najbliže mestu nezgode.
                        </p>

                        <h4 class="mt-4 mb-3">Troškovi prevoza i premeštaja u okviru države prebivališta (glavnog mesta prebivališta)</h4>
                        <p class="mb-3">
                            Nakon spasavanja koje je obuhvaćeno osiguranjem, troškovi premeštaja povređenih/obolelih lica i troškovi prevoza preminulih lica
                            u okviru iste države u kojoj se nalazi glavno mesto prebivališta osiguranog lica biće pokriveni bez ograničenja iznosa.
                            Troškovi premeštaja predstavljaju troškove prevoza iz jedne bolnice u bolnicu u blizini glavnog mesta prebivališta, ili do samog
                            glavnog mesta prebivališta.
                        </p>

                        <p class="mb-3">
                            Troškovi prevoza su troškovi transporta preminulog lica do njegovog/njenog poslednjeg glavnog mesta prebivališta. Prevoz mora biti
                            organizovan od strane ugovorne organizacije navedene na članskoj kartici Alpenverein-a. Ukoliko to nije slučaj, nadoknađuje se
                            najviše 750 EUR:
                        </p>

                        <p class="mb-4">
                            <strong>Europ Assistance,</strong> tel: +43/1/253 3798, faks +43/1/313 89 1304, email: aws@alpenverein.at
                        </p>

                        <h4 class="mt-4 mb-3">Izuzeća u vezi sa troškovima spasavanja</h4>

                        <p class="mb-2"><strong>Osiguravajuće pokriće se ne odnosi na:</strong></p>

                        <ul class="mb-4">
                            <li>
                            Nezgode/oboljenja nastala u okviru radnih ili drugih profesionalnih aktivnosti, kao i nezgode članova spasilačkih organizacija
                            koje nastanu u okviru organizovanih spasilačkih intervencija i obuka po nalogu spasilačke organizacije. Međutim, nezgode tokom
                            plaćenog rada članova Österreichischer Bergführer Verband kao kvalifikovanih planinskih i ski vodiča, kao i zvanično odobrenih i
                            kvalifikovanih planinarskih vodiča, osigurane su.
                            </li>
                            <li>
                            Nezgode prilikom upotrebe motornih vozila; međutim, saobraćajne nezgode motornih vozila, direktno ili indirektno, na putu do i sa
                            sastanaka i događaja Österreichische Alpenverein, kao i na putu do i sa zakonskih (uključujući privatnih) aktivnosti udruženja
                            (planinarenje, ture na krpljama, alpinizam, penjanje, via ferrata, skijanje, skijaško turno skijanje, nordijsko skijanje,
                            snowboarding, kanu na divljim vodama, kanjoning i brdski biciklizam/treking ture, kao i korišćenje žičara i liftova) jesu osigurane.
                            </li>
                            <li>
                            Nezgode tokom učešća na pokrajinskim, nacionalnim ili međunarodnim takmičenjima u nordijskom i alpskom skijanju, snowboardingu i
                            freestyling-u, freeriding-u, bobu, ski-bobu, skeleton-u ili sankanju, kao i tokom treninga za takve događaje;
                            </li>
                            <li>
                            Nezgode osiguranih lica u svojstvu pilota (uključujući sportske pilote, upravljače vazduhoplova/letećih uređaja, kao što su npr.
                            paraglajderi), kada je za to potrebna dozvola prema austrijskom pravu, kao i u svojstvu drugih članova posade vazduhoplova, te pri
                            korišćenju svemirskih letelica ili u svojstvu putnika drona;
                            </li>
                            <li>Ronjenja sa izuzetno povećanim rizikom (ronjenja na 40 m ili više, ronjenje pod ledom, ronilačke ekspedicije);</li>
                            <li>
                            Učešće na takmičenjima u brdskom biciklizmu (downhill, four cross, dirt jump), uključujući zvanične treninge i kvalifikacione vožnje;
                            </li>
                            <li>Pokušaje obaranja rekorda u brzini, ronjenju i aeronautici;</li>
                            <li>
                            Nezgode/oboljenja na putovanjima sa planiranim usponima na planine čiji su vrhovi viši od 6.000 m i putovanja na Arktik
                            (destinacije severno od Arktičkog kruga), Antarktik (destinacije južno od Antarktičkog kruga) i Grenland. *
                            </li>
                            <li>
                            Učešće u ekspedicijama – ekspedicija se definiše kao putovanje u retko posećena područja bez stalne infrastrukture (npr. planinarskih
                            domova/koliba), koje traje više dana ili nedelja i koje se, u određenoj meri, preduzima u svrhe istraživanja ili naučnog rada.
                            </li>
                        </ul>

                        <p class="mb-2"><strong>Pojašnjenje:</strong></p>

                        <p class="mb-3">
                            U skladu sa gore navedenim izuzećima, sve planinarske aktivnosti i putovanja koja se preduzimaju sa ciljem uspona na planinu čija je
                            visina vrha ispod 6.000 m, i koja ne uključuju posetu navedenim arktičkim ili antarktičkim regionima ili Grenlandu, ipak su osigurana
                            čak i ako ih organizator označi kao ekspedicije. Međutim, putovanja sa bilo kakvom komercijalnom pozadinom (profesionalna delatnost)
                            izuzeta su iz osiguravajućeg pokrića za učesnika. Putovanja sa planiranim usponima na planine čija je visina vrha iznad 6.000 m ili
                            putovanja u navedene arktičke ili antarktičke regione ili na Grenland smatraju se ekspedicijama.
                        </p>

                        <p class="mb-3">
                            <strong>Za uspone na planine čija je visina vrha iznad 6.000 m nudi se zasebno osiguranje.</strong>
                            Informacije i dokumentacija: www.alpenverein.at/versicherung
                        </p>

                        <p class="mb-3">
                            Osiguravajuće pokriće se takođe odnosi na nezgode koje nastanu prilikom bavljenja planinskim penjanjem sa izuzetno povećanim rizikom
                            (penjanje težine 5 UIAA i više, free solo usponi (penjanje bez osiguranja) i penjanje po ledenim slapovima).
                        </p>

                        <p class="mb-0">
                            * Putovanja u sve delove kopnenog dela Finske, Norveške i Švedske su osigurana, čak i ako su severno od Arktičkog kruga. „Kopneni deo“
                            označava deo tih država do kojeg je moguće doći kopnenim putem, uključujući i korišćenje mostova i/ili tunela.
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
                        Pregled osiguranja <span class="ic-sep">›</span> Uslovi i dokumentacija <span class="ic-sep">›</span> Obim pokrića
                    </div>

                    <h3 class="ic-title">BOLNIČKO LEČENJE U INOSTRANSTVU</h3>

                    <div class="ic-body">
                    <h4>Repatrijacija i troškovi medicinskog lečenja u inostranstvu</h4>
                    <p>Važi širom sveta tokom prvih osam nedelja svakog putovanja u inostranstvo, za nezgode u slobodno vreme i nezgode na radu, kao i za oboljenja.</p>

                    <ul>
                        <li>Usluga repatrijacije iz inostranstva: pokriće bez ograničenja iznosa</li>
                        <li>Medicinski neophodno terapijsko lečenje u inostranstvu (uključujući medicinski neophodan prevoz do bolnice): do 10.000 EUR.</li>
                    </ul>

                    <ol>
                        <li>
                        <p>
                            Puni troškovi medicinski opravdanog transporta pacijenta iz inostranstva do bolnice u državi glavnog mesta prebivališta povređenog/obolelog lica, ili do samog glavnog mesta prebivališta, uključujući i troškove transporta lica bliskog osiguranom licu koje putuje zajedno sa osiguranim licem. Za repatrijaciju važe sledeći uslovi, pored uslova da zdravstveno stanje osiguranog lica omogućava transport:
                        </p>
                        <ul>
                            <li>da postoji po život opasno zdravstveno stanje ili</li>
                            <li>da lokalno dostupna medicinska nega ne obezbeđuje lečenje po standardu koji odgovara standardu u državi glavnog mesta prebivališta osiguranog lica, ili</li>
                            <li>da se očekuje bolničko (stacionarno) lečenje duže od pet dana. Transport mora biti organizovan od strane ugovorne organizacije navedene na članskoj kartici Alpenverein-a. Ukoliko to nije slučaj, nadoknađuje se najviše 750 EUR:</li>
                        </ul>
                        <p><strong>Europ Assistance</strong>, tel: +43/1/253 3798, faks +43/1/313 89 1304, email: aws@alpenverein.at</p>
                        </li>

                        <li>
                        <p>
                            Troškovi nastali u inostranstvu za hitno, medicinski neophodno lečenje, uključujući terapijske proizvode propisane od strane lekara, kao i medicinski neophodan prevoz do najbliže odgovarajuće bolnice, do ukupne osigurane sume od 10.000 EUR, od čega je 2.000 EUR raspoloživo za ambulantna lečenja, uključujući terapijske proizvode propisane od strane lekara. Za ambulantna lečenja, uključujući terapijske proizvode propisane od strane lekara, primenjuje se odbitak (franšiza) od 70 EUR po osobi i boravku u inostranstvu. Ovaj iznos se uvek odbija od isplate iz osiguranja od strane Generali Versicherung AG, čak i ako je neko drugo obavezno ili privatno osiguranje takođe dužno da izvrši plaćanje. Osiguravač nadoknađuje dokumentovane troškove medicinski neophodnog bolničkog (stacionarnog) lečenja.
                        </p>

                        <ul>
                            <li>U Austriji: prema opštoj tarifnoj klasi u javnim bolnicama;</li>
                            <li>Van Austrije: u javnim bolnicama.</li>
                        </ul>

                        <p>
                            Ako hitnost bolničkog (stacionarnog) lečenja onemogućava prijem u javnoj bolnici, ili ako osigurano lice nije moglo da utiče na izbor bolnice, osiguravač nadoknađuje dokumentovane troškove medicinski neophodnog terapijskog lečenja i u nejavnim bolnicama. Obaveza osiguravača da vrši plaćanje prestaje kada je medicinski opravdan transport u javnu bolnicu.
                        </p>

                        <p>
                            Troškovi medicinski neophodnog bolničkog (stacionarnog) lečenja prema tački 2.2. mogu se direktno fakturisati osiguravaču do visine osigurane sume samo ako se u bolnici priloži e-card/EHIC kartica i ako obradu izvrši Europ Assistance.
                        </p>

                        <p><strong>U suprotnom, nadoknađuje se najviše 750 EUR.</strong></p>

                        <p>
                            Ako nemate EHIC karticu, morate odmah kontaktirati Europ Assistance kako bi se obezbedilo preuzimanje troškova za bolnički (stacionarni) boravak.
                        </p>

                        <p><strong>Europ Assistance</strong>, tel: +43/1/253 3798, faks +43/1/313 89 1304, email: aws@alpenverein.at</p>

                        <p>
                            Informacije o Evropskoj kartici zdravstvenog osiguranja<br>
                            (EHIC) dostupne su na: <a href="http://ec.europa.eu/social" target="_blank" rel="noopener">http://ec.europa.eu/social</a>
                        </p>
                        </li>

                        <li>
                        <p>
                            Puni troškovi prevoza preminulog lica do njegovog/njenog poslednjeg glavnog mesta prebivališta. Transport mora biti organizovan od strane ugovorne organizacije navedene na članskoj kartici Alpenverein-a. Ukoliko to nije slučaj, nadoknađuje se najviše 750 EUR:
                        </p>
                        <p><strong>Europ Assistance</strong>, tel: +43/1/253 3798, faks +43/1/313 89 1304, email: aws@alpenverein.at</p>
                        </li>
                    </ol>

                    <p>Za putovanja u inostranstvo duža od osam nedelja nudi se zasebno osiguranje. Informacije i dokumentacija.</p>

                    <p><strong>Izuzeća u vezi sa repatrijacijom i medicinskim lečenjem:</strong></p>
                    <p>Osiguravajuće pokriće se ne odnosi na:</p>

                    <ul>
                        <li>Terapijska lečenja koja su započela pre početka putovanja u inostranstvo;</li>
                        <li>Terapijska lečenja hroničnih oboljenja, osim kao posledica akutnih napada ili pogoršanja;</li>
                        <li>Terapijska lečenja koja su svrha boravka u inostranstvu;</li>
                        <li>Stomatološke tretmane koji ne služe kao početno zbrinjavanje radi hitnog ublažavanja bola;</li>
                        <li>Prekide trudnoće, preglede u trudnoći i porođaje, osim prevremenih porođaja koji nastupe najmanje dva meseca pre prirodnog termina porođaja. Ovo se shodno primenjuje i na prevremeno rođene bebe;</li>
                        <li>Terapijska lečenja usled prekomerne konzumacije alkohola, zloupotrebe opojnih droga ili zloupotrebe lekova;</li>
                        <li>Kozmetičke tretmane, banjska lečenja i mere rehabilitacije;</li>
                        <li>Preventivne vakcinacije;</li>
                        <li>Terapijska lečenja oboljenja i posledica nezgoda nastalih usled ratnih događaja bilo koje vrste, kao i usled aktivnog učešća u neredima ili namernim krivičnim delima;</li>
                        <li>Terapijska lečenja oboljenja i posledica nezgoda nastalih usled aktivnog plaćenog učešća na javno organizovanim sportskim takmičenjima i treninga za takve događaje;</li>
                        <li>Terapijska lečenja oboljenja i posledica nezgoda nastalih usled aktivnog učešća na pokrajinskim, nacionalnim ili međunarodnim takmičenjima u nordijskom i alpskom skijanju, snowboardingu i freestyling-u, freeriding-u, bobu, ski-bobu, skeleton-u ili sankanju, kao i tokom treninga za takve događaje, kao i oboljenja i posledica nezgoda nastalih usled aktivnog plaćenog učešća na javno organizovanim sportskim takmičenjima i treninga za takve događaje (izuzev takmičenja u penjanju kao člana Austrijskog penjačkog saveza);</li>
                        <li>Terapijska lečenja oboljenja i posledica nezgoda nastalih usled učešća u takmičenjima u moto-sportovima (uključujući i klasifikacione trke i reli trke) i odgovarajućih trening vožnji;</li>
                        <li>Terapijska lečenja oboljenja i nezgoda prilikom korišćenja vazduhoplovne opreme (na primer zmajevi za jedrenje, paraglajderi), vazduhoplova (privatni motorni avioni i jedrilice) i pri padobranskim skokovima. Međutim, korišćenje motorizovanih vazduhoplova odobrenih za prevoz putnika (npr. komercijalni avioni) u svojstvu putnika je osigurano – izuzev motorizovanih jedrilica i ultralakih letelica; putnicima se smatraju lica koja nisu u uzročnoj vezi sa upravljanjem vazduhoplovom, nisu članovi posade i ne obavljaju profesionalnu delatnost korišćenjem vazduhoplova;</li>
                        <li>Terapijska lečenja oboljenja i posledica nezgoda nastalih usled štetnog dejstva nuklearne energije;</li>
                        <li>Terapijska lečenja oboljenja i posledica nezgoda članova spasilačkih organizacija, koja nastanu u okviru organizovanih spasilačkih intervencija i obuka po nalogu spasilačke organizacije.</li>
                        <li>Ronjenja sa izuzetno povećanim rizikom (ronjenja na 40 m ili više, ronjenje pod ledom, ronilačke ekspedicije);</li>
                        <li>Učešće na takmičenjima u brdskom biciklizmu (downhill, four cross, dirt jump), uključujući zvanične treninge i kvalifikacione vožnje;</li>
                        <li>Pokušaje obaranja rekorda u brzini, ronjenju i aeronautici;</li>
                        <li>Nezgode/oboljenja na putovanjima sa planiranim usponima na planine čiji su vrhovi viši od 6.000 m i putovanja na Arktik (destinacije severno od Arktičkog kruga), Antarktik (destinacije južno od Antarktičkog kruga) i Grenland.</li>
                        <li>Učešće u ekspedicijama – ekspedicija se definiše kao putovanje u retko posećena područja bez stalne infrastrukture (npr. planinarskih domova/koliba), koje traje više dana ili nedelja i koje se, u određenoj meri, preduzima u svrhe istraživanja ili naučnog rada.</li>
                    </ul>

                    <p><strong>Pojašnjenje:</strong></p>
                    <p>
                        U skladu sa gore navedenim izuzećima, sve planinarske aktivnosti i putovanja koja se preduzimaju sa ciljem uspona na planinu čija je visina vrha ispod 6.000 m, i koja ne uključuju posetu navedenim arktičkim ili antarktičkim regionima ili Grenlandu, ipak su osigurana čak i ako ih organizator označi kao ekspedicije. Putovanja sa planiranim usponima na planine čija je visina vrha iznad 6.000 m ili putovanja u navedene arktičke ili antarktičke regione ili na Grenland smatraju se ekspedicijama.
                    </p>

                    <p><strong>Za uspone na planine čija je visina vrha iznad 6.000 m nudi se zasebno osiguranje.</strong></p>

                    <p>
                        Osiguravajuće pokriće se takođe odnosi na nezgode koje nastanu prilikom bavljenja planinskim penjanjem sa izuzetno povećanim rizikom
                        (penjanje težine 5 UIAA i više, free solo usponi (penjanje bez osiguranja) i penjanje po ledenim slapovima).
                    </p>

                    <p>
                        Napomena: saobraćajne nezgode motornih vozila u inostranstvu su, po pravilu, osigurane u skladu sa tačkom 2, osim ako nastanu tokom učešća
                        u takmičenjima u moto-sportovima (uključujući i klasifikacione trke i reli trke) i odgovarajućih trening vožnji.
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
                        Pregled osiguranja <span class="ic-sep">›</span> Uslovi i dokumentacija <span class="ic-sep">›</span> Obim pokrića
                    </div>

                    <h3 class="ic-title">TRANSPORT POVREĐENE OSOBE IZ INOSTRANSTVA</h3>

                    <div class="ic-body">
                                          <h4>Repatrijacija i troškovi medicinskog lečenja u inostranstvu</h4>
                    <p>Važi širom sveta tokom prvih osam nedelja svakog putovanja u inostranstvo, za nezgode u slobodno vreme i nezgode na radu, kao i za oboljenja.</p>

                    <ul>
                        <li>Usluga repatrijacije iz inostranstva: pokriće bez ograničenja iznosa</li>
                        <li>Medicinski neophodno terapijsko lečenje u inostranstvu (uključujući medicinski neophodan prevoz do bolnice): do 10.000 EUR.</li>
                    </ul>

                    <ol>
                        <li>
                        <p>
                            Puni troškovi medicinski opravdanog transporta pacijenta iz inostranstva do bolnice u državi glavnog mesta prebivališta povređenog/obolelog lica, ili do samog glavnog mesta prebivališta, uključujući i troškove transporta lica bliskog osiguranom licu koje putuje zajedno sa osiguranim licem. Za repatrijaciju važe sledeći uslovi, pored uslova da zdravstveno stanje osiguranog lica omogućava transport:
                        </p>
                        <ul>
                            <li>da postoji po život opasno zdravstveno stanje ili</li>
                            <li>da lokalno dostupna medicinska nega ne obezbeđuje lečenje po standardu koji odgovara standardu u državi glavnog mesta prebivališta osiguranog lica, ili</li>
                            <li>da se očekuje bolničko (stacionarno) lečenje duže od pet dana. Transport mora biti organizovan od strane ugovorne organizacije navedene na članskoj kartici Alpenverein-a. Ukoliko to nije slučaj, nadoknađuje se najviše 750 EUR:</li>
                        </ul>
                        <p><strong>Europ Assistance</strong>, tel: +43/1/253 3798, faks +43/1/313 89 1304, email: aws@alpenverein.at</p>
                        </li>

                        <li>
                        <p>
                            Troškovi nastali u inostranstvu za hitno, medicinski neophodno lečenje, uključujući terapijske proizvode propisane od strane lekara, kao i medicinski neophodan prevoz do najbliže odgovarajuće bolnice, do ukupne osigurane sume od 10.000 EUR, od čega je 2.000 EUR raspoloživo za ambulantna lečenja, uključujući terapijske proizvode propisane od strane lekara. Za ambulantna lečenja, uključujući terapijske proizvode propisane od strane lekara, primenjuje se odbitak (franšiza) od 70 EUR po osobi i boravku u inostranstvu. Ovaj iznos se uvek odbija od isplate iz osiguranja od strane Generali Versicherung AG, čak i ako je neko drugo obavezno ili privatno osiguranje takođe dužno da izvrši plaćanje. Osiguravač nadoknađuje dokumentovane troškove medicinski neophodnog bolničkog (stacionarnog) lečenja.
                        </p>

                        <ul>
                            <li>U Austriji: prema opštoj tarifnoj klasi u javnim bolnicama;</li>
                            <li>Van Austrije: u javnim bolnicama.</li>
                        </ul>

                        <p>
                            Ako hitnost bolničkog (stacionarnog) lečenja onemogućava prijem u javnoj bolnici, ili ako osigurano lice nije moglo da utiče na izbor bolnice, osiguravač nadoknađuje dokumentovane troškove medicinski neophodnog terapijskog lečenja i u nejavnim bolnicama. Obaveza osiguravača da vrši plaćanje prestaje kada je medicinski opravdan transport u javnu bolnicu.
                        </p>

                        <p>
                            Troškovi medicinski neophodnog bolničkog (stacionarnog) lečenja prema tački 2.2. mogu se direktno fakturisati osiguravaču do visine osigurane sume samo ako se u bolnici priloži e-card/EHIC kartica i ako obradu izvrši Europ Assistance.
                        </p>

                        <p><strong>U suprotnom, nadoknađuje se najviše 750 EUR.</strong></p>

                        <p>
                            Ako nemate EHIC karticu, morate odmah kontaktirati Europ Assistance kako bi se obezbedilo preuzimanje troškova za bolnički (stacionarni) boravak.
                        </p>

                        <p><strong>Europ Assistance</strong>, tel: +43/1/253 3798, faks +43/1/313 89 1304, email: aws@alpenverein.at</p>

                        <p>
                            Informacije o Evropskoj kartici zdravstvenog osiguranja<br>
                            (EHIC) dostupne su na: <a href="http://ec.europa.eu/social" target="_blank" rel="noopener">http://ec.europa.eu/social</a>
                        </p>
                        </li>

                        <li>
                        <p>
                            Puni troškovi prevoza preminulog lica do njegovog/njenog poslednjeg glavnog mesta prebivališta. Transport mora biti organizovan od strane ugovorne organizacije navedene na članskoj kartici Alpenverein-a. Ukoliko to nije slučaj, nadoknađuje se najviše 750 EUR:
                        </p>
                        <p><strong>Europ Assistance</strong>, tel: +43/1/253 3798, faks +43/1/313 89 1304, email: aws@alpenverein.at</p>
                        </li>
                    </ol>

                    <p>Za putovanja u inostranstvo duža od osam nedelja nudi se zasebno osiguranje. Informacije i dokumentacija.</p>

                    <p><strong>Izuzeća u vezi sa repatrijacijom i medicinskim lečenjem:</strong></p>
                    <p>Osiguravajuće pokriće se ne odnosi na:</p>

                    <ul>
                        <li>Terapijska lečenja koja su započela pre početka putovanja u inostranstvo;</li>
                        <li>Terapijska lečenja hroničnih oboljenja, osim kao posledica akutnih napada ili pogoršanja;</li>
                        <li>Terapijska lečenja koja su svrha boravka u inostranstvu;</li>
                        <li>Stomatološke tretmane koji ne služe kao početno zbrinjavanje radi hitnog ublažavanja bola;</li>
                        <li>Prekide trudnoće, preglede u trudnoći i porođaje, osim prevremenih porođaja koji nastupe najmanje dva meseca pre prirodnog termina porođaja. Ovo se shodno primenjuje i na prevremeno rođene bebe;</li>
                        <li>Terapijska lečenja usled prekomerne konzumacije alkohola, zloupotrebe opojnih droga ili zloupotrebe lekova;</li>
                        <li>Kozmetičke tretmane, banjska lečenja i mere rehabilitacije;</li>
                        <li>Preventivne vakcinacije;</li>
                        <li>Terapijska lečenja oboljenja i posledica nezgoda nastalih usled ratnih događaja bilo koje vrste, kao i usled aktivnog učešća u neredima ili namernim krivičnim delima;</li>
                        <li>Terapijska lečenja oboljenja i posledica nezgoda nastalih usled aktivnog plaćenog učešća na javno organizovanim sportskim takmičenjima i treninga za takve događaje;</li>
                        <li>Terapijska lečenja oboljenja i posledica nezgoda nastalih usled aktivnog učešća na pokrajinskim, nacionalnim ili međunarodnim takmičenjima u nordijskom i alpskom skijanju, snowboardingu i freestyling-u, freeriding-u, bobu, ski-bobu, skeleton-u ili sankanju, kao i tokom treninga za takve događaje, kao i oboljenja i posledica nezgoda nastalih usled aktivnog plaćenog učešća na javno organizovanim sportskim takmičenjima i treninga za takve događaje (izuzev takmičenja u penjanju kao člana Austrijskog penjačkog saveza);</li>
                        <li>Terapijska lečenja oboljenja i posledica nezgoda nastalih usled učešća u takmičenjima u moto-sportovima (uključujući i klasifikacione trke i reli trke) i odgovarajućih trening vožnji;</li>
                        <li>Terapijska lečenja oboljenja i nezgoda prilikom korišćenja vazduhoplovne opreme (na primer zmajevi za jedrenje, paraglajderi), vazduhoplova (privatni motorni avioni i jedrilice) i pri padobranskim skokovima. Međutim, korišćenje motorizovanih vazduhoplova odobrenih za prevoz putnika (npr. komercijalni avioni) u svojstvu putnika je osigurano – izuzev motorizovanih jedrilica i ultralakih letelica; putnicima se smatraju lica koja nisu u uzročnoj vezi sa upravljanjem vazduhoplovom, nisu članovi posade i ne obavljaju profesionalnu delatnost korišćenjem vazduhoplova;</li>
                        <li>Terapijska lečenja oboljenja i posledica nezgoda nastalih usled štetnog dejstva nuklearne energije;</li>
                        <li>Terapijska lečenja oboljenja i posledica nezgoda članova spasilačkih organizacija, koja nastanu u okviru organizovanih spasilačkih intervencija i obuka po nalogu spasilačke organizacije.</li>
                        <li>Ronjenja sa izuzetno povećanim rizikom (ronjenja na 40 m ili više, ronjenje pod ledom, ronilačke ekspedicije);</li>
                        <li>Učešće na takmičenjima u brdskom biciklizmu (downhill, four cross, dirt jump), uključujući zvanične treninge i kvalifikacione vožnje;</li>
                        <li>Pokušaje obaranja rekorda u brzini, ronjenju i aeronautici;</li>
                        <li>Nezgode/oboljenja na putovanjima sa planiranim usponima na planine čiji su vrhovi viši od 6.000 m i putovanja na Arktik (destinacije severno od Arktičkog kruga), Antarktik (destinacije južno od Antarktičkog kruga) i Grenland.</li>
                        <li>Učešće u ekspedicijama – ekspedicija se definiše kao putovanje u retko posećena područja bez stalne infrastrukture (npr. planinarskih domova/koliba), koje traje više dana ili nedelja i koje se, u određenoj meri, preduzima u svrhe istraživanja ili naučnog rada.</li>
                    </ul>

                    <p><strong>Pojašnjenje:</strong></p>
                    <p>
                        U skladu sa gore navedenim izuzećima, sve planinarske aktivnosti i putovanja koja se preduzimaju sa ciljem uspona na planinu čija je visina vrha ispod 6.000 m, i koja ne uključuju posetu navedenim arktičkim ili antarktičkim regionima ili Grenlandu, ipak su osigurana čak i ako ih organizator označi kao ekspedicije. Putovanja sa planiranim usponima na planine čija je visina vrha iznad 6.000 m ili putovanja u navedene arktičke ili antarktičke regione ili na Grenland smatraju se ekspedicijama.
                    </p>

                    <p><strong>Za uspone na planine čija je visina vrha iznad 6.000 m nudi se zasebno osiguranje.</strong></p>

                    <p>
                        Osiguravajuće pokriće se takođe odnosi na nezgode koje nastanu prilikom bavljenja planinskim penjanjem sa izuzetno povećanim rizikom
                        (penjanje težine 5 UIAA i više, free solo usponi (penjanje bez osiguranja) i penjanje po ledenim slapovima).
                    </p>

                    <p>
                        Napomena: saobraćajne nezgode motornih vozila u inostranstvu su, po pravilu, osigurane u skladu sa tačkom 2, osim ako nastanu tokom učešća
                        u takmičenjima u moto-sportovima (uključujući i klasifikacione trke i reli trke) i odgovarajućih trening vožnji.
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
                        Pregled osiguranja <span class="ic-sep">›</span> Uslovi i dokumentacija <span class="ic-sep">›</span> Obim pokrića
                    </div>

                    <h3 class="ic-title">EVROPSKA ODGOVORNOST PREMA TREĆIM LICIMA</h3>

                    <div class="ic-body">
                        <h4>Evropsko osiguranje od odgovornosti prema trećim licima do 3.000.000 EUR</h4>

                        <p><strong>Tokom cele godine, na teritoriji Evrope</strong></p>
                        <br>
                        <p>
                            Obezbeđuje osiguranje od građanskopravne odgovornosti za naknadu štete usled povreda lica i štete na stvarima.
                            Odbitak (franšiza) za štetu na stvarima iznosi 200 EUR.
                        </p>
                        <br>
                        <p><strong>Navedene usluge štite sve domaće i strane članove u slučaju potraživanja koja proisteknu iz njihovih aktivnosti u okviru udruženja.</strong></p>

                        <ul>
                            <li>Učešće na bilo kojim događajima koje oglašavaju sekcije Alpenverein-a;</li>
                            <li>
                            Bavljenje sledećim sportovima (i privatno, van događaja koje organizuju sekcije):
                            <strong>planinarenje, alpinizam, penjanje, via ferrata, skijanje, skijaško turno skijanje, nordijsko skijanje, snowboarding, kanu na divljim vodama, kanjoning i brdski biciklizam/treking bicikl ture.</strong>
                            Brdski biciklizam/treking bicikl ture podrazumevaju ture koje se odvijaju na biciklističkim stazama, šumskim putevima, šumskim stazama, planinskim stazama i drugim neasfaltiranim putevima, kao i u označenim vežbalištima ili trening zonama.
                            Shodno tome, ne postoji osiguravajuće pokriće za vožnje van gore navedenih šumskih puteva i staza, na primer na opštim javnim saobraćajnim površinama na koje se primenjuju Pravila saobraćaja na putevima (StVO), trotoarima, prilaznim putevima i prilaznim stazama i sl.
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
                        Pregled osiguranja <span class="ic-sep">›</span> Uslovi i dokumentacija <span class="ic-sep">›</span> Obim pokrića
                    </div>

                    <h3 class="ic-title">PRAVNA ZAŠTITA (KRIVIČNO PRAVO)</h3>

                    <div class="ic-body">
                                          <h4 class="h5 mb-2">Evropsko osiguranje pravne zaštite u krivičnim postupcima do 35.000 EUR</h4>
                    <p class="mb-3"><strong>Tokom cele godine, na teritoriji Evrope</strong></p>

                    <p class="mb-3">
                      Osiguravajuće pokriće važi za krivične pravne postupke od trenutka pokretanja krivičnog gonjenja, kao i od početka pravnog postupka u
                      upravno-kaznenim predmetima (administrativni prekršajni postupci).
                    </p>

                    <p class="mb-3">
                      <strong>Navedene usluge štite sve domaće i strane članove u slučaju potraživanja koja proisteknu iz njihovih aktivnosti u okviru udruženja.</strong>
                    </p>

                    <ul class="mb-4">
                      <li class="mb-2">Učešće na bilo kojim događajima koje oglašavaju sekcije Alpenverein-a;</li>
                      <li>
                        Bavljenje sledećim sportovima (i privatno, van događaja koje organizuju sekcije): planinarenje, alpinizam, penjanje, via ferrata, skijanje,
                        skijaško turno skijanje, nordijsko skijanje, snowboarding, kanu na divljim vodama, kanjoning i brdski biciklizam/treking bicikl ture.
                        Brdski biciklizam/treking bicikl ture podrazumevaju ture koje se odvijaju na biciklističkim stazama, šumskim putevima, šumskim stazama,
                        planinskim stazama i drugim neasfaltiranim putevima, kao i u označenim vežbalištima ili trening zonama. Shodno tome, ne postoji
                        osiguravajuće pokriće za vožnje van gore navedenih šumskih puteva i staza, na primer na opštim javnim saobraćajnim površinama na koje se
                        primenjuju Pravila saobraćaja na putevima (StVO), trotoarima, prilaznim putevima i prilaznim stazama i sl.
                      </li>
                    </ul>

                    <h4 class="h5 mb-2">
                      Evropska pravna zaštita radi ostvarivanja naknade štete (odštetni zahtevi) nakon nezgoda sa telesnim povredama, do najviše 500 EUR po osiguranom slučaju
                    </h4>

                    <p class="mb-3">
                      Osiguravajuće pokriće važi za preuzimanje troškova pravne pomoći/savetovanja radi ostvarivanja odštetnih zahteva nakon događaja sa telesnim povredama.
                      Ne postoji osiguravajuće pokriće za zahteve koji se odnose isključivo na štetu na stvarima i/ili čistu finansijsku štetu.
                    </p>

                    <p class="mb-3">
                      Pojam Evropa definiše se geografski i obuhvata i Island, Grenland, Svalbard, mediteranska ostrva, Kanarska ostrva, Madeiru, Kipar, Azore, azijske delove
                      Turske, kao i sadašnje i bivše države članice ZND (CIS).
                    </p>

                    <p class="mb-3">
                      <strong>Navedene usluge štite sve domaće i strane članove u slučaju potraživanja koja proisteknu iz njihovih aktivnosti u okviru udruženja.</strong>
                    </p>

                    <ul class="mb-0">
                      <li class="mb-2">Učešće na bilo kojim događajima koje oglašavaju sekcije Alpenverein-a;</li>
                      <li>
                        Bavljenje sledećim sportovima (i privatno, van događaja koje organizuju sekcije): planinarenje, alpinizam, penjanje, via ferrata, skijanje,
                        skijaško turno skijanje, nordijsko skijanje, snowboarding, kanu na divljim vodama, kanjoning i brdski biciklizam/treking bicikl ture.
                        Brdski biciklizam/treking bicikl ture podrazumevaju ture koje se odvijaju na biciklističkim stazama, šumskim putevima, šumskim stazama,
                        planinskim stazama i drugim neasfaltiranim putevima, kao i u označenim vežbalištima ili trening zonama. Shodno tome, ne postoji
                        osiguravajuće pokriće za vožnje van gore navedenih šumskih puteva i staza, na primer na opštim javnim saobraćajnim površinama na koje se
                        primenjuju Pravila saobraćaja na putevima (StVO), trotoarima, prilaznim putevima i prilaznim stazama i sl.
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
                <a href="clanstvo.php" class="vs-btn style4">
                  <span>POSTANI ČLAN</span>
                </a>
              </div>
            </div>
          </div>

        </div>
        </section>
        <!--================= Scope of coverage end =================-->

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
  </body>
</html>
