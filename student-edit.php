<?php 
 require_once "includes/admin-guard.php";
 require_once "includes/dbcon.php";
 include "includes/student-nav.php";
 include "includes/admin_sidebar.php";
?>

<?php 
if (isset($_GET['id'])) {
    $student_id = (int)$_GET['id'];
    $stmt = mysqli_prepare($con, "SELECT * FROM registration WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $student = $result ? mysqli_fetch_assoc($result) : null;
    mysqli_stmt_close($stmt);

    if ($student) {
        $student = array_map(fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'), $student);
    } else {
        echo "Student not found";
        exit();
    }
} else {
  echo "invalid request";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Student</title>
</head>
<body>
     
    <div class="container mt-5" style="width: 50%;">
           <h3 class="card-title">Edit Student</h3> 
           <form action="student-update.php" method="POST" enctype="multipart/form-data">
             <div class="mb-4">
                <input type="hidden" name="id" value="<?= $student['id'] ?>">
             </div>
             
              <div class="mb-3">
                  <label for="full_name" class="form-label">Full Name:</label>
                  <input type="text" class="form-control" id="full_name" name="full_name" required value="<?= $student['full_name'] ?>">
              </div> 
              
              <div class="mb-3">
                  <label for="course" class="form-label">Course</label>
                  <select class="form-select" name="course" id="course" required >
                      <option  disabled selected>Select your course</option>
                      <option value="Computer Science" >Computer Science</option>
                      <option value="Information Technology">Information Technology</option>
                      <option value="Software Engineering">Software Engineering</option>
                      <option value="Cyber Security">Cyber Security</option>
                      <option value="Data Science">Data Science</option>
                      <option value="Web Development">Web Development</option>
                  </select>  
            </div>

              <div class="mb-3">
                  <label for="full_name" class="form-label">Email:</label>
                  <input type="text" class="form-control" id="email" name="email" required value="<?= $student['email'] ?>">
              </div> 

              <div class="mb-3">
                  <label for="full_name" class="form-label">Phone Num:</label>
                  <input type="text" class="form-control" id="phone_num" name="phone_num" required value="<?= $student['phone_num'] ?>">
              </div> 

              <label>Change Image</label>
              <input type="file" name="image" class="form-control mb-2">
              <?php if (!empty($student['images'])) :?>
                  <img src="../school-website/student-image/<?= $student['images'] ?>" alt="Student Photo" class="img-thumbnail mb-2" style="width: 100px; height: 100px; object-fit: cover;">
              <?php endif; ?>
              <button type="submit" name="update_student" class="btn btn-success" value="update">Update Student</button>
           </form> 
    </div>
</body>
</html>
