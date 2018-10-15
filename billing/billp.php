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
if(isset($_GET['unit'])){
	$studentid = $_GET['add'];
	$studentp = $_GET['unit'];
	$date4=date("Y-m-d");

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
$pdf->Cell(60,10,'INVOICE', 0,1,0);

$result2 = $db->query("select student.studentnumber as snum, 
			student.name as sname, sc.name as scname, p.name as pname, ys.name as yname, stg.name as stgname, sp.dt as sdt
			FROM studentprogramme sp
			inner join student on sp.studentid = student.studentid
			inner join schools sc on sc.schoolid = sp.school
			inner join programs p on p.programsid = sp.programmeid
			inner join yearsofstudy ys on ys.yearsid = sp.year
			inner join stages stg on stg.stagesid = sp.stage
			WHERE sp.studentid = '$studentid' and sp.studentprogrammeid = '$studentp';") ;
 $row2 = mysqli_fetch_array($result2);
 $pdf->SetFont('Arial','B',10);
 $pdf->Cell(40,30,'Student Number and Name: '.$row2['snum'].'-'.$row2['sname'], 0,1,'L');
 $pdf->Cell(40,-15,$row2['scname'], 0,1,'L');
 $pdf->Cell(40,30,$row2['pname'], 0,1,'L');
 $pdf->Cell(40,-15,$row2['yname'], 0,1,'L');
$pdf->Cell(40,30,$row2['stgname'], 0,1,'L');
$pdf->Cell(40,-15,$row2['sdt'], 0,1,'L');
$pdf->SetDrawColor(0, 0, 0); 
 

$pdf->SetFillColor(170, 170, 170); 
$pdf->setFont("Arial","B","9");
$pdf->setXY(10, 90); 
$pdf->Cell(60, 10, "Fees Type", 1, 0, "L", 1); 
$pdf->Cell(60, 10, "Amount", 1, 0, "L", 1); 

$y = 100;
$x = 10;  
 
$pdf->setXY($x, $y);
 
$pdf->setFont("Arial","","9");

$query_result = "select f.name as fname, (si.amount) as balance FROM studentprogramme sp
			inner join student on sp.studentid = student.studentid
			inner join studentfees sf on sf.studentprogrammeid = sp.studentprogrammeid
			inner join studentinvoice si on si.studentfeesid = sf.studentfeesid
			inner join feestypes f on f.feestypesid = si.feesid
			WHERE sp.studentid = '$studentid' and sp.studentprogrammeid = '$studentp'
			
			;"; 
$result = $db->query($query_result);
$total=0;
while($row = mysqli_fetch_array($result))
{
        $pdf->Cell(60, 8, $row['fname'], 1);
		 $pdf->Cell(60, 8, $row['balance'].'/=', 1);
		 $total+=$row['balance'];
        $y += 8;
        
        if ($y > 260)   
		{
            $pdf->AddPage();
            $y = 40;
			
		}
        
        $pdf->setXY($x, $y);
}
$pdf->setFont("Arial","B","10");
 $pdf->Cell(60, 8, 'Total', 1);
 $pdf->Cell(60, 8, $total.'/=', 1);
$pdf->Output();
}