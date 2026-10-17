
<?php   
    require_once "includes/student-guard.php";
    require_once "includes/dbcon.php";
    $student_id = (int)$_SESSION['student_id'];
    $stmt = mysqli_prepare($con, "SELECT * FROM results WHERE student_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

?>
<?php
include "includes/header.php";
include "includes/nav.php";
?>

<div class="container-fluid">
   <div class="row">
    <div class="col-md-3 col-lg-2 bg-light min-vh-50 p-0" id="sidebar-wrapper">
      <?php 
      include "student-sidebar.php";
      ?>
    </div>


    <div class="col-md-9 col-lg-10" id="page-content-wrapper">
    <div class="container container-2 py-4">
      <h1 class="text-center mt-3">YOUR RESULT</h1>
      <hr>
    <div class="table-responsive">
    <table class="table table-bordered mt-4">
      <thead class="thead-dark">
        <tr>
          <th>Course</th>
          <th>Credit Unit</th>
          <th>Score</th>
          <th>Grade</th>
        </tr>
      </thead>
      <tbody>
      
                <?php   
                  
$total_points = 0;
$total_units = 0;

if (mysqli_num_rows($result) > 0):
    while ($row = mysqli_fetch_assoc($result)):{
        $grade = $row['grade'];
        $unit = $row['credit_unit'];
        
        
        if ($grade == 'A') {
            $point = 5;
        } elseif ($grade == 'B') {
            $point = 4;
        } elseif ($grade == 'C') {
            $point = 3;
        } elseif ($grade == 'D') {
            $point = 2;
        } elseif ($grade == 'E') {
            $point = 1;
        } else {
            $point = 0; // for F or any invalid grade
        }

        // Calculate total grade points and total units
        $total_points = $total_points + ($point * $unit);
        $total_units = $total_units + $unit;
    }

      ?>
                <tr>
                <td><?= $row['course'] ?></td>
                <td><?= $row['credit_unit'] ?></td>
                <td><?= $row['score'] ?></td>
                <td><?= $row['grade'] ?></td>
                </tr>
              
            <?php 
            endwhile; 
            
    // Calculate CGPA
    if ($total_units > 0) {
        $cgpa = $total_points / $total_units;

    }
 else {
    echo "<h4>No results found yet.</h4>";
}
?>
            <tr>
              <td colspan="4">CGPA:<?= number_format($cgpa,2)?>
              </td>
          </tr> 
          <?php else:?>  
        <tr>
            <td colspan="5" class="text-center">No Result </td>
        </tr>
        <?php endif; ?>

        
    </tbody>
 </table>
 <hr>
 </div>
 </div>
 </div>
 </div>
</div>    
</body>
</html>

<style>
   
   td{
    font-size: 15px;
   }
    @media screen and (max-width: 768px) {
        .contain {
            width: 100%;
            /* padding: 0 15px; */
        }

        .contain h5{
          text-align: center;
        }

        .sidebar{
          width: 100%;
        }
        
    }
</style>


