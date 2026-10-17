<?php 
  session_start();
  
  if (isset($_SESSION["user"])) {
    header("Location: student-dashboard.php");
    exit;
  }

include "includes/dbcon.php";
require_once "includes/upload-helper.php";
include "includes/header.php";
include "includes/nav.php";

?>


<div class="container reg-box my-5 text-content">
<?php  
$errors = [
    'full_name'=>'',
    'course' => '',
    'phone_num' => '',
    'email' => '',
    'pwd' => '',
    'images' => '',

];
if(isset($_POST['submit'])) {
    if(empty($_POST['full_name'])){
        $errors['full_name']= 'Input your full name';
    }
    else{
         $fullname = $_POST['full_name'];
    }

    if(empty($_POST['course'])){
        $errors['course']= 'Select your course';
    }
    else{
         $course = $_POST['course'];
    }

    

    if(empty($_POST['phone_num'])){
        $errors['phone_num']= 'Input your phone number';
    }
    else{
        $phoneNum = $_POST['phone_num'];
    }

    if(empty($_POST['email'])){
        $errors['email']= 'Input email';
    }
    else if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $errors['email'] = 'Invalid Email';
    }
    else{
        $email = $_POST['email'];

        //check if email already exist
        $chk = mysqli_prepare($con, "SELECT id FROM registration WHERE email = ?");
        mysqli_stmt_bind_param($chk, "s", $email);
        mysqli_stmt_execute($chk);
        mysqli_stmt_store_result($chk);
        if (mysqli_stmt_num_rows($chk) > 0) {
            $errors['email']="Email already exist";
        }
        mysqli_stmt_close($chk);
    }
    

    if(empty($_POST['pwd'])){
        $errors['pwd']= 'Input your password';
    }
    else if(strlen($_POST['pwd'])<8){
        $errors['pwd'] = 'Password must be at least 8 characters long';
    }
    else{
        $pwd = password_hash($_POST['pwd'],PASSWORD_DEFAULT);
       
    }
    

    if(empty($_FILES['images']['name'])){
        $errors['images']= 'Input your image';
    }
    else{
        $images = save_image_upload($_FILES['images'], "student-image/");
        if ($images === null) {
            $errors['images'] = 'Upload a JPG, PNG, GIF or WebP image under 2 MB';
        }
    }

    if(!array_filter($errors)){
         $ins = mysqli_prepare($con, "INSERT INTO registration(full_name,course,phone_num,email,pwd,images,date) VALUES(?,?,?,?,?,?,NOW())");
         mysqli_stmt_bind_param($ins, "ssssss", $fullname, $course, $phoneNum, $email, $pwd, $images);
             if(mysqli_stmt_execute($ins)){
               echo "<div class='alert alert-success'>Registration successful</div>";
               echo "<script>
               setTimeout(function(){
               window.location.href='student-login.php';
             },2000);
            </script>";
             }
             else{
                    echo 'Registration failed. Please try again.';
             }
                  
            }
        }

?>  
        <div class="text-center mb-4">
            <h1 class="section-heading">Create your student account</h1>
            <p class="text-muted">Use your details to register for access to the student portal.</p>
        </div>

<form action="register.php" method="post" enctype="multipart/form-data" class="col-md-8 mx-auto">
    <div class="mb-3">
        <label for="fullName" class="form-label">Student full name</label>
        <input type="text" class="form-control" name="full_name" id="fullName" autocomplete="name" required>
    </div>
    <?php if (!empty($errors['full_name'])): ?><div class="alert alert-danger py-2" role="alert"><?php echo htmlspecialchars($errors['full_name'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
  
        


   

    <div class="mb-3">
        <label for="course" class="form-label">Class / level</label>
        <select class="form-select" name="course" id="course" required>
            <option value="" disabled selected>Select your class / level</option>
            <option value="JSS 1">JSS 1</option><option value="JSS 2">JSS 2</option><option value="JSS 3">JSS 3</option>
            <option value="SS 1">SS 1</option><option value="SS 2">SS 2</option><option value="SS 3">SS 3</option>
        </select>  
    </div>
     <?php if (!empty($errors['course'])): ?><div class="alert alert-danger py-2" role="alert"><?php echo htmlspecialchars($errors['course'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>

    <div class="mb-3">
        <label for="phoneNum" class="form-label">Parent / guardian phone number</label>
        <input type="text" class="form-control" name="phone_num" id="phoneNum" autocomplete="tel" required>
    </div>
    <?php if (!empty($errors['phone_num'])): ?><div class="alert alert-danger py-2" role="alert"><?php echo htmlspecialchars($errors['phone_num'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>

    <div class="mb-3">
        <label for="emailAddress" class="form-label">Email Address</label>
        <input type="text" class="form-control" name="email" id="emailAddress" type="email" autocomplete="email" required>
    </div>
     <?php if (!empty($errors['email'])): ?><div class="alert alert-danger py-2" role="alert"><?php echo htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>

    <div class="mb-3 position-relative">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="pwd" id="password" autocomplete="new-password" required>
        <i class="fa-solid fa-eye position-absolute" style="top:63%;right:15px; color:skyblue; cursor:pointer;" id="icon" onclick="togglePasswordIcon()"></i>
    </div>
    <?php if (!empty($errors['pwd'])): ?><div class="alert alert-danger py-2" role="alert"><?php echo htmlspecialchars($errors['pwd'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>

    <div class="mb-3">
        <label for="imageUpload" class="form-label">Student photo</label>
        <input type="file" class="form-control" name="images" id="imageUpload" accept="image/*">
    </div>
     <?php if (!empty($errors['images'])): ?><div class="alert alert-danger py-2" role="alert"><?php echo htmlspecialchars($errors['images'], ENT_QUOTES, 'UTF-8'); ?></div><?php endif; ?>
    <div class="mb-4 text-center">
        <button type="submit" name="submit" class="btn btn-primary w-100">Register</button>
    </div>

    <div class="mb-3 text-center">
        <p>Already have an account? <a href="student-login.php">Login</a></p>
    </div>

    <div class="text-center text-muted small">
        <p>By clicking "Register", you confirm that the information provided is accurate. You can read our 
            <a href="#">Terms of Service</a> and 
            <a href="#">Privacy Policy</a>.
        </p>
    </div>
</form>
</div>




<?php  
include "includes/footer.php";
?> 