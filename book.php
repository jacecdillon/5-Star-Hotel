<?php
session_start();
require_once 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: book.php");
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

    if (!empty($naam) && !empty($email) && !empty($check_in) && !empty($check_uit)) {
        $succesmelding = "Bedankt $naam! Je boeking voor de " . htmlspecialchars($kamer['titel']) . " is ontvangen.";
    } else {
        $foutmelding = "Vul alstublieft alle velden in.";
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
                    Prijs: <strong>€<?php echo htmlspecialchars($kamer['prijs']); ?></strong> / nacht
                </div>
            </div>

            <div class="booking-form-wrapper">
                <h2>Reserveer deze kamer</h2>

                <?php if ($succesmelding): ?>
                    <div class="alert alert-success"><?php echo $succesmelding; ?></div>
                <?php endif; ?>

                <?php if ($foutmelding): ?>
                    <div class="alert alert-error"><?php echo $foutmelding; ?></div>
                <?php endif; ?>

                <form method="POST" action="" class="booking-form">
                    <div class="form-group">
                        <label for="naam">Volledige naam</label>
                        <input type="text" id="naam" name="naam" required placeholder="bijv. Ben Dover">
                    </div>

                    <div class="form-group">
                        <label for="email">E-mailadres</label>
                        <input type="email" id="email" name="email" required placeholder="bendover@gmail.com">
                    </div>

                    <div class="form-group">
                        <label for="check_in">Check-in datum</label>
                        <input type="date" id="check_in" name="check_in" required>
                    </div>

                    <div class="form-group">
                        <label for="check_uit">Check-uit datum</label>
                        <input type="date" id="check_uit" name="check_uit" required>
                    </div>

                    <button type="submit" class="boek-btn submit-btn">Boeking Bevestigen</button>
                </form>
            </div>

        </div>
    </main>

    <?php include("includes/footer.php"); ?>
</body>
</html>