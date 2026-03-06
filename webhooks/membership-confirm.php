<?php
declare(strict_types=1);

require_once __DIR__ . '/../PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 1) Token zaštita
$expectedToken = '43fGH517weGht';
$token = (string)($_GET['token'] ?? '');
if (!hash_equals($expectedToken, $token)) {
  http_response_code(403);
  echo 'Forbidden';
  exit;
}

// 2) Učitaj payload
$raw = file_get_contents('php://input') ?: '';
$decoded = json_decode($raw, true);

$form = [];

// Standard: {"form_data": {...}}
if (is_array($decoded) && isset($decoded['form_data'])) {
  if (is_array($decoded['form_data'])) {
    $form = $decoded['form_data'];
  } else {
    $maybe = json_decode((string)$decoded['form_data'], true);
    if (is_array($maybe)) $form = $maybe;
  }
}

// Alternative: payload direktno forma
if (empty($form) && is_array($decoded)) {
  if (isset($decoded['email']) || isset($decoded['first_name']) || isset($decoded['last_name'])) {
    $form = $decoded;
  }
}

// Fallback: form-encoded POST
if (empty($form) && !empty($_POST)) {
  $form = $_POST;
}

// Last resort: izvuci email iz raw
if (empty($form) && $raw !== '') {
  if (preg_match('/"email"\s*:\s*"([^"]+)"/i', $raw, $m)) {
    $form['email'] = $m[1];
  }
}

// 3) Izvuci vrednosti
$email = (string)($form['email'] ?? '');
$email = filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : '';

$firstName = trim((string)($form['first_name'] ?? ''));
$lastName  = trim((string)($form['last_name'] ?? ''));

$selectedPlan   = trim((string)($form['selected_plan'] ?? ''));
$selectedOption = trim((string)($form['selected_option'] ?? ''));
$selectedPrice  = trim((string)($form['selected_price'] ?? ''));

// ako frontend pošalje "95 € 85 €", uzmi samo poslednju cenu
if ($selectedPrice !== '') {
  preg_match_all('/\d+/', $selectedPrice, $matches);
  if (!empty($matches[0])) {
    $selectedPrice = end($matches[0]) . ' €';
  }
}
$orderRef       = trim((string)($form['order_reference'] ?? ''));

if ($email === '') {
  http_response_code(200);
  echo json_encode(['ok' => true, 'sent' => false, 'reason' => 'no_valid_email']);
  exit;
}

// 4) Anti-duplikat
$dedupeKey  = $orderRef !== '' ? preg_replace('/[^0-9A-Za-z_-]/', '', $orderRef) : substr(sha1($raw), 0, 16);
$dedupeFile = __DIR__ . '/.membership_autoreply_sent.txt';

if (is_file($dedupeFile) && is_readable($dedupeFile)) {
  $lines = file($dedupeFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
  if (in_array($dedupeKey, $lines, true)) {
    http_response_code(200);
    echo json_encode(['ok' => true, 'sent' => false, 'reason' => 'duplicate']);
    exit;
  }
}

// 5) Label za plan
$planLabel = $selectedPlan;
if ($selectedPlan === 'explorer') $planLabel = 'BERG EXPLORER';
if ($selectedPlan === 'family')   $planLabel = 'BERG FAMILY';

// 6) Poruka (HTML + plain)
$greetingName = $firstName !== '' ? $firstName : '';
$greetingLine = $greetingName !== '' ? "Poštovani {$greetingName}," : "Poštovani,";

$details = [];
if ($planLabel !== '')      $details[] = "Program: {$planLabel}";
if ($selectedOption !== '') $details[] = "Opcija: {$selectedOption}";
if ($selectedPrice !== '')  $details[] = "Cena: {$selectedPrice}";
if ($orderRef !== '')       $details[] = "Referenca: {$orderRef}";

$subject = 'BERG Membership 2026 – Potvrda prijema';

$bodyText =
  $greetingLine . "\n\n"
  . "Ovim putem potvrđujemo da je započeta obrada Vaše porudžbine za članarinu BERG Membership za 2026. godinu.\n"
  . "Vaše članstvo, zajedno sa svim pripadajućim benefitima, biće aktivirano u ponoć prvog narednog dana nakon evidentiranja i proknjiženja uplate na našem računu, u skladu sa važećim procedurama.\n"
  . (!empty($details) ? "\nDetalji prijave:\n- " . implode("\n- ", $details) . "\n" : "")
  . "\nPodaci za uplatu članarine (BERG):\n"
  . "Naziv primaoca: BERG\n"
  . "Matični broj: 28407866\n"
  . "PIB: 115431587\n"
  . "Banka: Banca Intesa a.d. Beograd\n"
  . "Broj računa: 160-6000002499382-03\n"
  . "Adresa: Balkanska 18, Beograd (Stari grad)\n"
  . "Iznos: $selectedPrice u dinarskoj protivvrednosti, po srednjem kursu Narodne banke Srbije (NBS) na dan uplate\n"
  . "\nPo uspešno evidentiranoj uplati, na ovu e-mail adresu biće Vam dostavljeno sledeće:\n"
  . "– fiskalni račun,\n"
  . "– digitalna Alpenverein članska karta,\n"
  . "– kompletna prateća dokumentacija u PDF formatu,\n"
  . "– pristupni podaci i detaljno uputstvo za korišćenje BERG Member portala.\n"
  . "\nUkoliko imate dodatna pitanja, potrebu za pojašnjenjem ili tehničku podršku u vezi sa uplatom ili članstvom, naš tim Vam stoji na raspolaganju.\n"
  . "\nZahvaljujemo se na ukazanom poverenju i dobrodošli u BERG Membership zajednicu.\n"
  . "\nSrdačan pozdrav,\n"
  . "BERG Membership tim\n";

function esc(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$detailsHtml = '';
if (!empty($details)) {
  $items = '';
  foreach ($details as $d) {
    $items .= '<li style="margin:0 0 6px 0;">' . esc($d) . '</li>';
  }
  $detailsHtml = '
    <div style="margin:16px 0 0 0;">
      <div style="font-weight:600; margin:0 0 8px 0;">Detalji prijave:</div>
      <ul style="margin:0; padding-left:18px;">' . $items . '</ul>
    </div>';
}

$bodyHtml = '
<!doctype html>
<html lang="sr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body style="margin:0; padding:0; background:#f6f6f6;">
  <div style="max-width:680px; margin:0 auto; padding:24px;">
    <div style="background:#ffffff; border-radius:14px; padding:28px; font-family:Arial, Helvetica, sans-serif; color:#111; line-height:1.6;">
      <p style="margin:0 0 14px 0; font-size:16px;">' . esc($greetingLine) . '</p>

      <p style="margin:0 0 14px 0; font-size:15px;">
        Ovim putem potvrđujemo da je započeta obrada Vaše porudžbine za članarinu <strong>BERG Membership</strong> za 2026. godinu.
      </p>

      <p style="margin:0 0 14px 0; font-size:15px;">
        Vaše članstvo, zajedno sa svim pripadajućim benefitima, biće aktivirano u ponoć prvog narednog dana nakon evidentiranja i proknjiženja uplate na našem računu, u skladu sa važećim procedurama.
      </p>

      ' . $detailsHtml . '

      <div style="margin:18px 0 0 0; padding:16px; background:#fafafa; border:1px solid #eee; border-radius:12px;">
        <div style="font-weight:700; margin:0 0 10px 0;">Podaci za uplatu članarine (BERG)</div>
        <div style="font-size:14px;">
          <div><strong>Naziv primaoca:</strong> BERG</div>
          <div><strong>Matični broj:</strong> 28407866</div>
          <div><strong>PIB:</strong> 115431587</div>
          <div><strong>Banka:</strong> Banca Intesa a.d. Beograd</div>
          <div><strong>Broj računa:</strong> 160-6000002499382-03</div>
          <div><strong>Adresa:</strong> Balkanska 18, Beograd (Stari grad)</div>
          <div style="margin-top:8px;"><strong>Iznos:</strong> ' . $selectedPrice . ' EUR u dinarskoj protivvrednosti, po srednjem kursu Narodne banke Srbije (NBS) na dan uplate</div>
        </div>
      </div>

      <div style="margin:18px 0 0 0;">
        <div style="font-weight:600; margin:0 0 8px 0;">Po uspešno evidentiranoj uplati, na ovu e-mail adresu biće Vam dostavljeno sledeće:</div>
        <ul style="margin:0; padding-left:18px;">
          <li style="margin:0 0 6px 0;">fiskalni račun,</li>
          <li style="margin:0 0 6px 0;">digitalna Alpenverein članska karta,</li>
          <li style="margin:0 0 6px 0;">kompletna prateća dokumentacija u PDF formatu,</li>
          <li style="margin:0 0 6px 0;">pristupni podaci i detaljno uputstvo za korišćenje BERG Member portala.</li>
        </ul>
      </div>

      <p style="margin:18px 0 14px 0; font-size:15px;">
        Ukoliko imate dodatna pitanja, potrebu za pojašnjenjem ili tehničku podršku u vezi sa uplatom ili članstvom, naš tim Vam stoji na raspolaganju.
      </p>

      <p style="margin:0 0 18px 0; font-size:15px;">
        Zahvaljujemo se na ukazanom poverenju i dobrodošli u BERG Membership zajednicu.
      </p>

      <p style="margin:0 0 6px 0; font-size:15px;">Srdačan pozdrav,</p>
      <p style="margin:0; font-size:15px; font-weight:700;">BERG Membership tim</p>

      <div style="margin-top:16px; padding-top:14px; border-top:1px solid #eee; font-size:12px; color:#666;">
        Za dodatna pitanja možete odgovoriti na ovaj email: <a href="mailto:info@bergmembership.com" style="color:#111; text-decoration:underline;">info@bergmembership.com</a>
      </div>
    </div>

    <div style="text-align:center; font-family:Arial, Helvetica, sans-serif; color:#777; font-size:12px; padding:12px 8px;">
      © ' . date('Y') . ' BERG Membership
    </div>
  </div>
</body>
</html>';

// 7) SMTP slanje
$fromEmail = 'info@bergmembership.com';
$fromName  = 'BERG Membership';

$smtpHost = 'mail.bergmembership.com';
$smtpUser = 'info@bergmembership.com';
$smtpPass = 'Gqk2berpxD'; // privremeno ubaci, ali posle prebaci u env
$smtpPort = 465;

$sent = false;

try {
  $m = new PHPMailer(true);
  $m->CharSet = 'UTF-8';

  $m->isSMTP();
  $m->Host = $smtpHost;
  $m->SMTPAuth = true;
  $m->Username = $smtpUser;
  $m->Password = $smtpPass;
  $m->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
  $m->Port = $smtpPort;

  $m->setFrom($fromEmail, $fromName);
  $m->addAddress($email);
  $m->addReplyTo($fromEmail, $fromName);

  $m->Subject = $subject;
  $m->isHTML(true);
  $m->Body    = $bodyHtml;
  $m->AltBody = $bodyText;

  $m->send();
  $sent = true;

} catch (Exception $e) {
  error_log('BERG autoresponder SMTP FAILED: ' . $e->getMessage());
  $sent = false;
}

if ($sent) {
  @file_put_contents($dedupeFile, $dedupeKey . "\n", FILE_APPEND);
}

http_response_code(200);
echo json_encode(['ok' => true, 'sent' => $sent]);
