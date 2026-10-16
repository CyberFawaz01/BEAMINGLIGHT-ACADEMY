<?php include_once __DIR__ . '/header.php'; ?>
<nav class="navbar navbar-expand-lg school-navbar sticky-top">
  <div class="container">
    <a class="navbar-brand school-brand" href="admin_dashboard.php">
      <img src="image/school-icon.png" alt="" width="44" height="44">
      <span><strong>Beaming Light</strong><small>STAFF PORTAL</small></span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#staffNavigation" aria-controls="staffNavigation" aria-expanded="false" aria-label="Toggle staff navigation"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="staffNavigation">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
        <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="manage-students.php">Manage students</a></li>
        <li class="nav-item"><a class="nav-link" href="admin-message.php">Messages</a></li>
        <li class="nav-item"><a class="nav-link nav-admin" href="admin-logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
