<?php require_once __DIR__ . '/roles.php'; ?>
<nav class="navbar">
<div class="nav-img">
<img src="img/logo.png" alt="logo" class="logo">
</div>
<div class="nav-links">
<a href="index.php">Home</a>
<a href="restaurant.php">Restaurant</a>
<a href="about.php">Over Ons</a>
<a href="contact.php">Contact</a>
<a class="boekknop" href="rooms.php">Boek Nu</a>
</div>
<div class="nav-rechts">
    <div class="nav-admin">
        <?php if (has_role('admin')): ?>
                <a href="admin-kamers.php">Beheer</a>
        <?php endif; ?>
    </div>
    <div class="nav-login">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a class="nav-cta" href="logout.php">Uitloggen</a>
        <?php else: ?>
            <a href="login.php">Inloggen</a>
        <?php endif; ?>
    </div>
</div>
</nav>