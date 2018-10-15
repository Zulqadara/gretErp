<?php
require_once '../../core.php';

$schoolid = (int)$_POST['schoolid'];//comes from ajax post
$programQuery = $db->query("SELECT * FROM programs WHERE schoolid='$schoolid' order by name");

$selected = ss($_POST['selected']);

ob_start();
?>

<option value=""></option>
<?php while($program = mysqli_fetch_assoc($programQuery)) : ?>
<option value="<?= $program['programsid']; ?>"<?=(($selected == $program['programsid'])?' selected':'') ;?>><?= $program['name']; ?></option>
<?php endwhile; ?>

<?php
echo ob_get_clean();
?>