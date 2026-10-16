<?php
session_start();
require_once 'includes/dbcon.php';
$student_id = isset($_SESSION['student_id']) ? (int)$_SESSION['student_id'] : null;
$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? 'General enquiry');
    $message = trim($_POST['message'] ?? '');
    if ($full_name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $subject === '' || $message === '') {
        $error = 'Please complete every field with a valid email address.';
    } else {
        $stmt = mysqli_prepare($con, 'INSERT INTO contact_messages (student_id, full_name, email, user_subject, user_message, created_at_time) VALUES (?, ?, ?, ?, ?, NOW())');
        if ($stmt) {
            $sid = $student_id ?? 0;
            mysqli_stmt_bind_param($stmt, 'issss', $sid, $full_name, $email, $subject, $message);
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['contact_success'] = 'Thank you for contacting Beaming Light Academy. Your message has been received.';
                header('Location: contact.php');
                exit;
            }
            $error = 'We could not send your message right now. Please try again later.';
            mysqli_stmt_close($stmt);
        } else {
            $error = 'We could not process your message right now. Please try again later.';
        }
    }
}
if (isset($_SESSION['contact_success'])) { $success = $_SESSION['contact_success']; unset($_SESSION['contact_success']); }
include_once 'includes/header.php';
include_once 'includes/nav.php';
?>
<main>
  <section class="page-hero"><img src="image/bg-img-4.jpg" alt="School building at dusk"><div class="container"><div class="section-kicker">We are listening</div><h1>Contact the school</h1><p>Have a question or need help with the student portal? Send us a message and the school team will follow up.</p></div></section>
  <section class="section-pad section-soft"><div class="container"><div class="row g-5">
    <div class="col-lg-5"><div class="section-kicker">Get in touch</div><h2 class="section-heading">How can we help?</h2><p class="section-lead mb-4">Use the form to send a general enquiry. Please avoid including passwords or other sensitive personal information.</p>
      <div class="contact-info-card"><p class="mb-1 fw-bold"><i class="fa-solid fa-phone"></i> School office</p><a href="tel:09000000000" class="text-decoration-none text-dark">0900 000 0000</a></div>
      <div class="contact-info-card"><p class="mb-1 fw-bold"><i class="fa-solid fa-envelope"></i> Email</p><a href="mailto:bla@ourschool.com" class="text-decoration-none text-dark">bla@ourschool.com</a></div>
      <div class="contact-info-card"><p class="mb-1 fw-bold"><i class="fa-solid fa-location-dot"></i> Location</p><span class="text-muted">Lagos, Nigeria</span></div>
      <div class="contact-info-card"><p class="mb-1 fw-bold"><i class="fa-solid fa-clock"></i> Enquiries</p><span class="text-muted">Contact the school office during normal school hours.</span></div>
    </div>
    <div class="col-lg-7"><div class="contact-card">
      <?php if ($success !== ''): ?><div class="alert alert-success" role="status"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
      <?php if ($error !== ''): ?><div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
      <form action="contact.php" method="POST" class="contact-form">
        <div><label for="full_name">Full name</label><input id="full_name" type="text" name="full_name" value="<?php echo htmlspecialchars($_POST['full_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" autocomplete="name" required></div>
        <div><label for="email">Email address</label><input id="email" type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" autocomplete="email" required></div>
        <div><label for="subject">Subject</label><input id="subject" type="text" name="subject" value="<?php echo htmlspecialchars($_POST['subject'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required></div>
        <div><label for="message">How can we help?</label><textarea id="message" name="message" rows="5" required><?php echo htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea></div>
        <button type="submit" name="submit" class="btn-school">Send message <i class="fa-solid fa-paper-plane"></i></button>
      </form>
    </div></div>
  </div></div></section>
</main>
<?php include 'includes/footer.php'; ?>
