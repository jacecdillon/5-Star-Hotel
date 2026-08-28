<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer-master/src/SMTP.php';

function maakMailer(): PHPMailer {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'bakulakun6969@gmail.com';
    $mail->Password   = 'kpqxzqwfaukmaitp';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';

    return $mail;
}

function stuurBevestigingsmail(
    string $email,
    string $naam,
    string $kamer,
    string $check_in,
    string $check_uit,
    float $prijs
): bool {
    try {
        $mail = maakMailer();

        $mail->setFrom('bakulakun6969@gmail.com', 'Hotel De Zonne Vallei');
        $mail->addAddress($email, $naam);

        $mail->isHTML(true);
        $mail->Subject = 'Bevestiging van je boeking - Hotel De Zonne Vallei';

        $mail->Body = '
        <h1>Bedankt voor je boeking!</h1>
        <p>Beste ' . htmlspecialchars($naam) . ',</p>
        <p>Je boeking bij <strong>Hotel De Zonne Vallei</strong> is succesvol ontvangen.</p>

        <h2>Boekingsgegevens</h2>
        <p><strong>Kamer:</strong> ' . htmlspecialchars($kamer) . '</p>
        <p><strong>Check-in:</strong> ' . htmlspecialchars($check_in) . '</p>
        <p><strong>Check-uit:</strong> ' . htmlspecialchars($check_uit) . '</p>
        <p><strong>Prijs per nacht:</strong> €' . number_format($prijs, 2, ',', '.') . '</p>

        <hr>

        <p>We kijken ernaar uit je te verwelkomen!</p>
        <p>Met vriendelijke groet,<br>
        <strong>Hotel De Zonne Vallei</strong></p>
        ';

        $mail->AltBody =
            "Beste $naam,\n\n" .
            "Je boeking bij Hotel De Zonne Vallei is succesvol ontvangen.\n\n" .
            "Kamer: $kamer\n" .
            "Check-in: $check_in\n" .
            "Check-uit: $check_uit\n" .
            "Prijs per nacht: €" . number_format($prijs, 2, ',', '.') . "\n\n" .
            "We kijken ernaar uit je te verwelkomen!\n\n" .
            "Hotel De Zonne Vallei";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("PHPMailer Fout: " . $e->getMessage());
        return false;
    }
}

function stuurContactmail(
    string $voornaam,
    string $achternaam,
    string $email,
    string $onderwerp,
    string $bericht
): bool {
    try {
        $mail = maakMailer();

        $mail->setFrom('bakulakun6969@gmail.com', 'Contactformulier - Hotel De Zonne Vallei');
        $mail->addAddress('bakulakun6969@gmail.com', 'Hotel De Zonne Vallei');
        $mail->addReplyTo($email, $voornaam . ' ' . $achternaam);

        $mail->isHTML(true);
        $mail->Subject = 'Nieuw bericht ' . $onderwerp;

        $mail->Body = '
        <h2>Nieuw bericht via het contactformulier</h2>
        <p><strong>Naam:</strong> ' . htmlspecialchars($voornaam) . ' ' . htmlspecialchars($achternaam) . '</p>
        <p><strong>E-mailadres:</strong> ' . htmlspecialchars($email) . '</p>
        <p><strong>Onderwerp:</strong> ' . htmlspecialchars($onderwerp) . '</p>
        <hr>
        <p><strong>Bericht:</strong></p>
        <p>' . nl2br(htmlspecialchars($bericht)) . '</p>
        ';

        $mail->AltBody = 
            "Nieuw contactbericht\n\n" .
            "Naam: $voornaam $achternaam\n" .
            "E-mail: $email\n" .
            "Onderwerp: $onderwerp\n\n" .
            "Bericht:\n$bericht";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("PHPMailer Fout: " . $e->getMessage());
        return false;
    }
}