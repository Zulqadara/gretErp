<?php
require_once '../core.php';
include 'includes/header.php';

?>
<!DOCTYPE html>
<html lang="en">


  <body>
<?php include 'includes/navigation.php';?>
    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="center">
				   <?php
$qu = $db->query("select courses.name as cname from student
inner join activestudent on activestudent.studentid = student.studentid
inner join studentprogramme on  student.studentid = studentprogramme.studentid
inner join studentunits on studentunits.studentprogrammeid = studentprogramme.studentprogrammeid
inner join courses on courses.coursesid = studentunits.unitid
where student.studentid='$studentid' and studentunits.`status`='1'");			
        ?>
<h2 class="text-center">Current Units</h2><hr>
						<table class="table table-bordered stable-striped table-auto table-condensed">
							<thead>
								<th>Unit Name</th>
							</thead>
							<tbody>
							<?php while($res = mysqli_fetch_assoc($qu)): ?>
								<tr>
									<td><?=$res['cname']; ?></td>						
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
   
  </body>
<?php
include 'includes/footer.php';
?>
</html>
