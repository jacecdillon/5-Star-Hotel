<?php
session_start();
require 'db.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $voornaam   = trim($_POST['voornaam'] ?? '');
    $achternaam = trim($_POST['achternaam'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $wachtwoord = $_POST['wachtwoord'] ?? '';
    $confirm    = $_POST['confirm_wachtwoord'] ?? '';

    if (
        empty($voornaam) || empty($achternaam) || empty($email) || empty($wachtwoord)
    ) {
        $error = "Vul alle velden in.";

    } elseif (!preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ\s\-]{1,50}$/', $voornaam)) {
        $error = "Voornaam mag alleen letters bevatten (max. 50 tekens).";
    } elseif (!preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ\s\-]{1,50}$/', $achternaam)) {
        $error = "Achternaam mag alleen letters bevatten (max. 50 tekens).";

    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d).{8,72}$/', $wachtwoord)) {
        $error = "Wachtwoord moet minimaal 8 tekens bevatten met minstens één letter en één cijfer.";
    } elseif ($wachtwoord !== $confirm) {
        $error = "Wachtwoorden komen niet overeen.";
    } else {
        try {
            $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->rowCount() > 0) {
                $error = "Dit e-mailadres is al geregistreerd.";
            } else {
                $hashed = password_hash($wachtwoord, PASSWORD_DEFAULT);

                $stmt = $db->prepare(
                    "INSERT INTO users (firstname, lastname, email, pass, is_admin) VALUES (?, ?, ?, ?, 0)"
                );
                $stmt->execute([$voornaam, $achternaam, $email, $hashed]);

                $newUserId = $db->lastInsertId();
                $_SESSION['user_id'] = $newUserId;
                $_SESSION['user_name'] = trim($voornaam . ' ' . $achternaam);
                $_SESSION['rol'] = 'leerling';

                header('Location: index.php');
                exit;
            }
        } catch (PDOException $e) {
            $error = "Database fout: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Registreren</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include_once 'includes/nav.php'; ?>

    <div class="register-container auth-page-container">
        <div class="auth-card">
            <?php if (!empty($error)): ?>
                <div class="error-box"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="success-card">
                    <p class="success"><?= htmlspecialchars($success) ?></p>
                    <a class="success-link" href="login.php">Ga naar login</a>
                </div>
            <?php else: ?>

            <form method="POST" class="auth-form" novalidate>
                <h1 class="auth-title">Registreren</h1>
                <p class="auth-subtitle">Maak een account aan om toegang te krijgen tot het alumni platform.</p>

                <div class="form-group">
                    <label class="auth-label" for="voornaam">Voornaam</label>
                    <input id="voornaam" class="auth-input" type="text"
                           name="voornaam" maxlength="50" required
                           value="<?= htmlspecialchars($_POST['voornaam'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="auth-label" for="achternaam">Achternaam</label>
                    <input id="achternaam" class="auth-input" type="text"
                           name="achternaam" maxlength="50" required
                           value="<?= htmlspecialchars($_POST['achternaam'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="auth-label" for="email">E-mailadres</label>
                    <input id="email" class="auth-input" type="email"
                           name="email" maxlength="50" required
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="auth-label" for="wachtwoord">Wachtwoord</label>
                    <input id="wachtwoord" class="auth-input" type="password"
                        name="wachtwoord" maxlength="72" required>
                    <div class="password-hints">
                        <small class="password-req">• Minimaal 8 tekens</small>
                        <small class="password-req">• Minimaal 1 cijfer</small>
                    </div>
                </div>

                <div class="form-group">
                    <label class="auth-label" for="confirm_wachtwoord">Bevestig wachtwoord</label>
                    <input id="confirm_wachtwoord" class="auth-input" type="password"
                        name="confirm_wachtwoord" maxlength="72" required>
                </div>

                <button type="submit" class="auth-button">Registreren</button>

                <p class="auth-footer">Heb je al een account? <a href="login.php">Login</a></p>
            </form>

            <?php endif; ?>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>

</html>