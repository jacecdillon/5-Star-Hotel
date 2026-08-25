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
    <title>Over Ons</title>
    <?php include("includes/nav.php"); ?>
</head>
<body>
    <main class="main-about">
        <div class="about">
            <div class="about-content">
            <h1>Welkom bij Hotel De Zonne Vallei</h1>
            <p>Bij Hotel De Zonne Vallei streven we ernaar om elke gast een onvergetelijke ervaring te bieden, doordrenkt met luxe, comfort en uitzonderlijke gastvrijheid. Gelegen in het hart van Alkmaar, biedt ons hotel de perfecte uitvalsbasis om deze historische en charmante stad te ontdekken.</p>
            </div>

            <div class="verhaal">
                 <h2>Ons Verhaal</h2>
            <p>Hotel De Zonne Vallei is opgericht door Bouke van Zon, een visionaire ondernemer met een passie voor gastvrijheid en een scherp oog voor detail. Met jarenlange ervaring in de horeca-industrie heeft Bouke zijn droom verwezenlijkt om een uniek hotel te creëren waar gasten zich thuis voelen en kunnen genieten van alle gemakken en luxe die het leven te bieden heeft.</p>
            </div>

            <div class="overig">
                <h2>Onze Waarden</h2>
                <p>Bij Hotel De Zonne Vallei staan kwaliteit, gastvrijheid en persoonlijke service centraal. Wij geloven dat elk detail bijdraagt aan een perfecte ervaring, van de smaakvolle inrichting van onze kamers tot de culinaire hoogstandjes in ons restaurant. Ons toegewijde team staat altijd klaar om aan al uw wensen te voldoen en ervoor te zorgen dat uw verblijf zo aangenaam mogelijk is.</p>

                <h2>Ons Team</h2>
                <p>Ons team van enthousiaste en professionele medewerkers deelt de visie van Bouke van Zon om elke gast een warm welkom en een onvergetelijk verblijf te bieden. Van de receptie tot het restaurant en de huishouding, elk teamlid speelt een cruciale rol in het creëren van de unieke sfeer en ervaring waar Hotel De Zonne Vallei om bekend staat.</p>
            </div>

        </div>
    </main>
    <?php include("includes/footer.php"); ?>
</body>
</html>