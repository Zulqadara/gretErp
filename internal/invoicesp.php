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
	$tos = $_POST['tos'];
	$froms = $_POST['froms'];

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
$date =  date("F j, Y", strtotime($tos));
$date2 =  date("F j, Y", strtotime($froms));
$date3 =  date("F j, Y");
$pdf->Cell(40,30,'Report Print Date: '.$date3 .'. Processed By:' .$st['staffid'].' - '.$st['name']);

$pdf->SetFont('Arial','B',14);
$pdf->Cell(40,10,'INVOICES: '.$date .' - '.$date2);
 

$pdf->SetDrawColor(0, 0, 0); 
 

$pdf->SetFillColor(170, 170, 170); 
$pdf->setFont("Arial","B","9");
$pdf->setXY(10, 40); 
$pdf->Cell(10, 10, "#", 1, 0, "L", 1); 
$pdf->Cell(30, 10, "Student Number", 1, 0, "L", 1); 
$pdf->Cell(40, 10, "Fees Type", 1, 0, "L", 1); 
$pdf->Cell(40, 10, "Amount", 1, 0, "L", 1); 
$pdf->Cell(30, 10, "Paid", 1, 0, "L", 1); 
$pdf->Cell(40, 10, "Date & Time", 1, 0, "L", 1); 

$y = 50;
$x = 10;  
 
$pdf->setXY($x, $y);
 
$pdf->setFont("Arial","","9");

$query_result = "select *,student.studentnumber as stnum, fees.name as fname FROM studentinvoice st
			inner join feestypes fees on fees.feestypesid = st.feesid
			inner join studentfees on studentfees.studentfeesid = st.studentfeesid
										inner join studentprogramme on studentfees.studentprogrammeid = studentprogramme.studentprogrammeid
										inner join student on studentprogramme.studentid = student.studentid
			WHERE date(st.dt) BETWEEN '$tos' AND '$froms';"; 
$result = $db->query($query_result) or die(mysql_error());
 $count=1;
while($row = mysqli_fetch_array($result))
{
        $pdf->Cell(10, 8, $count, 1);
        $pdf->Cell(30, 8, $row['stnum'], 1);
        $pdf->Cell(40, 8, $row['fname'], 1);
		$pdf->Cell(40, 8, $row['amount'].'/=', 1);
		$pdf->Cell(30, 8, $row['paid'].'/=', 1);
		$pdf->Cell(40, 8, $row['dt'], 1);
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