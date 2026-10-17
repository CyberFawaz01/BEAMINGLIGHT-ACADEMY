<?php 
 require_once "includes/admin-guard.php";
 include 'includes/dbcon.php'; 

if (isset($_POST['send'])) {
  $student_id = !empty($_POST['student_id']) ? (int)$_POST['student_id'] : null;
  $subject = trim($_POST['subject'] ?? '');
  $message = trim($_POST['message'] ?? '');
  
  $sql = "INSERT INTO `contact_messages`(`student_id`, `user_subject`, `user_message`, `created_at_time`) VALUES (?,?,?,NOW())";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "iss", $student_id, $subject, $message);

  if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('Message sent successfully!'); window.location='admin-message.php';</script> ";
  } else {
    echo "<script>alert('Error sending message. Please try again.');</script>";
  }
}
?>

