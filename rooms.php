<?php
session_start();
require_once 'db.php';

$query = $db->query("SELECT * FROM kamers");
$kamers = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>Onze Kamers</title>
=======
    <title>Kamers</title>
>>>>>>> 694fbe059158aa0d0a1fb872ea92b79ae8c4ecc3
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
                            <span class="prijs">€<?php echo htmlspecialchars($kamer['prijs']); ?> <span>/ nacht</span></span>
                            <a href="book.php?id=<?php echo $kamer['id']; ?>" class="boek-btn">Boek nu</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include("includes/footer.php"); ?>
</body>
</html>