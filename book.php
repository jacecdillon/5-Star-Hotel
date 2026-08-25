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
    <title>Document</title>
</head>

<body>
    <?php include("includes/nav.php"); ?>

    <main class="main-content">
        
    </main>

    <?php include("includes/footer.php"); ?>
</body>

</html>