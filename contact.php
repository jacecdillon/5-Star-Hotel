<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
    <?php include("includes/nav.php"); ?>
</head>
<body>
    <main>
        <form class="contactpage">

            <div class=name>
            <p>Naam</p>
            <input type="text" placeholder="Naam"> 
            <p>Achternaam</p>
            <input type="text" placeholder="Achternaam">
            </div>

            <div class=email>
            <p>Email</p>
            <input type="email" placeholder="Email">
            <p>Onderwerp</p>
            <input type="text" placeholder="Subject">
            </div>
            <br>
            <textarea></textarea>
            <input type="submit" placeholder="Submit">
        </form>
    </main>
</body>
</html>