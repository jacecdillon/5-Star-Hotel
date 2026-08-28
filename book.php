<?php
session_start();
require_once 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: rooms.php");
    exit;
}

$kamer_id = intval($_GET['id']);

$stmt = $db->prepare("SELECT * FROM kamers WHERE id = :id");
$stmt->execute([':id' => $kamer_id]);
$kamer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$kamer) {
    echo "Kamer niet gevonden.";
    exit;
}

$succesmelding = "";
$foutmelding = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = trim($_POST['naam']);
    $email = trim($_POST['email']);
    $check_in = $_POST['check_in'];
    $check_uit = $_POST['check_uit'];

    $vandaag = date('Y-m-d');

    $domain = substr(strrchr($email, "@"), 1);

    if ($kamer['aantal'] <= 0) {
        $foutmelding = "Helaas, deze kamer is zojuist volgeboekt.";
    } else if (empty($naam) || empty($email) || empty($check_in) || empty($check_uit)) {
        $foutmelding = "Vul alstublieft alle velden in.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $foutmelding = "Vul een geldig e-mailadres in.";
    } else if (!checkdnsrr($domain, "MX")) {
        $foutmelding = "Het domein van dit e-mailadres (@" . htmlspecialchars($domain) . ") bestaat niet of kan geen e-mail ontvangen.";
    } else if ($check_in < $vandaag) {
        $foutmelding = "De check-in datum kan niet in het verleden liggen.";
    } else if ($check_uit <= $check_in) {
        $foutmelding = "De check-uit datum moet na de check-in datum liggen.";
    } else {
        $boekingStmt = $db->prepare("INSERT INTO boeking (kamer_id, naam, email, check_in, check_uit) VALUES (:kamer_id, :naam, :email, :check_in, :check_uit)");
        $boekingStmt->execute([
            ':kamer_id' => $kamer_id,
            ':naam'     => $naam,
            ':email'    => $email,
            ':check_in' => $check_in,
            ':check_uit'=> $check_uit
        ]);
        $updateStmt = $db->prepare("UPDATE kamers SET aantal = aantal - 1 WHERE id = :id AND aantal > 0");
        $updateStmt->execute([':id' => $kamer_id]);

        $kamer['aantal'] -= 1;

        $succesmelding = "Bedankt " . htmlspecialchars($naam) . "! Je boeking voor de " . htmlspecialchars($kamer['titel']) . " is ontvangen.";
    }

}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/book.css">
    <title>Boek <?php echo htmlspecialchars($kamer['titel']); ?></title>
</head>
<body>
    <?php include("includes/nav.php"); ?>

    <main class="main-book">
        <div class="booking-container">
            
            <div class="booking-details">
                <img src="img/<?php echo htmlspecialchars($kamer['afbeelding']); ?>" alt="<?php echo htmlspecialchars($kamer['titel']); ?>">
                <span class="kamer-soort"><?php echo htmlspecialchars($kamer['soort']); ?></span>
                <h1><?php echo htmlspecialchars($kamer['titel']); ?></h1>
                <p><?php echo htmlspecialchars($kamer['beschrijving']); ?></p>
                <div class="booking-price">
                    Prijs: <strong>€<?php echo number_format($kamer['prijs'], 2, ',', '.'); ?></strong> / nacht
                </div>
                <div class="booking-stock">
                    <strong>Beschikbaar:</strong> <?php echo htmlspecialchars($kamer['aantal']); ?> kamer(s)
                </div>
            </div>

            <div class="booking-form-wrapper">
                <h2>Reserveer deze kamer</h2>

                <?php if ($succesmelding): ?>
                    <div class="alert alert-success">
                        <p><?php echo $succesmelding; ?></p>
                        <a href="rooms.php" class="boek-btn">Terug naar alle kamers</a>
                    </div>
                <?php else: ?>
                    <?php if ($foutmelding): ?>
                        <div class="alert alert-error"><?php echo $foutmelding; ?></div>
                    <?php endif; ?>

                    <?php if ($kamer['aantal'] > 0): ?>
                        <form method="POST" action="" class="booking-form">
                            <div class="form-group">
                                <label for="naam">Volledige naam</label>
                                <input type="text" id="naam" name="naam" required placeholder="Ben Dover" value="<?php echo isset($_POST['naam']) ? htmlspecialchars($_POST['naam']) : ''; ?>">
                            </div>

                            <div class="form-group">
                                <label for="email">E-mailadres</label>
                                <input type="email" id="email" name="email" required placeholder="BenDover@gmail.com" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                            </div>

                            <div class="form-group">
                                <label for="check_in">Check-in datum</label>
                                <input type="date" id="check_in" name="check_in" required value="<?php echo isset($_POST['check_in']) ? htmlspecialchars($_POST['check_in']) : ''; ?>">
                            </div>

                            <div class="form-group">
                                <label for="check_uit">Check-uit datum</label>
                                <input type="date" id="check_uit" name="check_uit" required value="<?php echo isset($_POST['check_uit']) ? htmlspecialchars($_POST['check_uit']) : ''; ?>">
                            </div>

                            <button type="submit" class="boek-btn submit-btn">Boeking Bevestigen</button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-error">Deze kamer is helaas volgeboekt. Reserveren is niet meer mogelijk.</div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

        </div>
    </main>

    <?php include("includes/footer.php"); ?>
</body>
</html>