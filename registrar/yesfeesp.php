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

$year = $_POST['year'];
$stage = $_POST['stage'];
$date = date("Y-m-d");

class myPDF extends FPDF {
    function myCell($w,$h,$x,$t){
        $height=$h/3;
        $first=$height+2;
        $second=$height+$height+$height+3;
        $len=strlen($t);
        if($len>20){
            $txt=str_split($t,15);
            $this->SetX($x);
            $this->Cell($w,$first,$txt[0],'','','');
            $this->SetX($x);
            $this->Cell($w,$second,$txt[1],'','','');
            $this->SetX($x);
            $this->Cell($w,$h,'','LTRB',0,'L',0);
        }
        else{
            $this->SetX($x);
            $this->Cell($w,$h,$t,'LTRB',0,'L',0);
        }
    }

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
$pdf = new myPDF();
$pdf->AddPage();
//$pdf->open();
$pdf->Ln();
$pdf->AliasNbPages();   
$pdf->SetAutoPageBreak(false);

$pdf->SetAuthor('...');
$pdf->SetTitle('Report');
$date3 =  date("F j, Y");
$pdf->SetFont('Arial','B',14);
$pdf->Cell(120,10,'Students with Fees Balance: ', 0, 1, 0);
$pdf->SetFont('Arial','I',10);
$pdf->Cell(40,30,'Report Print Date: '.$date3 .'. Processed By:' .$st['staffid'].' - '.$st['name']);

$w=60;
$h=15;


$pdf->SetDrawColor(0, 0, 0); 
 

$pdf->SetFillColor(170, 170, 170); 
$pdf->setFont("Arial","B","9");
$pdf->setXY(10, 80); 
$pdf->Cell(10, 10, "#", 1, 0, "L", 1); 
$pdf->Cell($w, 10, "Student Number", 1, 0, "L", 1); 
$pdf->Cell($w, 10, "Comment", 1, 0, "L", 1); 

$y = 90;
$x2 = 10;  

$pdf->setXY($x2, $y);
$pdf->setFont("Arial","B","9");
$query_result = "select student.studentnumber as c, (sum(studentfees.tamount) - sum(studentfees.tpaid)) as a from student
	inner join studentprogramme on studentprogramme.studentid = student.studentid
	inner join studentfees on studentfees.studentprogrammeid = studentprogramme.studentprogrammeid
	inner join studentinvoice on studentinvoice.studentfeesid = studentfees.studentfeesid
	where student.status='1'
	group by student.studentid
	having a >= 0"; 
$result = $db->query($query_result) or die(mysql_error());
 $count=1;
 while($row = mysqli_fetch_array($result))
{
$x=$pdf->getx();
$pdf->myCell(10,$h,$x,$count);
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,$row['c']);
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,'           ');
$pdf->Ln();
$y += 8;
		$count++;
		        if ($y > 170)   
		{
            $pdf->AddPage();
            $y = 40;
			
		}
        
     //   $pdf->setXY($x2, $y);
}

$pdf->Output();
}
?>