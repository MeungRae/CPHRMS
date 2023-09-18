<?php
include('dbconfig.php');
include('security.php');

include('../encryption/encryption.php');


// Include the TCPDF library
require_once('TCPDF-main/tcpdf.php');

// Connect to the database
$student_id = mysqli_real_escape_string($connection, $_GET['id']);

// Retrieve the form data from the database
$result = $connection->query("SELECT * FROM user WHERE user_id = '$student_id'");
$result1 = $connection->query("SELECT * FROM admin inner join hospital on admin.hospital_id=hospital.hospital_id WHERE admin.user_id = '$student_id'");

// Fetch the form data as an associative array
$formData = $result->fetch_assoc();
$formData1 = $result1->fetch_assoc();

$hnum=$formData1['hnum'];
$street=$formData1['street'];
$brgy=$formData1['brgy'];
$mun=$formData1['mun'];
$prov=$formData1['prov'];
$phone=$formData1['phone'];

$street=decryptthis($street,$key);
$brgy=decryptthis($brgy,$key);
$mun=decryptthis($mun,$key);
$prov=decryptthis($prov,$key);
$phone=decryptthis($phone,$key);

$address="{$hnum} {$street} {$brgy} {$mun} {$prov}";



$img="../superadmin/image/profile/" . $formData1['photo'];                               
// Create a new PDF document
$pdf = new TCPDF();

// Set the document title and font
$pdf->SetTitle('Form Data');
$pdf->SetFont('helvetica', '', 12);

// Add a page to the document
$pdf->AddPage();

// Add the name and age to the PDF
$pdf->Cell(0, 10, 'USER ID: ' . $formData['user_id']);
$pdf->Ln();
$pdf->Cell(0, 10, 'Name: ' . $formData['name']);
$pdf->Ln();

$pdf->Cell(0, 10, 'Address: ' . $address);
$pdf->Ln();
$pdf->Cell(0, 10, 'Phone Number: ' . $phone);
$pdf->Ln();
$pdf->Cell(0, 10, 'Email: ' . $formData['email']);
$pdf->Ln();
$pdf->Cell(0, 10, 'Hospital Name: ' . $formData1['hospital_name']);
$pdf->Ln();

$pdf->Image( $img, '', '',100,100);




// Output the PDF to the browser
ob_end_clean();
$pdf->Output(__DIR__ . '/pdf/form_data.pdf', 'FI');

?>
