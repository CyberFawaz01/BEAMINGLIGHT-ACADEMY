<?php
require_once "includes/student-guard.php";
require_once "includes/dbcon.php";
require_once "includes/upload-helper.php";

if (isset($_POST['update_student'])) {
    $id        = (int)$_SESSION['student_id'];          // always the signed-in student, never a value from the form
    $full_name = trim($_POST['name'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $phone_num = trim($_POST['phone_num'] ?? '');

    if ($full_name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: edit-student-profile.php");
        exit();
    }

    $image = null;
    if (!empty($_FILES['images']['name'])) {
        $image = save_image_upload($_FILES['images'], "student-image/");
    }

    if ($image !== null) {
        $stmt = mysqli_prepare($con, "UPDATE registration SET full_name = ?, email = ?, phone_num = ?, images = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssssi", $full_name, $email, $phone_num, $image, $id);
    } else {
        $stmt = mysqli_prepare($con, "UPDATE registration SET full_name = ?, email = ?, phone_num = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssi", $full_name, $email, $phone_num, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        $sel = mysqli_prepare($con, "SELECT * FROM registration WHERE id = ?");
        mysqli_stmt_bind_param($sel, "i", $id);
        mysqli_stmt_execute($sel);
        $updated = mysqli_fetch_assoc(mysqli_stmt_get_result($sel));
        mysqli_stmt_close($sel);
        if ($updated) {
            $_SESSION['student_image'] = $updated['images'];
            $_SESSION['student_name']  = $updated['full_name'];
            $_SESSION['student_email'] = $updated['email'];
            $_SESSION['student_phone'] = $updated['phone_num'];
        }
    }
}
header("Location: student-dashboard.php");
exit();
