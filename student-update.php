<?php
require_once "includes/admin-guard.php";
require_once "includes/dbcon.php";
require_once "includes/upload-helper.php";

if (isset($_POST['update_student'])) {
    $id        = (int)($_POST['id'] ?? 0);
    $full_name = trim($_POST['full_name'] ?? '');
    $course    = trim($_POST['course'] ?? '');
    $phone_num = trim($_POST['phone_num'] ?? '');
    $email     = trim($_POST['email'] ?? '');

    if ($id <= 0 || $full_name === '' || $course === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: manage-students.php");
        exit();
    }

    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $image = save_image_upload($_FILES['image'], "student-image/");
    }

    if ($image !== null) {
        $stmt = mysqli_prepare($con, "UPDATE registration SET full_name = ?, course = ?, phone_num = ?, email = ?, images = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssssi", $full_name, $course, $phone_num, $email, $image, $id);
    } else {
        $stmt = mysqli_prepare($con, "UPDATE registration SET full_name = ?, course = ?, phone_num = ?, email = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssssi", $full_name, $course, $phone_num, $email, $id);
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
header("Location: manage-students.php");
exit();
