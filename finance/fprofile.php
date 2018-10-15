<?php
require_once '../core.php';
include 'includes/header.php';
include 'includes/navigation.php';

$edit_id = (int)$_GET['add'];


?> 
  <body>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
	  <h2 class="text-center">Student Fees Profile</h2><hr>
	  	<?php
			$sql = "select *, pf.name as pfname, sd.pdetails as pcode, sd.paid as sdpaid, sd.timepaid as sddt from studentprogramme sp inner join studentfees sf on sp.studentprogrammeid = sf.studentprogrammeid
			inner join studentinvoice si on si.studentfeesid = sf.studentfeesid
			inner join studentinvoicedetails sd on sd.studentinvoiceid = si.studentinvoiceid
			inner join paymentforms pf on pf.paymentformsid = sd.paymentform
			where sp.studentid = '$edit_id'
			";
			$sresults = $db->query($sql);
		?>
	  <table id="table_id" class="display responsive" width="100%">
	  <thead>
					<tr>
						<th>Amount Paid</th>
						<th>Payment Method</th>
						<th>Code</th>
						<th>Date</th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($student = mysqli_fetch_assoc($sresults)) : 
						$studentid = $student['sdpaid'];
						$studentref = $student['pfname'];
						$name = $student['pcode'];
						$gender = $student['sddt'];
					?>
					<tr>
						<td><?=$studentid;?></td>
						<td><?=$studentref;?></td>
						<td><?=$name;?></td>
						<td><?=$gender;?></td>
					</tr>
					<?php endwhile; ?>
				</tbody>
	  </table>

<a href="students.php" class="btn btn-default">Cancel</a>
        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
   <br>
  </body>
<?php
include 'includes/footer.php';
?>
	<script>
$(document).ready(function() {
    $('#table_id').DataTable( {
		 "order": [[ 1, "desc" ]],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": true,
                "searchable": true
            }
        ]
    } );
} );
	</script>
	
