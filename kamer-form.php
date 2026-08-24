<?php
include("./db.php");

$id = 0;
$titel = "";
$beschrijving = "";
$prijs = "";
$afbeelding = "";
$soort = "";
$is_edit = false;

if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $is_edit = true;
    
    $stmt = $db->prepare("SELECT * FROM kamers WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        $titel = $data['titel'];
        $beschrijving = $data['beschrijving'];
        $prijs = $data['prijs'];
        $soort = $data['soort'];
        $afbeelding = $data['afbeelding'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titel = $_POST['titel'];
    $beschrijving = $_POST['beschrijving'];
    $prijs = $_POST['prijs'];
    $soort = $_POST['soort'];
    $post_id = intval($_POST['id']);
    
    $afbeelding = $_POST['bestaande_afbeelding'] ?? '';

    if (isset($_FILES['afbeelding']) && $_FILES['afbeelding']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['afbeelding']['tmp_name'];
        $fileName = $_FILES['afbeelding']['name'];
        
        $nieuweBestandsNaam = time() . '_' . $fileName;
        
        $uploadMap = './img/';
        
        if (!is_dir($uploadMap)) {
            mkdir($uploadMap, 0755, true);
        }

        $dest_path = $uploadMap . $nieuweBestandsNaam;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $afbeelding = $nieuweBestandsNaam;
        }
    }

    if ($post_id > 0) {
        $sql = "UPDATE kamers SET titel = :titel, soort = :soort, beschrijving = :beschrijving, prijs = :prijs, afbeelding = :afbeelding WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':titel' => $titel,
            ':beschrijving' => $beschrijving,
            ':prijs' => $prijs,
            ':afbeelding' => $afbeelding,
            ':id' => $post_id,
            ':soort' => $soort
        ]);
    } else {
        $sql = "INSERT INTO kamers (titel, beschrijving, prijs, afbeelding) VALUES (:titel, :beschrijving, :prijs, :afbeelding)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':titel' => $titel,
            ':beschrijving' => $beschrijving,
            ':prijs' => $prijs,
            ':afbeelding' => $afbeelding,
            ':soort' => $soort
        ]);
    }

    header("Location: admin-kamers.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title><?php echo $is_edit ? "Kamer Bewerken" : "Kamer Toevoegen"; ?></title>
</head>
<body>
    <?php include("includes/nav.php"); ?>

    <main class="main-content">
        <div class="admin-form-container">
            <h1 class="menu-top"><?php echo $is_edit ? "Kamer Bewerken" : "Kamer Toevoegen"; ?></h1>
            
            <form method="POST" action="kamer-form.php" class="admin-form" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="bestaande_afbeelding" value="<?php echo htmlspecialchars($afbeelding); ?>">
                
                <div class="form-group">
                    <label for="titel">Titel</label>
                    <input type="text" id="titel" name="titel" value="<?php echo htmlspecialchars($titel); ?>" required>
                </div>

                <div class="form-group">
                    <label for="soort">Type kamers</label>
                    <input type="number" id="soort" name="soort" value="<?php echo htmlspecialchars($soort); ?>" required>
                </div>

                <div class="form-group">
                    <label for="beschrijving">Beschrijving</label>
                    <textarea id="beschrijving" name="beschrijving" required><?php echo htmlspecialchars($beschrijving); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="prijs">Prijs per nacht</label>
                    <input type="number" id="prijs" step="0.01" name="prijs" value="<?php echo htmlspecialchars($prijs); ?>" required>
                </div>

                <div class="form-group">
                    <label for="afbeelding">Kies afbeelding</label>
                  <input type="file" id="afbeelding" name="afbeelding" accept="image/*">
                    
                    <?php if ($is_edit && !empty($afbeelding)): ?>
                        <p>
                            Huidige afbeelding<?php echo htmlspecialchars($afbeelding); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="form-actions">
                    <a href="admin-kamers.php" class="admin-cancel-btn">Annuleren</a>
                    <button type="submit" class="admin-submit-btn">
                        <?php echo $is_edit ? "Opslaan" : "Toevoegen"; ?>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <?php include("includes/footer.php"); ?>
</body>
</html>