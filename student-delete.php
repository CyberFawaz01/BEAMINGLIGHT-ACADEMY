<?php
require_once "includes/admin-guard.php";
require_once "includes/dbcon.php";

$student_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($student_id > 0) {
    try {
        mysqli_begin_transaction($con);

        // remove the student's results and messages first, so the database allows the delete
        $r = mysqli_prepare($con, "DELETE FROM results WHERE student_id = ?");
        mysqli_stmt_bind_param($r, "i", $student_id);
        mysqli_stmt_execute($r);
        mysqli_stmt_close($r);

        $m = mysqli_prepare($con, "DELETE FROM contact_messages WHERE student_id = ?");
        mysqli_stmt_bind_param($m, "i", $student_id);
        mysqli_stmt_execute($m);
        mysqli_stmt_close($m);

        $stmt = mysqli_prepare($con, "DELETE FROM registration WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $student_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        mysqli_commit($con);
    } catch (mysqli_sql_exception $e) {
        mysqli_rollback($con);
    }
}
header("Location: manage-students.php");
exit();
