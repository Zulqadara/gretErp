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
$date =  date("F j, Y", strtotime($tos));
$date2 =  date("F j, Y", strtotime($froms));
$date3 =  date("F j, Y");
$pdf->SetFont('Arial','B',14);
$pdf->Cell(140,10,'Profit and Loss Statement: ', 0, 1, 0);
$pdf->Cell(135,10,$date .' - '.$date2, 0, 1, 0);
$pdf->SetFont('Arial','I',10);
$pdf->Cell(40,30,'Report Print Date: '.$date3 .'. Processed By:' .$st['staffid'].' - '.$st['name']);

$w=80;
$h=15;


$pdf->SetDrawColor(0, 0, 0); 
 

$pdf->SetFillColor(170, 170, 170); 
$pdf->setFont("Arial","B","9");
$pdf->setXY(10, 80); 
$pdf->Cell($w, 10, "Name", 1, 0, "L", 1); 
$pdf->Cell($w, 10, "Amount", 1, 0, "L", 1); 


$y = 90;
$x2 = 10;  

$pdf->setXY($x2, $y);
$pdf->setFont("Arial","B","9");
$query_result = "SELECT sum(sf.paid) as ftot 
			FROM studentinvoicedetails sf
			WHERE date(sf.datepaid) BETWEEN '$tos' AND '$froms';"; 
$result = $db->query($query_result) or die(mysql_error());
$sresults2 = $db->query("SELECT *, sum(gross) as fnet
			FROM payroll as pi
			WHERE date(dt) BETWEEN '$tos' AND '$froms';");		
			$sresults3 = $db->query("SELECT *, sum(amount) as tincome
			FROM income as ic
			WHERE date(dt) BETWEEN '$tos' AND '$froms';");	
			$sresults4 = $db->query("SELECT *, sum(pet.amount) as texpense
			FROM petty as pet inner join expense as exp on exp.expenseid = pet.expenseid
			WHERE date(pet.dt) BETWEEN '$tos' AND '$froms' AND exp.status='approved';");
 while($row = mysqli_fetch_array($result))
{
	$name = $row['ftot'];
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,"Total Fees Paid");
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,$row['ftot'].'/=');
$x=$pdf->getx();
$pdf->Ln();
$y += 8;
		        if ($y > 170)   
		{
            $pdf->AddPage();
            $y = 40;
			
		}
        
     //   $pdf->setXY($x2, $y);
}
 while($row = mysqli_fetch_array($sresults2))
{
	$name2 = $row['fnet'];
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,"Gross Salary");
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,$row['fnet'].'/=');
$x=$pdf->getx();
$pdf->Ln();
$y += 8;
		        if ($y > 170)   
		{
            $pdf->AddPage();
            $y = 40;
			
		}
        
     //   $pdf->setXY($x2, $y);
}
 while($row = mysqli_fetch_array($sresults3))
{
	$name3 = $row['tincome'];
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,"Income");
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,$row['tincome'].'/=');
$x=$pdf->getx();
$pdf->Ln();
$y += 8;
		        if ($y > 170)   
		{
            $pdf->AddPage();
            $y = 40;
			
		}
        
     //   $pdf->setXY($x2, $y);
}
 while($row = mysqli_fetch_array($sresults4))
{
	$name4 = $row['texpense'];
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,"Expenses");
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,$row['texpense'].'/=');
$x=$pdf->getx();
$pdf->Ln();
$y += 8;
		        if ($y > 170)   
		{
            $pdf->AddPage();
            $y = 40;
			
		}
        
     //   $pdf->setXY($x2, $y);
}

$pdf->SetFillColor(170, 170, 170); 
$pdf->setFont("Arial","B","9");
$pdf->setXY(10, 165); 
$pdf->Cell($w, 10, "Profit", 1, 0, "L", 1); 
$pdf->Cell($w, 10, "Loss", 1, 0, "L", 1); 

$y = 175;
$x2 = 10;  

$pdf->setXY($x2, $y);
$pdf->setFont("Arial","B","9");

$x=$pdf->getx();
$pdf->myCell($w,$h,$x,$profit = $name + $name3.'/=');
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,"(".$loss = $name2 + $name4."/=)");
$x=$pdf->getx();
$pdf->Ln();

$x=$pdf->getx();
$pdf->myCell($w,$h,$x,"Balance");
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,$profit - $loss.'/=');
$x=$pdf->getx();
$pdf->Ln();
$y += 8;
		        if ($y > 170)   
		{
            $pdf->AddPage();
            $y = 40;
			
		}
$pdf->Output();
}
?>