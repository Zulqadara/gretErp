<?php
require_once '../core.php';
include 'includes/header.php';
 include 'includes/navigation.php';
$errors = array();
$year = date("Y");
if(isset($_GET['update'])){
	$update_id = (int)$_GET['update'];
	$db->query("UPDATE staff set anetleaves = anetleaves + aleaves,
	snetleaves = snetleaves + sleaves,
	mnetleaves = mnetleaves + mleaves,
	pnetleaves = pnetleaves + pleaves,
	leaveupdate='$year' where staffid='$update_id'");
	header('Location: staff.php');
}
if(isset($_GET['add']) || isset($_GET['edit'])){
	
	$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):'');
	$idnumber = ((isset($_POST['idnumber']) && $_POST['idnumber'] !='')?ss($_POST['idnumber']):'');
	$phone = ((isset($_POST['phone']) && $_POST['phone'] !='')?ss($_POST['phone']):'');
	$nok = ((isset($_POST['nok']) && $_POST['nok'] !='')?ss($_POST['nok']):'');
	$relationship = ((isset($_POST['relationship']) && $_POST['relationship'] !='')?ss($_POST['relationship']):'');
	$nokphone = ((isset($_POST['nokphone']) && $_POST['nokphone'] !='')?ss($_POST['nokphone']):'');
	$aqualification = ((isset($_POST['aqualification']) && $_POST['aqualification'] !='')?ss($_POST['aqualification']):'');
	$email = ((isset($_POST['email']) && $_POST['email'] !='')?ss($_POST['email']):'');
	$oemail = ((isset($_POST['oemail']) && $_POST['oemail'] !='')?ss($_POST['oemail']):'');
	$department = ((isset($_POST['department']) && $_POST['department'] !='')?ss($_POST['department']):'');
	$jtitle = ((isset($_POST['jtitle']) && $_POST['jtitle'] !='')?ss($_POST['jtitle']):'');
	$sleaves = ((isset($_POST['sleaves']) && $_POST['sleaves'] !='')?ss($_POST['sleaves']):'');
	$aleaves = ((isset($_POST['aleaves']) && $_POST['aleaves'] !='')?ss($_POST['aleaves']):'');
	$pleaves = ((isset($_POST['pleaves']) && $_POST['pleaves'] !='')?ss($_POST['pleaves']):'');
	$mleaves = ((isset($_POST['mleaves']) && $_POST['mleaves'] !='')?ss($_POST['mleaves']):'');
	$type = ((isset($_POST['type']) && $_POST['type'] !='')?ss($_POST['type']):'');
	$start = ((isset($_POST['start']) && $_POST['start'] !='')?ss($_POST['start']):'');
	$end = ((isset($_POST['end']) && $_POST['end'] !='')?ss($_POST['end']):'');
	$estart = ((isset($_POST['estart']) && $_POST['estart'] !='')?ss($_POST['estart']):'');
	$bank = ((isset($_POST['bank']) && $_POST['bank'] !='')?ss($_POST['bank']):'');
	$ac = ((isset($_POST['ac']) && $_POST['ac'] !='')?ss($_POST['ac']):'');
	$branch = ((isset($_POST['branch']) && $_POST['branch'] !='')?ss($_POST['branch']):'');
	
			if(isset($_GET['edit'])){
			$edit_id = (int)$_GET['edit'];
			$Q = $db->query("SELECT * FROM staff left join staffcontract on staff.staffid = staffcontract.staffid where staff.staffid = '$edit_id'");
			$r = mysqli_fetch_assoc($Q);
			
			$name = ((isset($_POST['name']) && $_POST['name'] !='')?ss($_POST['name']):$r['name']);
			$idnumber = ((isset($_POST['idnumber']) && $_POST['idnumber'] !='')?ss($_POST['idnumber']):$r['idnumber']);
			$phone = ((isset($_POST['phone']) && $_POST['phone'] !='')?ss($_POST['phone']):$r['phone']);
			$nok = ((isset($_POST['nok']) && $_POST['nok'] !='')?ss($_POST['nok']):$r['nok']);
			$relationship = ((isset($_POST['relationship']) && $_POST['relationship'] !='')?ss($_POST['relationship']):$r['relationship']);
			$nokphone = ((isset($_POST['nokphone']) && $_POST['nokphone'] !='')?ss($_POST['nokphone']):$r['nokphone']);
			$aqualification = ((isset($_POST['aqualification']) && $_POST['aqualification'] !='')?ss($_POST['aqualification']):$r['aqualification']);
			$email = ((isset($_POST['email']) && $_POST['email'] !='')?ss($_POST['email']):$r['email']);
			$oemail = ((isset($_POST['oemail']) && $_POST['oemail'] !='')?ss($_POST['oemail']):$r['oemail']);
			$department = ((isset($_POST['department']) && $_POST['department'] !='')?ss($_POST['department']):$r['department']);
			$jtitle = ((isset($_POST['jtitle']) && $_POST['jtitle'] !='')?ss($_POST['jtitle']):$r['jtitle']);
			$sleaves = ((isset($_POST['sleaves']) && $_POST['sleaves'] !='')?ss($_POST['sleaves']):$r['sleaves']);
			$aleaves = ((isset($_POST['aleaves']) && $_POST['aleaves'] !='')?ss($_POST['aleaves']):$r['aleaves']);
			$mleaves = ((isset($_POST['mleaves']) && $_POST['mleaves'] !='')?ss($_POST['mleaves']):$r['mleaves']);
			$pleaves = ((isset($_POST['pleaves']) && $_POST['pleaves'] !='')?ss($_POST['pleaves']):$r['pleaves']);
			$type = ((isset($_POST['type']) && $_POST['type'] !='')?ss($_POST['type']):$r['type']);
			$start = ((isset($_POST['start']) && $_POST['start'] !='')?ss($_POST['start']):$r['start']);
			$estart = ((isset($_POST['estart']) && $_POST['estart'] !='')?ss($_POST['estart']):$r['estart']);
			$end = ((isset($_POST['end']) && $_POST['end'] !='')?ss($_POST['end']):$r['end']);
			$bank = ((isset($_POST['bank']) && $_POST['bank'] !='')?ss($_POST['bank']):$r['bank']);
			$ac = ((isset($_POST['ac']) && $_POST['ac'] !='')?ss($_POST['ac']):$r['ac']);
			$branch = ((isset($_POST['branch']) && $_POST['branch'] !='')?ss($_POST['branch']):$r['branch']);
		}
		
		if($_POST){
		
		$errors = array();
		$r = implode(',', $_POST['roles']);	
		$roles = ss($r);
		$required = array('name', 'idnumber', 'phone', 'nok', 'relationship', 'nokphone', 'aqualification', 'email', 'oemail', 'department',
 'jtitle', 'type', 'sleaves','aleaves','mleaves','pleaves', 'estart', 'roles', 'bank', 'ac', 'branch');
		foreach ($required as $field){
			if($_POST[$field] == ''){
				$errors[] = 'All Fields With an Asterisk are Required!';
				break;
			}
		}
				if(!isset($_GET['edit'])){
				$valQ = $db->query("SELECT * FROM staff WHERE idnumber='$idnumber'");
				$valC = mysqli_num_rows($valQ);
					
				if($valC != 0){
					$errors[] = 'That Staff No Already Exists.';
				}
				}
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			$insertSql = "INSERT INTO staff (name, idnumber, phone, nok, relationship, nokphone, 
			aqualification, email, oemail, department, jtitle, type, `sleaves`, `aleaves`, `mleaves`, `pleaves`, leaveupdate, estart, spasss, roles, bank, ac, branch)
			VALUES ('$name', 'GS/$idnumber', '$phone', '$nok', '$relationship', '$nokphone', '$aqualification', '$email',
			 '$oemail', '$department', '$jtitle', '$type', '$sleaves', '$aleaves','$mleaves','$pleaves', '$year', '$estart', 'pass123', '$roles', '$bank', '$ac', '$branch')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE staff SET name='$name', idnumber='$idnumber', phone='$phone', 
				nok='$nok', relationship='$relationship', nokphone='$nokphone', aqualification='$aqualification', email='$email',
				oemail='$oemail', department='$department', jtitle='$jtitle', type='$type', `sleaves`='$sleaves', `aleaves`='$aleaves', `mleaves`='$mleaves', `pleaves`='$pleaves', estart='$estart', roles='$roles',
				bank='$bank', ac='$ac', branch='$branch'
				WHERE staffid='$edit_id'";
			}
			$db->query($insertSql);
			$staffid = $db->insert_id;
			//how to get update id
			if($type=='contract'){
				$insertSql = "INSERT INTO staffcontract (staffid, start, end)
			VALUES ('$staffid', '$start', '$end')";
			if(isset($_GET['edit'])){
				$insertSql = "UPDATE staffcontract SET start='$start', end='$end'
				WHERE staffid='$edit_id'";
			}
			$db->query($insertSql);
			}
			header('Location: staff.php');
		}
	}
?> 
  <body>
<script type="text/javascript">
$(document).ready(function () {
    $('#checkBtn').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        alert("You must check at least one ERP checkbox is ticked.");
        return false;
      }

    });
});

</script>
    <!-- Navigation -->
<br>
    <div class="container">

      <div class="row">

       
        <div class="col-md-12" align="">
			<h3 class="text-center"><?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Staff</h3><hr>
				<form action="staff.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1') ;?>" method="post" enctype="multipart/form-data">
				<legend>Staff Bio Data</legend>
					<div class="form-group">
						<label for="name">Name*:</label>
						<input type="text" class="form-control" name="name" id="name" value="<?=$name; ?>" required/>
					</div>
					<div class="form-group">
						<label for="idnumber">Staff Number*:</label>
						<input type="number" min="0" class="form-control" name="idnumber" id="idnumber" value="<?=$idnumber; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="phone">Phone Number*:</label>
						<input type="number" min="0" class="form-control" name="phone" id="phone" value="<?=$phone; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="nok">Next of Kin Name*:</label><br>
						<input type="text" class="form-control" name="nok" id="nok" value="<?=$nok; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="relationship">Relationship*:</label><br>
						<input type="text" class="form-control" name="relationship" id="relationship" value="<?=$relationship; ?>"  required/>
					</div>
						<div class="form-group">
						<label for="nokphone">Phone Numbe of Next of Kin*:</label><br>
						<input type="number" min="0" class="form-control" name="nokphone" id="nokphone" value="<?=$nokphone; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="aqualification">Academic Qualification*:</label>
						<input type="text" class="form-control" name="aqualification" id="aqualification" value="<?=$aqualification; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="email">Personal Email*:</label>
						<input type="email" class="form-control" name="email" id="email" value="<?=$email; ?>"  required/>
					</div>	
					<legend>Employment Details</legend>

					<div class="form-group">
						<label for="oemail">Official Email*:</label>
						<input type="email" class="form-control" name="oemail" id="oemail" value="<?=$oemail; ?>"  required/>
					</div>					
					<div class="form-group">
						<label for="department">School/Department*:</label>
						<input type="text" class="form-control" name="department" id="department" value="<?=$department; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="jtitle">Job Title*:</label>
						<input type="text" class="form-control" name="jtitle" id="jtitle" value="<?=$jtitle; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="aleaves">Annual Leave Days per year*:</label>
						<input type="number" class="form-control" name="aleaves" id="aleaves" value="<?=$aleaves; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="sleaves">Sick Leave Days per year*:</label>
						<input type="number" class="form-control" name="sleaves" id="sleaves" value="<?=$sleaves; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="mleaves">Maternity Leave Days per year*:</label>
						<input type="number" class="form-control" name="mleaves" id="mleaves" value="<?=$mleaves; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="pleaves">Paternity Leave Days per year*:</label>
						<input type="number" class="form-control" name="pleaves" id="pleaves" value="<?=$pleaves; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="bank">Bank Name*:</label>
						<input type="text" class="form-control" name="bank" id="bank" value="<?=$bank; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="ac">A/c No.*:</label>
						<input type="text" class="form-control" name="ac" id="ac" value="<?=$ac; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="branch">Bank Branch*:</label>
						<input type="text" class="form-control" name="branch" id="branch" value="<?=$branch; ?>"  required/>
					</div>
					<div class="form-group">
						<label for="estart">Start of Employment*:</label>
						<input type="date" class="form-control" name="estart" id="estart" value="<?=$estart; ?>" />
					</div>
					<div class="form-group">
						<label for="type">Employment Type*:</label><br>
						<input type="radio" name="type" value="permanent"  class="etype" 
						<?php 
							if($type=="permanent"){
								echo "checked=checked";
							}
						?>> Permanent<br>
						<input type="radio" name="type" value="contract" class="etype" 
						<?php 
							if($type=="contract"){
								echo "checked=checked";
							}
						?>
						> Contract<br>
					</div>
					
					<div id="parent1" class="formset">
					<div class="form-group">
						<label for="start">Contract Start*:</label>
						<input type="date" class="form-control" name="start" id="start" value="<?=$start; ?>" />
					</div>
					<div class="form-group">
						<label for="end">Contract End*:</label>
						<input type="date" class="form-control" name="end" id="end" value="<?=$end; ?>" />
					</div>
					</div>
					<div class="form-group mx-sm-3  mb-2">
					<label for="roles">ERP Roles*:</label><br>
					<?php 
						$query2 = $db->query("select * from erproles");
							while($school = mysqli_fetch_assoc($query2)) : 
								$name = $school['name'];
					?>
						<input
						<?php 
							if(isset($_GET['edit'])){
							$res = $db->query("SELECT * FROM staff where staffid = '$edit_id'");
							$num=mysqli_num_rows($res);
							$s = mysqli_fetch_assoc($res);
							$item = explode(",", $s['roles']);
							
							if($num){
								foreach($item as $items){
									if($name == $items){
									echo "checked";
									}
								}
							}
							}
						?>
						
						type = "checkbox"  name= "roles[]" value ="<?=$name;?>"/> <?=$name;?> <br>
						<?php endwhile;?>
					</div>
					
					<a href="staff.php" class="btn btn-default">Cancel</a>
					<input type="submit" id="checkBtn" value="<?=((isset($_GET['edit']))?'Edit ':'Add ') ;?> Staff" class="btn btn-success" />
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
	  <a href="staff.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Add Staff</a>
<div class="clearfix"></div>
		  		<h2 class="text-center">Staff</h2><hr>

			<table id="table_id" class="display responsive" width="100%">
				<thead>
					<tr>
						<th>Staff No:</th>
						<th>Name</th>
						<th>Department</th>
						<th>job Title</th>
						<th>Contract Type</th>
						<th>Annual Leave Days pey Year</th>
						<th>Annual Net Leave Days</th>
						<th>Sick Leave Days pey Year</th>
						<th>Sick Net Leave Days</th>
						<th>Maternity Leave Days pey Year</th>
						<th>Maternity Net Leave Days</th>
						<th>Paternity Leave Days pey Year</th>
						<th>Paternity Net Leave Days</th>
						<th>Employment Start Date</th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					<?php while($school = mysqli_fetch_assoc($sresults)) : 
						$id = $school['staffid'];
						$id2 = $school['idnumber'];
						$name = $school['name'];
						$code = $school['department'];
						$type = $school['jtitle'];
						$title = $school['type'];
						$leave = $school['aleaves'];
						$net = $school['anetleaves'];
						$sleave = $school['sleaves'];
						$snet = $school['snetleaves'];
						$mleave = $school['mleaves'];
						$mnet = $school['mnetleaves'];
						$pleave = $school['pleaves'];
						$pnet = $school['pnetleaves'];
						$estart = $school['estart'];
					?>
					<tr>
						<td><?=$id2;?></td>
						<td><?=$name;?></td>
						<td><?=$code;?></td>
						<td><?=$type;?></td>
						<td><?=$title;?></td>
						
						<td><?=$leave;?></td>
						<td><?=$net;?></td>
						<td><?=$sleave;?></td>
						<td><?=$snet;?></td>
						<td><?=$mleave;?></td>
						<td><?=$mnet;?></td>
						<td><?=$pleave;?></td>
						<td><?=$pnet;?></td>
						
						<td><?=$estart;?></td>
						<td><a href="staff.php?edit=<?=$id;?>" class="btn btn-primary">Edit</a></td>
						<?php
							$res = $db->query("SELECT * FROM staff WHERE staffid='$id' and leaveupdate < '$year'");
							$num=mysqli_num_rows($res);
							if($num): ?>
								<td><a href="staff.php?update=<?=$id;?>" class="btn btn-success">Update All Yearly Leave Days</a></td>
						<?php endif; ?>
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
	
	<script>
	$(document).ready(function(){
    $("#parent1").css("display","none");
        $(".etype").click(function(){
        if ($('input[name=type]:checked').val() == "contract" ) {
            $("#parent1").slideDown("fast"); //Slide Down Effect
        } else {
            $("#parent1").slideUp("fast");  //Slide Up Effect
        }
     });
});
	</script>
	

	