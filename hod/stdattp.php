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
$pdf->Cell(75,10,'Student Attendance', 0,1,0);

$result2 = $db->query("select name, code from courses where coursesid = '$units'") ;
 $row2 = mysqli_fetch_array($result2);
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(40,30,$row2['name'].' - ' . $row2['code'], 0,1,'L');
$pdf->SetDrawColor(0, 0, 0); 
 

$pdf->SetFillColor(170, 170, 170); 
$pdf->setFont("Arial","B","9");
$pdf->setXY(10, 50); 
$pdf->Cell(10, 10, "#", 1, 0, "L", 1); 
$pdf->Cell(60, 10, "Student Number", 1, 0, "L", 1); 
$pdf->Cell(60, 10, "Classes Attended", 1, 0, "L", 1); 


$y = 60;
$x = 10;  
 
$pdf->setXY($x, $y);
 
$pdf->setFont("Arial","","9");

$query_result = "select student.studentnumber as c, count( student.studentnumber) as ct from student
inner join studentattendance on student.studentid = studentattendance.studentid
where studentattendance.semester='$semester' and studentattendance.`year`='$year' and studentattendance.stage='$stage' and 
studentattendance.unitid='$units' and studentattendance.status='Present'
group by student.studentid"; 
$result = $db->query($query_result);
$count=1;
while($row = mysqli_fetch_array($result))
{
        $pdf->Cell(10, 8, $count, 1);
        $pdf->Cell(60, 8, $row['c'], 1);
        $pdf->Cell(60, 8, $row['ct'], 1);
        $y += 8;
        
        if ($y > 260)   
		{
            $pdf->AddPage();
            $y = 40;
			
		}
        
        $pdf->setXY($x, $y);
		$count++;
}
 
$pdf->Output();
}