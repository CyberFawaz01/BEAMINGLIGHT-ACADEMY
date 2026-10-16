<?php include_once __DIR__ . '/header.php'; ?>
<nav class="navbar navbar-expand-lg school-navbar sticky-top">
  <div class="container">
    <a class="navbar-brand school-brand" href="index.php" aria-label="Beaming Light Academy home">
      <img src="image/school-icon.png" alt="" width="48" height="48">
      <span><strong>Beaming Light</strong><small>ACADEMY</small></span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#schoolNavigation" aria-controls="schoolNavigation" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="schoolNavigation">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About us</a></li>
        <li class="nav-item"><a class="nav-link" href="student.php">Student corner</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
        <li class="nav-item ms-lg-2"><a class="nav-link nav-portal" href="student-login.php"><i class="fa-solid fa-user-graduate me-2"></i>Student portal</a></li>
        <li class="nav-item"><a class="nav-link nav-admin" href="admin-login.php">Staff login</a></li>
      </ul>
    </div>
  </div>
</nav>
