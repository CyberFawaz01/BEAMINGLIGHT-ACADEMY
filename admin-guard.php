<?php
// Include this at the very top of every admin-only page.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['is_admin'])) {
    header('Location: admin-login.php');
    exit();
}
