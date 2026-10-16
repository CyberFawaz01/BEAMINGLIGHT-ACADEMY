
<?php
session_start();
require_once 'includes/dbcon.php';  

$student_id = $_SESSION['student_id'];

$student_id =$_SESSION['student_id'];
    $sql = "SELECT * FROM contact_messages WHERE student_id = '$student_id'";
    $result= mysqli_query($con,$sql);
?>

<?php
 include "includes/header.php";
 include "includes/student-nav.php";
?>
<div class="general-content" style="width:97%;">
<div class="row">
    <div class="col-md-3 col-lg-2 bg-light" id="sidebar-wrapper">
      <?php include "student-sidebar.php"; ?>
    </div>
    
    <div class="col-md-9 col-lg-10 p-4" id="page-content-wrapper">
      <h1 class="text-center">Welcome to your Dashboard, <?php echo $_SESSION['student_name']; ?>!</h1>
      <hr>
      <h2>Your Messages From school ADMIN</h2>
      <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <div class="message-box">
            <h4><?= htmlspecialchars($row['user_subject']) ?></h4>
            <p><?= htmlspecialchars($row['user_message']) ?></p>
            <small><?= htmlspecialchars($row['created_at_time']) ?></small>
            <hr>
        </div> 
      <?php endwhile;?>   
    </div>
</div> 
</div>


<style>
  
.student-nav {
  width: 100%;
  max-width: 250px; /* Set a maximum width */
}

h4{
  color: green;
  font-weight: 700;
}

p{
  
  font-weight: 600;
}

small{
  color: red;
  
}
 
.message-box{
  background: #f8f9fa;
  border-left: 4px solid black ;
  margin-bottom: 20px;
  padding: 15px;
  border-radius: 5px;
}

/* Media query for responsiveness */
@media (max-width: 768px) {
  .student-nav {
    max-width: 100%; /* Allow full width on smaller screens */
  }

  .col-md-8 {
    width: 100%; /* Adjust content width for smaller screens */
  }

  .col-md-3 {
    flex: 0  0 100%;
    width: 100%;
  }

  .genral-content{
    margin: 0 auto;
  }
}

</style>