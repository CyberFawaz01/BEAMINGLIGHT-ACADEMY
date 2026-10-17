<?php
require_once "includes/admin-guard.php";
require_once "includes/dbcon.php";

$message = '';
$ok = false;
if (isset($_POST['change'])) {
    $current = $_POST['current'] ?? '';
    $new     = $_POST['new'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    $stmt = mysqli_prepare($con, "SELECT user_id, user_password FROM users WHERE user_name = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['user_name']);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    $stored = $row ? (string)$row['user_password'] : '';
    $currentOk = $stored !== '' && (password_get_info($stored)['algo'] ? password_verify($current, $stored) : hash_equals($stored, $current));

    if (!$currentOk) {
        $message = 'Your current password is not correct.';
    } elseif (strlen($new) < 12) {
        $message = 'Choose a new password of at least 12 characters.';
    } elseif ($new !== $confirm) {
        $message = 'The two new passwords do not match.';
    } else {
        $hash = password_hash($new, PASSWORD_DEFAULT);
        $up = mysqli_prepare($con, "UPDATE users SET user_password = ? WHERE user_id = ?");
        mysqli_stmt_bind_param($up, "si", $hash, $row['user_id']);
        mysqli_stmt_execute($up);
        mysqli_stmt_close($up);
        session_regenerate_id(true);
        $_SESSION['is_admin'] = true;
        $ok = true;
        $message = 'Password changed successfully.';
    }
}
include "includes/header.php";
include "includes/admin_nav.php";
?>
<main class="section-pad section-soft"><div class="container auth-page mt-0"><div class="auth-card">
  <h1 class="text-center mb-4">Change admin password</h1>
  <?php if ($message !== ''): ?>
    <div class="alert <?php echo $ok ? 'alert-success' : 'alert-danger'; ?> text-center"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
  <?php endif; ?>
  <form method="post" class="col-md-6 mx-auto">
    <div class="mb-3"><label class="form-label">Current password</label><input type="password" name="current" class="form-control" autocomplete="current-password" required></div>
    <div class="mb-3"><label class="form-label">New password (12 characters or more)</label><input type="password" name="new" class="form-control" autocomplete="new-password" minlength="12" required></div>
    <div class="mb-3"><label class="form-label">Confirm new password</label><input type="password" name="confirm" class="form-control" autocomplete="new-password" minlength="12" required></div>
    <button type="submit" name="change" class="btn btn-info">Change password</button>
  </form>
</div></div></main>
<?php include "includes/footer.php"; ?>
