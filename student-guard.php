<?php
// Include this at the very top of every page that needs a signed-in student.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['user']) || empty($_SESSION['student_id'])) {
    header('Location: student-login.php');
    exit();
}
