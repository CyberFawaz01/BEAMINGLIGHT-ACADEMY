<?php
require_once "includes/admin-guard.php";
require_once "includes/dbcon.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    try {
        $stmt = mysqli_prepare($con, "DELETE FROM `messages` WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } catch (mysqli_sql_exception $e) {
        // the table may not exist in every setup; ignore and go back
    }
}
header("Location: admin-message.php");
exit();
