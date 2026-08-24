<?php
include("./db.php");

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $db->prepare("DELETE FROM kamers WHERE id = :id");
    $stmt->execute([':id' => $id]);
    header("Location: admin-kamers.php");
    exit;
}

$query = $db->query("SELECT * FROM kamers");
$kamers = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Kamerbeheer</title>
</head>
<body>
    <?php include("includes/nav.php"); ?>

    <main class="main-content">
        <div class="admin-container">
            <h1 class="menu-top">Kamerbeheer</h1>
            <a href="kamer-form.php" class="admin-btn-add">Nieuwe Kamer Toevoegen</a>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Afbeelding</th>
                        <th>Titel</th>
                        <th>Prijs</th>
                        <th>Beschrijving</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kamers as $row): ?>
                    <tr>
                        <td><img src="img/<?php echo htmlspecialchars($row['afbeelding']); ?>" class="admin-table-img" alt="Kamer"></td>
                        <td><?php echo htmlspecialchars($row['titel']); ?></td>
                        <td><?php echo htmlspecialchars($row['prijs']); ?></td>
                        <td><?php echo htmlspecialchars($row['beschrijving']); ?></td>
                        <td>
                            <a href="kamer-form.php?edit=<?php echo $row['id']; ?>">Bewerken</a> | 
                            <a href="admin-kamers.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Zeker weten?')">Verwijderen</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php include("includes/footer.php"); ?>
</body>
</html>