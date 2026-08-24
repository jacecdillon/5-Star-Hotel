<?php
session_start();
require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Home</title>
    <?php include("includes/nav.php"); ?>
</head>

<body>
    <main class="main-about">
        <div class="home-welkom">
            <h1>Welkom bij Hotel De Zonne Vallei</h1>
            <p>Ontsnap aan de dagelijkse drukte en ontdek de rust en luxe van Hotel De Zonne Vallei, een 3-duimen hotel gelegen in het hart van Alkmaar. Ons hotel biedt een perfecte mix van comfort, gastvrijheid en adembenemende natuur. Of u nu voor een romantisch uitje, een familievakantie of een zakelijke bijeenkomst komt, ons hotel heeft precies wat u nodig heeft voor een onvergetelijk verblijf.</p>
        </div>
        <div>
            <a class="boekknop" href="rooms.php">Bekijk Kamers</a>
        </div>
    </main>

    <div class="home-info">
        <div class="info-home">
            <div>
                <img src="./img/Kamers.jpg.jpg">
            </div>
            <div class="info-text">
                <h2>Ontdek Onze Kamers</h2>
                <p>Of u nu op zoek bent naar een romantisch uitje, een familievakantie of een zakelijke bijeenkomst, onze stijlvolle en goed uitgeruste kamers bieden alles wat u nodig heeft voor een onvergetelijk verblijf. Geniet van moderne voorzieningen, comfortabele bedden en een prachtig uitzicht op de omgeving.</p>
                <a class="infoknop" href="rooms.php">Bekijk Kamers</a>
            </div>
        </div>

        <div class="info-home">
            <div>
                <img src="./img/restaurant.jpg">
            </div>
            <div class="info-text">
                <h2>Culinaire Verwennerij</h2>
                <p>Laat uw smaakpapillen prikkelen in ons restaurant, waar onze chef-kok met passie lokale ingrediënten omtovert tot culinaire meesterwerken. Van een uitgebreid ontbijt tot een intiem diner, elke maaltijd is een ervaring op zich. Ontdek ons menu en geniet van de smaken van Alkmaar.</p>
                <a class="infoknop" href="restaurant.php">Ontdek Het Menu</a>
            </div>
        </div>
        <div class="info-home">
            <div>
                <img src="./img/alkmaar.jpg">
            </div>
            <div class="info-text">
                <h2>Ontdek de Omgeving</h2>
                <p>Hotel De Zonne Vallei ligt in het bruisende hart van Alkmaar, een stad die rijk is aan geschiedenis en cultuur. Verken de pittoreske straatjes, bewonder de eeuwenoude architectuur en bezoek de wereldberoemde kaasmarkt. Of u nu winkelt in de boetiekjes, geniet van een drankje op een van de vele terrassen of een ontspannen wandeling maakt langs de grachten, Alkmaar biedt voor ieder wat wils. Ontdek de schoonheid en charme van deze historische stad tijdens uw verblijf in ons hotel.</p>
                <a class="infoknop" href="about.php">Meer Over Ons</a>
            </div>
        </div>
    </div>
    <?php include("includes/footer.php"); ?>
</body>

</html>