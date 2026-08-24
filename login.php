<?php
session_start();
require 'db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $wachtwoord = $_POST['wachtwoord'] ?? '';

    if (empty($email) || empty($wachtwoord)) {
        $error = 'Vul e-mail en wachtwoord in.';
    } else {
        try {
            $stmt = $db->prepare('SELECT id, firstname, lastname, pass, is_admin FROM users WHERE email = ?');
            $stmt->execute([$email]);

            if ($stmt->rowCount() === 0) {
                $error = 'Ongeldige inloggegevens.';
            } else {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($wachtwoord, $row['pass'])) {
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_name'] = trim($row['firstname'] . ' ' . $row['lastname']);
                    header('Location: index.php');
                    exit;
                }

                $error = 'Ongeldige inloggegevens.';
            }
        } catch (PDOException $e) {
            $error = 'Database fout: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include_once 'includes/nav.php'; ?>

    <div class="login-container auth-page-container">
        <div class="auth-card">
            <?php if (!empty($error)): ?>
                <div class="error-box"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" class="auth-form" novalidate>
                <h1 class="auth-title">Inloggen</h1>
                <p class="auth-subtitle">Log in op je account om toegang te krijgen tot je alumni profiel en berichten.</p>

                <div class="form-group">
                    <label class="auth-label" for="email">E-mailadres</label>
                    <input class="auth-input" type="email" id="email" name="email" maxlength="50" required value="<?= htmlspecialchars($email ?? '') ?>">
                </div>

                <label class="auth-label" for="wachtwoord">Wachtwoord:</label>
                <input class="auth-input" type="password" id="wachtwoord" name="wachtwoord" maxlength="200" required>

                <button type="submit" class="auth-button">Inloggen</button>

                <p class="auth-footer">Heeft u nog geen account? <a href="register.php">Registreer hier</a></p>
            </form>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>

</html>