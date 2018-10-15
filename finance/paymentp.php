<?php
//require_once '../core.php';
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
if(isset($_GET['pQid'])){
	$pQid = (int)$_GET['pQid'];
	
	$ddate = date("Y-m-d");
	$year = date("Y",  strtotime($ddate));
	$month = date("m",  strtotime($ddate));
	$day = date("d",  strtotime($ddate));

class PDF extends FPDF
{
function Header()
{
	$this->SetFont('Arial','B');
	$this->Cell(40,10,'                                                                                                                       Gretsa University',0,1, 'C');
   // $this->Image('logo.png',10,8,33);
   
}
 
//Page footer
function Footer()
{
    //Position at 1.5 cm from bottom
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
 
 
$pdf = new PDF();
$pdf->open();
$pdf->AddPage();
$pdf->AliasNbPages();   
$pdf->SetAutoPageBreak(false);
 

$pdf->SetAuthor('...');
$pdf->SetTitle('Payslip');



$pdf->SetFont('Arial','I',10);
$date =  date("F j, Y", strtotime($ddate));
$date3 =  date("F j, Y");
$pdf->Cell(40,30,'Report Print Date: '.$date3 .'. Processed By:' .$st['staffid'].' - '.$st['name']);

$pdf->SetFont('Arial','B',14);
$pdf->Cell(40,10,'                              Payslip');
 
$pdf->SetDrawColor(0, 0, 0); 
 
//table header
$pdf->SetFillColor(170, 170, 170); 
$pdf->setFont("Arial","B","9");
$pdf->setXY(10, 40); 
$pdf->Cell(20, 10, "Staff ID", 1, 0, "L", 1);  
$pdf->Cell(25, 10, "Gross", 1, 0, "L", 1); 
$pdf->Cell(25, 10, "Deductions", 1, 0, "L", 1); 
$pdf->Cell(25, 10, "PAYE", 1, 0, "L", 1); 
$pdf->Cell(25, 10, "NSSF", 1, 0, "L", 1); 
$pdf->Cell(25, 10, "NHIF", 1, 0, "L", 1); 
$pdf->Cell(25, 10, "NET", 1, 0, "L", 1); 
$pdf->Cell(25, 10, "Date", 1, 0, "L", 1); 

$y = 50;
$x = 10;  
 
$pdf->setXY($x, $y);
 
$pdf->setFont("Arial","","9");
$query_result = "select *, DATE(dt) as d FROM payroll where payrollid='$pQid'"; 
$result = $db->query($query_result) or die(mysql_error());
 
while($row = mysqli_fetch_array($result))
{
        $pdf->Cell(20, 8, $row['staffid'], 1);
        $pdf->Cell(25, 8, $row['gross'].'/=', 1);
		$pdf->Cell(25, 8, $row['deductions'].'/=', 1);
		$pdf->Cell(25, 8, $row['paye'].'/=', 1);
		$pdf->Cell(25, 8, $row['nssf'].'/=', 1);
		$pdf->Cell(25, 8, $row['nhif'].'/=', 1);
		$pdf->Cell(25, 8, $row['net'].'/=', 1);
		$pdf->Cell(25, 8, $row['d'], 1);
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