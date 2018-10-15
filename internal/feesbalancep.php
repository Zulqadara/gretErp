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
	$tos = ($_POST['tos']);
	$froms = ($_POST['froms']);
	$type = ($_POST['type']);

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
$date =  date("F j, Y", strtotime($tos));
$date2 =  date("F j, Y", strtotime($froms));
$date3 =  date("F j, Y");
$pdf->SetFont('Arial','B',14);
$pdf->Cell(140,10,'Fees With Balance per Payable Item: ', 0, 1, 0);
$pdf->Cell(135,10,$date .' - '.$date2, 0, 1, 0);
$pdf->SetFont('Arial','I',10);
$pdf->Cell(40,30,'Report Print Date: '.$date3 .'. Processed By:' .$st['staffid'].' - '.$st['name']);


 

$pdf->SetDrawColor(0, 0, 0); 
 

$pdf->SetFillColor(170, 170, 170); 
$pdf->setFont("Arial","B","9");
$pdf->setXY(10, 60); 
$pdf->Cell(10, 10, "#", 1, 0, "L", 1); 
$pdf->Cell(30, 10, "Student Number", 1, 0, "L", 1); 
$pdf->Cell(30, 10, "Fees Type", 1, 0, "L", 1); 
$pdf->Cell(40, 10, "Amount", 1, 0, "L", 1); 
$pdf->Cell(20, 10, "Paid", 1, 0, "L", 1); 
$pdf->Cell(20, 10, "Balance", 1, 0, "L", 1); 
$pdf->Cell(40, 10, "Date & Time", 1, 0, "L", 1); 

$y = 70;
$x = 10;  
 
$pdf->setXY($x, $y);
 
$pdf->setFont("Arial","","9");
$query_result = "select student.studentnumber as stnum, feestypes.name as name,  amount, paid, (amount - paid) as balance, studentinvoice.dt as dt1 from studentinvoice
										inner join feestypes on feestypes.feestypesid = studentinvoice.feesid
											inner join studentfees on studentfees.studentfeesid = studentinvoice.studentfeesid
										inner join studentprogramme on studentfees.studentprogrammeid = studentprogramme.studentprogrammeid
										inner join student on studentprogramme.studentid = student.studentid
										WHERE date(studentinvoice.dt) BETWEEN '$tos' AND '$froms' and studentinvoice.feesid='$type'
										having balance > 0;"; 
$result = $db->query($query_result) or die(mysql_error());
 $count=1;
while($row = mysqli_fetch_array($result))
{
        $pdf->Cell(10, 8, $count, 1);
        $pdf->Cell(30, 8, $row['stnum'], 1);
        $pdf->Cell(30, 8, $row['name'], 1);
		$pdf->Cell(40, 8, $row['amount'].'/=', 1);
		$pdf->Cell(20, 8, $row['paid'].'/=', 1);
		$pdf->Cell(20, 8, $row['balance'].'/=', 1);
		$pdf->Cell(40, 8, $row['dt1'], 1);
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