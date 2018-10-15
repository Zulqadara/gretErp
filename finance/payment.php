<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();
$year = date("Y");

if(isset($_GET['add']) || isset($_GET['edit'])){
	
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$Q = $db->query("SELECT * FROM staff left join staffcontract on staff.staffid = staffcontract.staffid where staff.staffid = '$edit_id'");
			$r = mysqli_fetch_assoc($Q);
			$type = ((isset($_POST['type']) && $_POST['type'] !='')?ss($_POST['type']):$r['type']);
			$a=0;
			if($type=='contract'){
				$a=1;
			}
			}
		
		if($_POST){
		$pQ = "INSERT INTO payroll (staffid) VALUES ('$edit_id')";
		$db->query($pQ);
		$pQid = $db->insert_id;
		
		
			if(isset($_POST["hours"]) && isset($_POST["rate"])){
				$hours = ss($_POST["hours"]);
				$rate = ss($_POST["rate"]);
				$name = ss($_POST["name"]);
				$amount = $hours * $rate;
				$pQ2 = "INSERT INTO payrollcontract (payrollid, hours, rate) VALUES ('$pQid', '$hours', '$rate')";
				$db->query($pQ2);
				$pdQ = "INSERT INTO payrolldetails (payrollid, paymentdetailsid, amount, type) VALUES 
				('$pQid', '$name', '$amount', 'Gross')";
				$db->query($pdQ);
			}
		
		
		if(isset($_POST["gross"]) && is_array($_POST["gross"])){  
			foreach($_POST["gross"] as $key => $text_field){
				$gross = ss($_POST["gross"][$key]);
				$gamount = ss($_POST["gamount"][$key]);
				//echo $gross."<br>";
				//echo $gamount."<br>";
				$pdQ = "INSERT INTO payrolldetails (payrollid, paymentdetailsid, amount, type) VALUES 
				('$pQid', '$gross', '$gamount', 'Gross')";
				$db->query($pdQ);			   
			}
		}
		if(isset($_POST["deduction"]) && is_array($_POST["deduction"])){  
			foreach($_POST["deduction"] as $key => $text_field){
				$deduction = ss($_POST["deduction"][$key]);
				$damount = ss($_POST["damount"][$key]);
			//	echo $deduction."<br>";
		//		echo $damount."<br>";
				$pdQ = "INSERT INTO payrolldetails (payrollid, paymentdetailsid, amount, type) VALUES 
				('$pQid', '$deduction', '$damount', 'Deduction')";
				$db->query($pdQ);			   
			}
		}
		
		$Q = $db->query("SELECT *
				,SUM(CASE WHEN pd.`type` = 'Gross' THEN pd.amount ELSE 0 END) AS grosstot
				,SUM(CASE WHEN pd.`type` = 'Deduction' THEN pd.amount ELSE 0 END) AS dedtot
				 FROM payroll as p inner join 
				payrolldetails as pd on p.payrollid = pd.payrollid
				WHERE p.payrollid = '$pQid'");
		$r = mysqli_fetch_assoc($Q);
		$grossincome = $r['grosstot'];
		$deductionincome = $r['dedtot'];
		
		
		$grossincome2=(($grossincome-(6/100) * $grossincome));

		if($grossincome2<11181){
		$paye=0;
		}elseif($grossincome2<21716){
		$paye=((0.1*11180)+($grossincome2-11181)*0.15)-1280;
		
		}elseif($grossincome2<32250){
		$paye=((0.1*11180)+(0.15*10534)+($grossincome2-21715)*0.2)-1280;
		
		}elseif($grossincome2<42783){
		$paye=((0.1*11180)+(0.15*10534)+(0.2*10534)+($grossincome2-32249)*0.25)-1280;
		}else{
		$paye=((0.1*11180)+(0.15*10534)+(0.2*10534)+(0.25*10534)+($grossincome2-42782)*0.3)-1280;
		}
	//NHIF
	if(!isset($_POST["hours"]) && isset($_POST["rate"])){
			$nhiftax=$grossincome;
		
			if($nhiftax<6000){
			$nhif=150;
			}elseif($nhiftax<8000){
			$nhif=300;
			}elseif($nhiftax<12000){
			$nhif=400;
			}elseif($nhiftax<15000){
			$nhif=500;
			}elseif($nhiftax<20000){
			$nhif=600;
			}elseif($nhiftax<25000){
			$nhif=750;
			}elseif($nhiftax<30000){
			$nhif=850;
			}elseif($nhiftax<35000){
			$nhif=900;
			}elseif($nhiftax<40000){
			$nhif=950;
			}elseif($nhiftax<45000){
			$nhif=1000;
			}elseif($nhiftax<50000){
			$nhif=1100;
			}elseif($nhiftax<60000){
			$nhif=1200;
			}elseif($nhiftax<70000){
			$nhif=1300;
			}elseif($nhiftax<80000){
			$nhif=1400;
			}elseif($nhiftax<90000){
			$nhif=1500;
			}elseif($nhiftax<100000){
			$nhif=1600;
			}else{
			$nhif=1700;
			}
		//NSSF
		$nssf=(6/100) * $grossincome;
	
		$net=$grossincome-($paye+$nssf+$nhif+$deductionincome);
		$db->query("UPDATE payroll SET gross='$grossincome', deductions='$deductionincome', paye='$paye', nssf='$nssf', nhif='$nhif', net='$net' WHERE payrollid='$pQid'");	
		
	}
		if(isset($_POST["hours"]) && isset($_POST["rate"])){
		
		$net=$grossincome-($paye+$deductionincome);
		$db->query("UPDATE payroll SET gross='$grossincome', deductions='$deductionincome', paye='$paye', net='$net' WHERE payrollid='$pQid'");	
		}
			echo ("<SCRIPT LANGUAGE='JavaScript'>
		window.open('paymentp.php?pQid=$pQid');
		window.location.href='payment.php';
		</SCRIPT>");
		
	}
?> 
  <body>
<script type="text/javascript">
$(document).ready(function () {
    $('#checkBtn').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one checkbox is ticked.");
        return false;
      }

    });
});

</script>

	<script>
		$(document).ready(function(){
			$("#parent1").css("display","none");
		});
	</script>
	<?php
	$dis="disabled";
	$req="";
	if($type=='contract'): ?>
	<script>
		$(document).ready(function(){
$("#parent1").show(); //Slide Down Effect
		});
	</script>
	
	<?php
$req="required";
$dis="";
	endif; ?>
	
    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">
       
        <div class="col-md-12" align="">
			<h3 class="text-center">Staff Payroll</h3><hr>
			<h5><p>Staff ID: <?=$edit_id?></p></h5>
	 <h5><p>Staff Name: <?=$r['name'];?></p></h5>
							<?php
					$sql = "select * FROM paydetails ORDER BY name ";
					$sresults = $db->query($sql);
				?>
				<form action="payment.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
				<legend>Staff Payroll</legend>
					<div class="form-group mx-sm-3  mb-2">
					<label for="gross">Gross*:</label><br>
					<?php 
						if($type=='contract'){
						$q="select * from paydetails where type='Gross' AND not(name = 'basic') AND not(name = 'contract')";
						
						}else{
						$q ="select * from paydetails where type='Gross' AND not(name = 'contract')";	
						}
						$query2 = $db->query($q);
						$counter=0;
							while($school = mysqli_fetch_assoc($query2)) : 
								$id = $school['paydetailsid'];
								$name = $school['name'];
					?>
						<input						
						type = "checkbox" name= "gross[<?=$counter;?>]" value ="<?=$id;?>"/> <?=$name;?>
						<input type="number" class="form-control col-md-3" name="gamount[<?=$counter;?>]" /> <br>
						<?php 
						$counter++;
						endwhile;?>
					</div>
					<div class="form-group mx-sm-3  mb-2">
					<label for="duduction">Deduction*:</label><br>
					<?php 
						$query2 = $db->query("select * from paydetails where type='Deduction'");
						$counter=0;
							while($school = mysqli_fetch_assoc($query2)) : 
								$id = $school['paydetailsid'];
								$name = $school['name'];
					?>
						<input						
						type = "checkbox" name= "deduction[<?=$counter;?>]" value ="<?=$id;?>"/> <?=$name;?>
						<input type="number" class="form-control col-md-3" name="damount[<?=$counter;?>]" /> <br>
						<?php 
						$counter++;
						endwhile;?>
					</div>
					
					<div id="parent1" class="formset">
					<legend>Contract Employee Additional Information</legend>
					<?php
					$query2 = $db->query("select * from paydetails where name = 'contract'");
							$school = mysqli_fetch_assoc($query2);
							$name = $school['paydetailsid'];
					?>
					<div class="form-group">
					
						<label for="hours">Hours Worked*:</label>
						<input type="number" <?=$dis;?> min="0" step=".01" <?=$req;?> class="form-control col-md-3" name="hours" id="hours" />
						<input type="hidden" <?=$dis;?> <?=$req;?> value="<?=$name;?>" name="name" id="name" />
					</div>
					<div class="form-group">
						<label for="rate">Rate*:</label>
						<input type="number" min="0" <?=$dis;?> step=".01" <?=$req;?> class="form-control col-md-3" name="rate" id="rate" />
					</div>
					</div>
					<a href="payment.php" class="btn btn-default">Cancel</a>
					<input type="submit" onClick="javascript: return confirm('Are You Sure?');" id="checkBtn" value="Proceed with Staff Payroll" class="btn btn-success" />
				</form>
				</div>
			</div>
			<br>
		</div>
				<?php
		}else{
			$sql = "select * from staff";
			$sresults = $db->query($sql);
		?>
<div class="container">
      <div class="row">
	  <div class="col-md-12" align="">
	  <br>
<div class="clearfix"></div>
		  		<h2 class="text-center">Staff Payroll</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Staff ID:</th>
						<th>Name</th>
						<th>Department</th>
						<th>job Title</th>
						<th>Contract Type</th>
						<th>Leave Days pey Year</th>
						<th>Net Leave Days</th>
						<th>Employment Start Date</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						
						$id = $school['staffid'];
						$name = $school['name'];
						$code = $school['department'];
						$type = $school['jtitle'];
						$title = $school['type'];
						$leave = $school['leaves'];
						$net = $school['netleave'];
						$estart = $school['estart'];
					?>
					<tr>
						
						<td><?=$id;?></td>
						<td><?=$name;?></td>
						<td><?=$code;?></td>
						<td><?=$type;?></td>
						<td><?=$title;?></td>
						<td><?=$leave;?></td>
						<td><?=$net;?></td>
						<td><?=$estart;?></td>
						<td><a href="payment.php?edit=<?=$id;?>" class="btn btn-primary">Proceed</a></td>
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
   <br>
   
  </body>
  
<?php
}
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
	

	

	