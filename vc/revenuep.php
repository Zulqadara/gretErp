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
 
 $date = date("Y-m-d");
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
$pdf->Cell(40,10,'Statement of Revenue Allocation');
 

$pdf->SetDrawColor(0, 0, 0); 
 

$pdf->SetFillColor(170, 170, 170); 
$pdf->setFont("Arial","B","9");
$pdf->setXY(10, 50); 
//$pdf->Cell(10, 10, "#", 1, 0, "L", 1); 
$pdf->Cell(60, 10, "Expense Type Name", 1, 0, "L", 1); 

$pdf->Cell(60, 10, "Amount Allocated", 1, 0, "L", 1); 

$pdf->Cell(60, 10, "Amount Spent", 1, 0, "L", 1); 

$y = 60;
$x = 10;  
 
$pdf->setXY($x, $y);
 
$pdf->setFont("Arial","","10");

$query_result = "select *
from budget bud
left outer join 
(
select sum(pet.amount) as pam ,  pet.pettyid, 
pet.semesterid, pet.dt, pet.expenseid, ex.`status`, exc.expensecodeid, exc.name
from petty as pet
inner join expense as ex 
on ex.expenseid = pet.expenseid
inner join expensecode exc 
on ex.expensecodeid = exc.expensecodeid
group by exc.expensecodeid
) as t
on bud.expensecodeid = t.expensecodeid
where year(bud.dt) = '$date' and year(t.dt) = '$date'
 and bud.semester='$semester' and t.semesterid='$semester' 
 and t.`status`='approved'"; 
$result = $db->query($query_result) or die(mysql_error());
 //$count=1;
while($row = mysqli_fetch_array($result))
{
   //     $pdf->Cell(10, 8, $count, 1);
        $pdf->Cell(60, 10, $row['name'], 1);
		$pdf->Cell(60, 10, $row['amount'].'/=', 1);
		$pdf->Cell(60, 10, $row['pam'].'/=', 1);
        $y += 10;
        
        if ($y > 260)   
		{
            $pdf->AddPage();
            $y = 40;
			
		}
        
        $pdf->setXY($x, $y);
	//	$count++;
}
 
$pdf->Output();
}