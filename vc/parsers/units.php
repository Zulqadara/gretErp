<?php
require_once '../../core.php';

$programid = (int)$_POST['programid'];//comes from ajax post
$Qr = "SELECT * FROM courses WHERE programsid='$programid' order by name";
$selected = ss($_POST['selected']);
if($programid == ''){
	$Qr = "SELECT * FROM courses WHERE coursesid='$selected' order by name";
}
$unitQuery = $db->query($Qr);
ob_start();
?>

<option value="<?= $selected; ?>"><?= $selected; ?></option>
<?php while($unit = mysqli_fetch_assoc($unitQuery)) : ?>
<option value="<?= $unit['coursesid']; ?>"<?=(($selected == $unit['coursesid'])?' selected':'') ;?>><?= $unit['name']; ?></option>
<?php endwhile; ?>

<?php
echo ob_get_clean();
?>