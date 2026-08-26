<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

function has_role($required_roles)
{
    if (!is_logged_in()) {
        return false;
    }

    if (is_string($required_roles)) {
        $required_roles = [$required_roles];
    }

    return in_array($_SESSION['rol'], $required_roles);
}

function require_role($required_roles, $redirect_url = 'login.php')
{
    if (!has_role($required_roles)) {
        header("Location: " . $redirect_url);
        exit;
    }
}

function require_login($redirect_url = 'login.php')
{
    if (!is_logged_in()) {
        header("Location: " . $redirect_url);
        exit;
    }
}

function get_role_display()
{
    $role_display = [
        'leerling' => 'Leerling',
        'student' => 'Student',
        'admin' => 'Admin',
    ];

    return $role_display[$_SESSION['rol']] ?? htmlspecialchars($_SESSION['rol']);
}
?>