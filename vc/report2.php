<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();
	$date = date("Y-m-d");
?> 
  <body>

    <!-- Navigation -->
<br>

<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
<div class="clearfix"></div>
		  		<h2 class="text-center">Unoccupied Rooms</h2><hr>
		      <?php
			$sresults = $db->query("SELECT * from room
			WHERE available>0
			");	
        ?>
		
		
			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>				
						<th>#</th>
						<th>Room No</th>
						<th>Floor</th>	
						<th>Wing</th>	
						<th>Capacity</th>	
						<th>Avaialble</th>	
					</tr>
				</thead>
				<tbody>
					<?php 
					$count=1;
					while($school = mysqli_fetch_assoc($sresults)) : 					
					?>
					<tr>
						<td><?=$count;?></td>
						<td><?=$school['roomno'];?></td>
						<td><?=$school['floor'];?></td>
						<td><?=$school['wing'];?></td>
						<td><?=$school['capacity'];?></td>
						<td><?=$school['available'];?></td>
					</tr>
					<?php 
						$count++;
						endwhile; ?>
				</tbody>
			</table>

        </div>
					<a class="btn btn-default btn-lg" href="index.php">Back</a>
		<form method="post" action="report2p.php" target="_blank">
				<button class="btn btn-success btn-lg" name="print" type="submit">Print</button>
			</form>
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
	
