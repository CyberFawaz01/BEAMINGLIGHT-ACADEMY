<?php
session_start();
if (!isset($_SESSION['user_name'])) { header('Location: admin-login.php'); exit(); }
require_once 'includes/dbcon.php';
$result = mysqli_query($con, 'SELECT id, full_name, course, phone_num, email, images, date FROM registration ORDER BY date DESC');
include_once 'includes/admin_nav.php';
?>
<main class="container-fluid py-4 staff-page"><div class="row g-0">
  <aside class="col-md-3 col-lg-2"><?php include 'includes/admin_sidebar.php'; ?></aside>
  <section class="col-md-9 col-lg-10 px-md-4 px-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4"><div><p class="section-kicker mb-1">Staff workspace</p><h1 class="section-heading mb-0">Manage students</h1><p class="text-muted mb-0">View and maintain student account records.</p></div></div>
    <div class="staff-panel"><div class="table-responsive"><table class="table align-middle staff-table"><thead><tr><th>#</th><th>Student</th><th>Class / level</th><th>Phone</th><th>Email</th><th>Photo</th><th>Date registered</th><th>Actions</th></tr></thead><tbody>
    <?php if ($result && mysqli_num_rows($result) > 0): while ($row = mysqli_fetch_assoc($result)): ?>
      <tr><td><?php echo (int)$row['id']; ?></td><td><?php echo htmlspecialchars($row['full_name'], ENT_QUOTES, 'UTF-8'); ?></td><td><?php echo htmlspecialchars($row['course'], ENT_QUOTES, 'UTF-8'); ?></td><td><?php echo htmlspecialchars($row['phone_num'], ENT_QUOTES, 'UTF-8'); ?></td><td><?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td><td><?php if (!empty($row['images'])): ?><img src="student-image/<?php echo rawurlencode(basename($row['images'])); ?>" alt="Student photo" width="48" height="48" style="object-fit:cover;border-radius:50%"><?php else: ?><span class="text-muted">—</span><?php endif; ?></td><td><?php echo htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8'); ?></td><td class="text-nowrap"><a href="student-edit.php?id=<?php echo (int)$row['id']; ?>" class="btn btn-sm btn-outline-success">Edit</a> <a href="student-delete.php?id=<?php echo (int)$row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this student account?')">Delete</a></td></tr>
    <?php endwhile; else: ?><tr><td colspan="8" class="text-center text-muted py-4">No student accounts found.</td></tr><?php endif; ?>
    </tbody></table></div></div>
  </section>
</div></main>
<style>.staff-page{min-height:65vh;background:#f7f8f5}.staff-page .section-heading{font-size:2rem}.staff-panel{background:#fff;border:1px solid #e3e8e1;border-radius:14px;padding:1.25rem;box-shadow:0 10px 28px rgba(18,59,42,.05)}.staff-table thead th{font-size:.78rem;text-transform:uppercase;letter-spacing:.04em;color:#5c6c60;border-bottom-color:#dfe7df}.staff-table td{font-size:.9rem}.staff-page aside .sidebar{z-index:2}@media(max-width:767px){.staff-page aside .sidebar{position:relative!important;width:100%!important;height:auto!important;margin-bottom:1rem}.staff-page section{padding-top:1rem}}</style>
</body></html>
