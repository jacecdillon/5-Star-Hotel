<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/contact.css">
    <title>Contact</title>
    <?php include("includes/nav.php"); ?>
</head>
<body>

<main class="main-contact">
        <form class="contact-page" action="contact.php" method="post">
            <div class="contact-form">
                <h2>Contactformulier</h2>
                <div class="contact-name">
                    <div>
                        <p>Naam</p>
                        <input type="text" placeholder="Naam..."> 
                    </div>
                    <div>
                        <p>Achternaam</p>
                        <input type="text" placeholder="Achternaam...">
                    </div>
                </div>

                <div class="contact-email">
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
                    <input type="submit" value="Submit" class="contact-submit">
            </div>
        </form>
        <div class="contact-info">
            <div class="contact">
                <h3>E-mail:</h3>
                <h4>info@mysite.com</h4>
                <h3>Locatie:</h3>
                <h4>Straatnaam 123, 1234 AB Stad</h4>
                <h3>Nummer:</h3>
                <h4>Tel: 06-12345678</h4>
            </div>
        </div>
    </main>
    <?php include("includes/footer.php"); ?>
</body>
</html>