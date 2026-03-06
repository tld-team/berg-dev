<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
  http_response_code(405);
  exit('Method Not Allowed');
}

require __DIR__ . '/vendor/autoload.php';

// Load .env if present
if (class_exists(\Dotenv\Dotenv::class) && file_exists(__DIR__ . '/.env')) {
  \Dotenv\Dotenv::createImmutable(__DIR__)->safeLoad();
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function post_str(string $key, int $maxLen = 200): string {
  $v = (string)($_POST[$key] ?? '');
  $v = trim($v);
  if ($v === '') return '';
  if (mb_strlen($v) > $maxLen) $v = mb_substr($v, 0, $maxLen);
  return $v;
}

function post_arr(string $key): array {
  $v = $_POST[$key] ?? [];
  return is_array($v) ? $v : [];
}

function env_str(string $key, string $default = ''): string {
  $v = getenv($key);
  if ($v === false) return $default;
  $v = trim($v);
  return $v === '' ? $default : $v;
}

/** ---------------------------
 *  CONFIG
 *  -------------------------- */
$membershipYear = '2026';

// Admin copy
$adminEmail = 'member@bergmembership.com';

// SMTP (iz tvoje slike)
$smtpHost   = 'mail.bergmembership.com';
$smtpPort   = 465; // SMTPS
$smtpUser   = 'member@bergmembership.com';
$smtpPass   = env_str('BERG_SMTP_PASS', ''); // <- postavi na hostingu
$smtpSecure = PHPMailer::ENCRYPTION_SMTPS;

// From / Reply-To
// Najsigurnije: šalji sa mailbox-a koji stvarno postoji (member@),
// a Reply-To neka bude info@
$fromEmail  = $smtpUser;
$fromName   = 'BERG Membership';
$replyTo    = 'info@bergmembership.com';

// Bank details (placeholder, menjaš kad budeš imao prave)
$bank = [
  'iban'      => 'SK6583300000002402107117',
  'price_eur' => '79',
  'recipient' => 'Alpenverein',
  'reference' => '142187',
  'bank'      => 'FIO',
  'swift'     => 'FIOBCZPPXXX',
];

if ($smtpPass === '') {
  http_response_code(500);
  exit('SMTP password is missing. Set env var BERG_SMTP_PASS.');
}

/** ---------------------------
 *  READ + VALIDATE INPUT
 *  -------------------------- */
$selectedPlan   = post_str('selected_plan', 50);   // explorer | family
$selectedOption = post_str('selected_option', 80); // adult/senior... ili couple/single

$firstName  = post_str('first_name', 60);
$lastName   = post_str('last_name', 60);
$birthYear  = post_str('birth_year', 4);
$birthMonth = post_str('birth_month', 15);
$birthDay   = post_str('birth_day', 2);
$gender     = post_str('gender', 10);

$email = post_str('email', 120);
$phone = post_str('phone', 40);

$street      = post_str('street', 120);
$houseNumber = post_str('house_number', 20);
$city        = post_str('city', 80);
$zip         = post_str('zip', 20);
$country     = post_str('country', 40);

if ($selectedPlan === '' || $selectedOption === '') {
  http_response_code(400);
  exit('Missing plan/option. Make sure JS fills selected_plan and selected_option.');
}
if ($firstName === '' || $lastName === '' || $birthYear === '' || $birthMonth === '' || $birthDay === '' || $gender === '') {
  http_response_code(400);
  exit('Missing personal data.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  exit('Invalid email.');
}
if ($phone === '' || $street === '' || $houseNumber === '' || $city === '' || $zip === '' || $country === '') {
  http_response_code(400);
  exit('Missing contact/address.');
}

/** Category label mapping (da u mail-u piše kao na sajtu) */
$explorerLabels = [
  'adult' => 'Adult (birth 1998 - 1962)',
  'senior' => 'Senior (birth 1961 and older)',
  'junior' => 'Junior (birth 1999 - 2007)',
  'mountain_rescuer' => 'Mountain rescuer',
  'child' => 'Child (birth 2008 and younger)',
  'disabled' => 'Disabled (over 50% and including 50%)',
];

$familyLabels = [
  'couple' => 'Married couple or partners (children free)',
  'single' => 'Single parent with children (divorced, widowed, etc.)',
];

$categoryLabel = $selectedOption;
if ($selectedPlan === 'explorer' && isset($explorerLabels[$selectedOption])) {
  $categoryLabel = $explorerLabels[$selectedOption];
}
if ($selectedPlan === 'family' && isset($familyLabels[$selectedOption])) {
  $categoryLabel = $familyLabels[$selectedOption];
}

$memberFullName = trim($firstName . ' ' . $lastName);

/** Optional: partner + children for family */
$partnerFirst = post_str('partner_first_name', 60);
$partnerLast  = post_str('partner_last_name', 60);

$childFirstNames = post_arr('child_first_name');
$childLastNames  = post_arr('child_last_name');

/** QR (EPC SEPA) text */
$amountEur = number_format((float)$bank['price_eur'], 2, '.', '');
$epc = "BCD\n002\n1\nSCT\n{$bank['swift']}\n{$bank['recipient']}\n{$bank['iban']}\nEUR{$amountEur}\n\n{$bank['reference']}\nMembership {$membershipYear} - {$memberFullName}\n";

/** ---------------------------
 *  BUILD CUSTOMER EMAIL
 *  -------------------------- */
$subject = "BERG Membership - Payment instructions ({$membershipYear})";

$lines = [];
$lines[] = "Hi {$firstName},";
$lines[] = "We confirm the processing of your order for membership year {$membershipYear}. The insurance will become effective at midnight on the day following the transfer of your payment to our account.";
$lines[] = "";
$lines[] = "Your payment details:";
$lines[] = "IBAN: {$bank['iban']}";
$lines[] = "Price: {$bank['price_eur']} EUR";
$lines[] = "Recipient: {$bank['recipient']}";
$lines[] = "Reference: {$bank['reference']}";
$lines[] = "Bank: {$bank['bank']} / SWIFT: {$bank['swift']}";
$lines[] = "";
$lines[] = "A notification about the inability to verify the account name may appear during payment. This is because the full name exceeds the SEPA system’s technical limits and does not fit entirely into the field. You can safely ignore this notification.";
$lines[] = "";
$lines[] = "QR Payment (EPC/SEPA):";
$lines[] = $epc;
$lines[] = "";
$lines[] = "Category: {$categoryLabel}";
$lines[] = "Member: {$memberFullName}";
$lines[] = "Address for delivery of membership card:";
$lines[] = "Recipient: {$memberFullName}";
$lines[] = "Street: {$street}";
$lines[] = "House number: {$houseNumber}";
$lines[] = "City: {$city}";
$lines[] = "ZIP: {$zip}";
$lines[] = "Country: {$country}";
$lines[] = "";

if ($selectedPlan === 'family') {
  $partnerName = trim($partnerFirst . ' ' . $partnerLast);
  if ($partnerName !== '') {
    $lines[] = "Partner: {$partnerName}";
  }

  $count = max(count($childFirstNames), count($childLastNames));
  $childrenOut = [];
  for ($i = 0; $i < $count; $i++) {
    $cf = trim((string)($childFirstNames[$i] ?? ''));
    $cl = trim((string)($childLastNames[$i] ?? ''));
    $cn = trim($cf . ' ' . $cl);
    if ($cn !== '') $childrenOut[] = $cn;
  }
  if (!empty($childrenOut)) {
    $lines[] = "Children:";
    foreach ($childrenOut as $cn) {
      $lines[] = "- {$cn}";
    }
  }
  $lines[] = "";
}

$lines[] = "If you would like to change the address, please let us know right away by replying to this email.";
$lines[] = "Thank you,";
$lines[] = "Best regards, The BERG Membership team";
$lines[] = "email: {$replyTo}";
$lines[] = "";
$lines[] = ":::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::";
$lines[] = "Legal notice: This email and any attached files are confidential and may be protected by law. If you are not the intended recipient, any form of publishing, reproducing, copying, distributing, or forwarding is strictly prohibited. If you received this email in error, please notify us and then delete it.";

$bodyText = implode("\r\n", $lines);

/** ---------------------------
 *  SEND EMAIL
 *  -------------------------- */
try {
  $mail = new PHPMailer(true);
  $mail->CharSet = 'UTF-8';

  $mail->isSMTP();
  $mail->Host       = $smtpHost;
  $mail->SMTPAuth   = true;
  $mail->Username   = $smtpUser;
  $mail->Password   = $smtpPass;
  $mail->Port       = $smtpPort;
  $mail->SMTPSecure = $smtpSecure;

  $mail->setFrom($fromEmail, $fromName);
  $mail->addReplyTo($replyTo, $fromName);

  // korisnik
  $mail->addAddress($email, $memberFullName);

  // kopija adminu
  $mail->addBCC($adminEmail);

  $mail->Subject = $subject;
  $mail->Body    = $bodyText;
  $mail->AltBody = $bodyText;
  $mail->isHTML(false);

  $mail->send();

} catch (Exception $e) {
  http_response_code(500);
  exit('Mail error: ' . $e->getMessage());
}

header('Location: membership.php?sent=1');
exit;
