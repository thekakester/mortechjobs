 <?php
require('fpdf.php');
require('util.php');

$title=post('title');
$customer=post('customer');
$attn=post('attn');
$estimate=post('estimate');
$date=post('date');
$sales=post('sales');
$prog=post('prog');
$engineer=post('engineer');
$plant=post('plant');


class PDF extends FPDF
{
// Page header
function Header()
{
	// Logo
	//total page width is 210 (units? pixels?)
	//60 width image -->start image at 105-30=75
	$this->Image('.\images\logo.png',75,5,60);
}

// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	// Page number
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Image('.\images\agc.jpg',75,20,60);
$pdf->Ln(30);
// Arial bold 15
$pdf->SetFont('Arial','B',20);
// Title
$pdf->Cell(80);
$pdf->Cell(30,10,$title,0,1,'C');
//for($i=1;$i<=40;$i++)
	//$pdf->Cell(0,10,'Printing line number '.$i,0,1);
//what we had before

//form values
$pdf->SetFont('Arial','B',11);
$pdf->Cell(35,5,'To ',0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(35,5,$customer,0,1);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(35,5,'Attn ',0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(35,5,$engineer,0,1);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(35,5,'Estimate ',0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(35,5,$estimate,0,1);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(35,5,'Date ',0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(35,5,$date,0,1);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(35,5,'Sales Rep. ',0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(35,5,$sales,0,1);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(35,5,'Program No. ',0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(35,5,$prog,0,1);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(35,5,'Engineer ',0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(35,5,$engineer,0,1);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(35,5,'Plant ',0,0);
$pdf->SetFont('Arial','',11);
$pdf->Cell(35,5,$plant,0,1);

$pdf->Output();
?>