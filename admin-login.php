<?php
session_start();
require_once "includes/dbcon.php";

$loginError = '';
if (isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = mysqli_prepare($con, "SELECT user_id, user_name, user_password FROM users WHERE user_name = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $admin = $res ? mysqli_fetch_assoc($res) : null;
    mysqli_stmt_close($stmt);

    $ok = false;
    if ($admin) {
        $stored = (string)$admin['user_password'];
        if (password_get_info($stored)['algo']) {
            // normal case: the password is stored as a hash
            $ok = password_verify($password, $stored);
        } elseif (hash_equals($stored, $password)) {
            // old plain-text password: accept it once, then store it as a hash
            $ok = true;
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $up = mysqli_prepare($con, "UPDATE users SET user_password = ? WHERE user_id = ?");
            mysqli_stmt_bind_param($up, "si", $newHash, $admin['user_id']);
            mysqli_stmt_execute($up);
            mysqli_stmt_close($up);
        }
    }

    if ($ok) {
        session_regenerate_id(true);               // new session id after login
        $_SESSION['user_name'] = $admin['user_name'];
        $_SESSION['is_admin']  = true;
        header('Location: admin_dashboard.php');
        exit();
    }
    $loginError = 'Invalid username or password. Please try again.';
}

include "includes/nav.php";
if ($loginError !== '') {
    echo "<script>alert(" . json_encode($loginError) . ")</script>";
}
?>

<main class="section-pad section-soft"><div class="container auth-page mt-0"><div class="auth-card">
    <div class="text-content text-center">
        <h1 class="text-center mb-4">Admin Login</h1>
        <p class="text-center">Please fill in the form below to <span>Login</span></p>
    </div>

    <form class="mt-4 col-md-6 justify-content-center mx-auto " method="post">
        <div class="mb-3">
            <label for="exampleInputUsername" class="form-label">Username</label>
            <input type="text" name="username" id="exampleInputUsername" class="form-control" autocomplete="username" required>
        </div>
        <div class="mb-3 position-relative">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" autocomplete="current-password" required>
            <i class="fa-solid fa-eye-slash position-absolute" style="color: skyblue; top:60%;right:15px; cursor:pointer" id="icon" onclick="togglePasswordIcon()"></i>
        </div>
        <div class="mb-4">
            <button type="submit" name="login" class="btn btn-info">Login</button>
        </div>
    </form>
</div></div></main>

<?php  
include "includes/footer.php";
?> 