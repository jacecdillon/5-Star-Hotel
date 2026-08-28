<?php
session_start();
require_once 'db.php';
require_once 'mail.php';

$succesmelding = "";
$foutmelding = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voornaam   = trim($_POST['voornaam'] ?? '');
    $achternaam = trim($_POST['achternaam'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $onderwerp  = trim($_POST['onderwerp'] ?? '');
    $bericht    = trim($_POST['bericht'] ?? '');

    $domain = substr(strrchr($email, "@"), 1);

    if (empty($voornaam) || empty($achternaam) || empty($email) || empty($onderwerp) || empty($bericht)) {
        $foutmelding = "Vul alstublieft alle velden in.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $foutmelding = "Vul een geldig e-mailadres in.";
    } else if (!checkdnsrr($domain, "MX")) {
        $foutmelding = "Het e-maildomein bestaat niet of kan geen e-mail ontvangen.";
    } else {
        $stmt = $db->prepare("INSERT INTO contact_berichten (voornaam, achternaam, email, onderwerp, bericht) VALUES (:voornaam, :achternaam, :email, :onderwerp, :bericht)");
        $dbOpslag = $stmt->execute([
            ':voornaam'   => $voornaam,
            ':achternaam' => $achternaam,
            ':email'      => $email,
            ':onderwerp'  => $onderwerp,
            ':bericht'    => $bericht
        ]);

        if ($dbOpslag) {
            $mailVerzonden = stuurContactmail($voornaam, $achternaam, $email, $onderwerp, $bericht);

            if ($mailVerzonden) {
                $succesmelding = "Bedankt $voornaam! Je bericht is opgeslagen en succesvol verzonden.";
            } else {
                $succesmelding = "Bedankt $voornaam! Je bericht is opgeslagen in ons systeem. (De bevestigingsmail kon helaas niet worden verzonden).";
            }
        } else {
            $foutmelding = "Er is iets misgegaan bij het opslaan van je bericht in de database. Probeer het later opnieuw.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/contact.css">
    <title>Contact</title>
    <?php include("includes/nav.php"); ?>
</head>
<body>

<main class="main-contact">
        <form class="contact-page"   method="post">
            <div class="contact-form">
                <h2>Contactformulier</h2>
                <div class="contact-name">  
                    <div>
                        <p>Naam</p>
                        <input type="text" placeholder="Naam..."> 
                    </div>
                    <div>
                        <p>Achternaam</p>
                        <input type="text" placeholder="Achternaam...">
                    </div>
                </div>

                <div class="contact-email">
                    <div>
                        <p>Email</p>
                        <input type="email" placeholder="Email...">
                    </div>
                    <div>
                        <p>Onderwerp</p>
                        <input type="text" placeholder="Onderwerp...">
                    </div>
                </div>
                    <p>Bericht</p>
                    <textarea placeholder="Bericht..."></textarea>
                    <input type="submit" value="Submit" class="contact-submit">
            </div>
        </form>
        <div class="contact-info">
            <div class="contact">
                <h3>E-mail:</h3>
                <h4>info@mysite.com</h4>
                <h3>Locatie:</h3>
                <h4>Straatnaam 123, 1234 AB Stad</h4>
                <h3>Nummer:</h3>
                <h4>Tel: 06-12345678</h4>
            </div>
        </div>
    </main>
    <?php include("includes/footer.php"); ?>
</body>
</html>