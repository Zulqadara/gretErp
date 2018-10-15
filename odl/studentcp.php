<?php

require('../fpdf/fpdf.php');
require_once '../core.php'; 
$dname = basename(__DIR__);
	if($_SESSION['staffuser']['role']!=$dname){
	 header('location:../login.php');
	 exit();
	}
	$staffid = $_SESSION['staffuser']['userid'];
	$stR = $db->query("SELECT staffid, idnumber, name FROM staff WHERE staffid='$staffid'");
	$st = mysqli_fetch_assoc($stR);
if(isset($_POST['print'])){
$semester = $_POST['semester'];
$year = $_POST['year'];
$stage = $_POST['stage'];
$school = $_POST['school'];
$programs = $_POST['programs'];
$units = $_POST['units'];

class PDF extends FPDF
{

function Header()
{
	$this->SetFont('Arial','B');
	$this->Cell(40,10,'                                                                                                                       Gretsa University',0,1, 'C');
    
    //Logo
   // $this->Image('logo.png',10,8,33);
   
}
 

function Footer()
{
   
    $this->SetY(-15);
    
    $this->SetFont('Arial','I',8);
    
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
 
 
$pdf = new PDF();
$pdf->open();
$pdf->AddPage();
$pdf->AliasNbPages();   
$pdf->SetAutoPageBreak(false);
 

$pdf->SetAuthor('...');
$pdf->SetTitle('Report');


$pdf->SetFont('Arial','I',10);
$date3 =  date("F j, Y");
$pdf->Cell(40,30,'Report Print Date: '.$date3 .'. Processed By:' .$st['staffid'].' - '.$st['name']);

$pdf->SetFont('Arial','B',14);
$pdf->Cell(90,10,'Active ODL Students per Course', 0,1,0);

$result2 = $db->query("select name, code from courses where coursesid = '$units'") ;
 $row2 = mysqli_fetch_array($result2);
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(40,30,$row2['name'].' - ' . $row2['code'], 0,1,'L');
$pdf->SetDrawColor(0, 0, 0); 
 

$pdf->SetFillColor(170, 170, 170); 
$pdf->setFont("Arial","B","9");
$pdf->setXY(10, 50); 
$pdf->Cell(60, 10, "Student Number", 1, 0, "L", 1); 


$y = 60;
$x = 10;  
 
$pdf->setXY($x, $y);
 
$pdf->setFont("Arial","","9");

$query_result = "select student.studentnumber as c, courses.name from student
inner join activestudent on activestudent.studentid = student.studentid
inner join stypes on stypes.stypeid = student.`mode`
inner join studentprogramme on  student.studentid = studentprogramme.studentid
inner join studentunits on studentunits.studentprogrammeid = studentprogramme.studentprogrammeid
inner join courses on courses.coursesid = studentunits.unitid
where activestudent.semester='$semester' and studentprogramme.`year`='$year' and studentprogramme.stage='$stage'
and studentprogramme.school='$school' and studentprogramme.programmeid='$programs' and stypes.name='Distance Learning' 
and studentunits.status='1' and studentunits.unitid='$units'"; 
$result = $db->query($query_result);
while($row = mysqli_fetch_array($result))
{
        $pdf->Cell(60, 8, $row['c'], 1);
        $y += 8;
        
        if ($y > 260)   
		{
            $pdf->AddPage();
            $y = 40;
			
		}
        
        $pdf->setXY($x, $y);
}
 
$pdf->Output();
}