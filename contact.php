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

            <div class="name">
                <div>
                    <p>Naam</p>
                    <input type="text" placeholder="Naam..."> 
                </div>
                <div>
                    <p>Achternaam</p>
                    <input type="text" placeholder="Achternaam...">
                </div>
            </div>

            <div class="email">
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
            <input type="submit" value="Submit" class="submit">
        </form>
    </main>
    <?php include("includes/footer.php"); ?>
</body>
</html>