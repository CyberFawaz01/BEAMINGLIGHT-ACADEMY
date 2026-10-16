<?php $current_page = basename($_SERVER['PHP_SELF']); $student_name = $_SESSION['student_name'] ?? 'Student'; $student_image = $_SESSION['student_image'] ?? ''; ?>
<aside class="student-sidebar">
  <div class="student-profile">
    <?php if ($student_image && is_file(__DIR__ . '/student-image/' . basename($student_image))): ?>
      <img src="student-image/<?php echo htmlspecialchars(basename($student_image), ENT_QUOTES, 'UTF-8'); ?>" alt="Student profile photo">
    <?php else: ?><div class="student-avatar"><i class="fa-solid fa-user-graduate"></i></div><?php endif; ?>
    <p><?php echo htmlspecialchars($student_name, ENT_QUOTES, 'UTF-8'); ?></p><span>Student portal</span>
  </div>
  <nav aria-label="Student navigation"><a class="<?php echo $current_page === 'student-dashboard.php' ? 'active' : ''; ?>" href="student-dashboard.php"><i class="fa-solid fa-gauge-high"></i> Dashboard</a><a class="<?php echo $current_page === 'student-result.php' ? 'active' : ''; ?>" href="student-result.php"><i class="fa-solid fa-chart-column"></i> My Results</a><a class="<?php echo in_array($current_page, ['edit-student-profile.php','update-profile.php'], true) ? 'active' : ''; ?>" href="edit-student-profile.php"><i class="fa-regular fa-user"></i> My Profile</a><a class="<?php echo $current_page === 'student-view-message.php' ? 'active' : ''; ?>" href="student-view-message.php"><i class="fa-regular fa-envelope"></i> Messages</a><a href="student-logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</a></nav>
</aside>
