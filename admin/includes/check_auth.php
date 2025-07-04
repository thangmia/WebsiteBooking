<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'doctor') {
    session_destroy();
    header("Location: login.php?error=access_denied");
    exit();
}

function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}
?>