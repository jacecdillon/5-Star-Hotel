<?php
session_start();
require 'db.php';

include("./db.php");

$query = $db->query("SELECT * FROM kamers");
$kamers = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kamers</title>
</head>

<body>
    <?php include("includes/nav.php"); ?>

    <main class="main-content">
        <h1 class="page-title">Onze Kamers</h1>
             <div class="kamers-grid">
            <?php foreach ($kamers as $kamer): ?>

            <div class="kamer-kaart">
                <div class="kamer-afbeelding">
                    <img src="img/<?php echo htmlspecialchars($kamer['afbeelding']); ?>"
                    alt="<?php echo htmlspecialchars($kamer['titel']); ?>">
                </div>

                <div class="kamer-info"> 
                    <span class="kamer-soort"><?php echo htmlspecialchars($kamer['soort']); ?></span>
                    <h2><?php echo htmlspecialchars($kamer['titel']); ?></h2>
                    <p class="kamer-beschrijving"><?php echo htmlspecialchars($kamer['beschrijving']); ?></p>

                     <div class="kamer-footer">
                        <span class="prijs">$<?php echo htmlspecialchars($kamer['prijs']); ?><span> /nacht </span></span>
                        <a href="contact.php">Contact</a>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
    </main>

    <?php include("includes/footer.php"); ?>
</body>

</html>