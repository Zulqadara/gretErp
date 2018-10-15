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
				 	<h2 class="text-center">Fees Information</h2><hr>
					<?php
								$sql = "select * from studentprogramme
inner join studentfees on studentfees.studentprogrammeid = studentprogramme.studentprogrammeid
where studentid = '$studentid' ORDER BY tamount DESC";
						$results = $db->query($sql);
					?>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<th>Amount</th>
						<th>Paid</th>
						<th>Balance</th>
						<th>Invoice Date</th>
								
							</thead>
					<tbody>
						<?php while($result = mysqli_fetch_assoc($results)) : ?>
						<tr>
						<td><?=$result['tamount'];?></td>
							<td><?=$result['tpaid'];?></td>
							<td><u><b><i><?=$result['tamount'] - $result['tpaid'] ;?></i></b></u></td>
							<td><?=$result['dt'];?></td>
							
						</tr>
						<?php endwhile; ?>
					</tbody>
				  </table>
				</div>

      </div>
      <!-- /.row -->

    </div>
	</div>
    <!-- /.container -->

    <!-- Footer -->
   
  </body>
<?php
include 'includes/footer.php';
?>
</html>
