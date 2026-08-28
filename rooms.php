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
    <title>Onze Kamers</title>
</head>

<body>
    <?php include("includes/nav.php"); ?>

    <main class="main-content">
        <h1 class="page-title">Onze Kamers</h1>
        
        <div class="kamers-grid">
            <?php foreach ($kamers as $kamer): ?>
                <div class="kamer-kaart <?php echo ($kamer['aantal'] <= 0) ? 'uitverkocht' : ''; ?>">
                    <div class="kamer-afbeelding">
                        <img src="img/<?php echo htmlspecialchars($kamer['afbeelding']); ?>"
                             alt="<?php echo htmlspecialchars($kamer['titel']); ?>">
                    </div>

                    <div class="kamer-info"> 
                        <span class="kamer-soort"><?php echo htmlspecialchars($kamer['soort']); ?></span>
                        <h2><?php echo htmlspecialchars($kamer['titel']); ?></h2>
                        <p class="kamer-beschrijving"><?php echo htmlspecialchars($kamer['beschrijving']); ?></p>

                        <div class="beschikbaarheid-status">
                            <?php if ($kamer['aantal'] > 0): ?>
                                <span class="badge in-stock">Nog <?php echo $kamer['aantal']; ?> beschikbaar</span>
                            <?php else: ?>
                                <span class="badge out-of-stock">Volgeboekt</span>
                            <?php endif; ?>
                        </div>

                        <div class="kamer-footer">
                            <span class="prijs">€<?php echo number_format($kamer['prijs'], 2, ',', '.'); ?> <span>/ nacht</span></span>
                            
                            <?php if ($kamer['aantal'] > 0): ?>
                                <a href="book.php?id=<?php echo $kamer['id']; ?>" class="boek-btn">Boek nu</a>
                            <?php else: ?>
                                <button class="boek-btn disabled" disabled>Volgeboekt</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include("includes/footer.php"); ?>
</body>
</html>