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
    <link rel="stylesheet" href="css/login.css">
    <?php include_once 'includes/nav.php'; ?>
</head>

<body>
    <main class="main-login">
            <div class="auth-card">
                <?php if (!empty($error)): ?>
                    <div class="error-box"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" class="login-page" novalidate>
                    <div class="login-form">
                        <h3>Inloggen</h3>
                        <p>Log in op je account om toegang te krijgen.</p>

                        <div class="login-email">
                            <h4>E-mailadres:</h4>
                            <input class="auth-input" type="email" id="email" name="email" maxlength="50" required value="<?= htmlspecialchars($email ?? '') ?>">
                        </div>
                        <div class="login-pass">
                            <h4 for="wachtwoord">Wachtwoord:</h4>
                            <input type="password" id="wachtwoord" name="wachtwoord" maxlength="200" required>
                        </div> 
                        <button type="submit" class="login-submit">Inloggen</button>

                        <p>Heeft u nog geen account? <a href="register.php">Registreer hier</a></p>
                    </div>
                </form>
            </div>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>

</html>