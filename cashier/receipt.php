<?php
require_once '../core.php';
$dname = basename(__DIR__);
	if($_SESSION['staffuser']['role']!=$dname){
	 header('location:../login.php');
	 exit();
	}

if (isset($_GET['add'])){
	
	$studentid = (int)$_GET['add'];
	$billid = (int)$_GET['bill'];

	$bills = $db->query("SELECT *, sid.studentinvoicedetails as stid, si.tamount as tamount, si.tpaid as tpaid,
	sid.paid as apaid, pf.name as pf, sid.pdetails as det, st.name as sname, st.staffid as sti
	FROM `studentinvoicedetails` as sid 
	inner join studentfees as si on si.studentfeesid = sid.studentinvoiceid
		inner join paymentforms as pf on sid.paymentform = pf.paymentformsid
		inner join staff st on st.staffid = sid.staffid
	where sid.studentinvoicedetails='$billid'");
while($bill =mysqli_fetch_assoc($bills)){
$id = $bill["stid"];
$dt = $bill["timepaid"];
$apaid = $bill["apaid"];
$tpaid = $bill["tpaid"];
$tamount = $bill["tamount"];
$pf = $bill["pf"];
$det = $bill["det"];
$sti = $bill["sti"];
$sname = $bill["sname"];
$balance = $tamount - $tpaid;

}

require('../fpdf/fpdf.php');
class PDF extends FPDF
{
//Page header
function Header()
{
	$this->SetFont('Arial','B');
	$this -> Image('../logo.jpg', 20, 10, 30);
	$this->Cell(40,10,'                                                                                                                       Gretsa University',0,1, 'C');

    //Logo
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
//$pdf = new FPDF('P','mm',array(100,300));
//$pdf->AliasNbPages();
$pdf = new PDF();
$pdf->open();
$pdf->AliasNbPages();   // necessary for x of y page numbers to appear in document
$pdf->SetAutoPageBreak(false);
//$pdf = new FPDF('P','mm',array(100,150));
$pdf->AddPage();
//$pdf->Image($image1, 20, 10, 20);
//$pdf->SetFont('Arial','BU');
//$pdf->Cell(45,40,'Gretsa University',0,1, 'C');

$pdf->SetFont('Arial','B',12);	
$pdf->setXY(10, 50);
$pdf->Cell(35,10,"Receipt Number:");
$pdf->Cell(40,10,"{$id}", 0 , 1);
$pdf->Cell(40,10,"Date and time:", 0 , 1);
$pdf->Cell(40,10,"{$dt}", 0 , 1);
$pdf->SetFont('Arial','B');
$pdf->Cell(30,10,"Amount Paid:");
$pdf->SetFont('Arial','BUI');
$pdf->Cell(40,10,"{$apaid}", 0 , 1);
$pdf->SetFont('Arial','B');
$pdf->Cell(37,10,"Payment Method:");
$pdf->SetFont('Arial','BUI');
$pdf->Cell(40,10,"{$pf}", 0 , 1);
$pdf->SetFont('Arial','B');
$pdf->Cell(13,10,"Code:");
$pdf->SetFont('Arial','BUI');
$pdf->Cell(40,10,"{$det}", 0 , 1);
$pdf->SetFont('Arial','B');
$pdf->Cell(40,10,"-----------------------------------------------------------------------------", 0 , 1);
$pdf->Cell(30,10,"Total Amount:");
$pdf->SetFont('Arial','BUI');
$pdf->Cell(40,10,"{$tamount}", 0 , 1);
$pdf->SetFont('Arial','B');
$pdf->Cell(23,10,"Total Paid:");
$pdf->SetFont('Arial','BUI');
$pdf->Cell(40,10,"{$tpaid}", 0 , 1);
$pdf->SetFont('Arial','B');
$pdf->Cell(43,10,"Balance Remaining:");
$pdf->SetFont('Arial','BUI');
$pdf->Cell(40,10,"{$balance}", 0 , 1);
$pdf->SetFont('Arial', 'B');
$pdf->Cell(40,10,"------------------------------------------------------------------------------", 0 , 1);
$pdf->Cell(25,10,"Served By:");
$pdf->Cell(40,10,"{$sti}-{$sname}", 0 , 1);
$pdf->Output();

		

}else{

echo "Error";
exit();
}



?>
