<?php
include('dbconfig.php');
include('security.php');

include('../encryption/encryption.php');

// Include the TCPDF library
require_once('TCPDF-main/tcpdf.php');

// Connect to the database
$student_id = mysqli_real_escape_string($connection, $_GET['id']);

// Retrieve the form data from the database
$result = $connection->query("SELECT * FROM user inner join doctor on user.user_id=doctor.user_id inner join department on doctor.department_id=department.department_id inner join hospital on doctor.hospital_id=hospital.hospital_id WHERE user.user_id = '$student_id'");

// Fetch the form data as an associative array
$formData = $result->fetch_assoc();
$bdate=$formData['bdate'];
$user=$formData['user_id'];
$gender=$formData['gender'];
$cstatus=$formData['cstatus'];
$hnum=$formData['hnum'];
$street=$formData['street'];
$brgy=$formData['brgy'];
$mun=$formData['mun'];
$prov=$formData['prov'];
$phone=$formData['phone'];
$name=$formData['name'];
$docid=$formData['doctor_id'];
$hosname=$formData['hospital_name'];
$depname=$formData['department_name'];
$posit=$formData['doctor_position'];

$gender=decryptthis($gender,$key);
$cstatus=decryptthis($cstatus,$key);
$street=decryptthis($street,$key);
$brgy=decryptthis($brgy,$key);
$mun=decryptthis($mun,$key);
$prov=decryptthis($prov,$key);
$phone=decryptthis($phone,$key);

$today=  date("Y-m-d");
$diff = date_diff(date_create($bdate), date_create($today));
$age=(int) $diff->format('%y');
$address="{$hnum} {$street} {$brgy} {$mun} {$prov}";


$img="../superadmin/image/profile/" . $formData['photo'];  
// Create a new PDF document
$pdf = new TCPDF();

// Set the document title and font
$pdf->SetTitle('Form Data');
$pdf->SetFont('helvetica', '', 12);

// Add a page to the document
$pdf->AddPage();

// Add the name and age to the PDF
$pdf->Cell(0, 10, 'USER ID: ' . $user);
$pdf->Ln();
$pdf->Cell(0, 10, 'Name: ' . $name);
$pdf->Ln();
$pdf->Cell(0, 10, 'Gender: ' . $gender);
$pdf->Ln();
$pdf->Cell(0, 10, 'Birth Date: ' . $bdate);
$pdf->Ln();
$pdf->Cell(0, 10, 'Age: ' . $age);
$pdf->Ln();
$pdf->Cell(0, 10, 'Civil Status: ' . $cstatus);
$pdf->Ln();
$pdf->Cell(0, 10, 'Address: ' . $address);
$pdf->Ln();
$pdf->Cell(0, 10, 'Phone Number: ' . $phone);
$pdf->Ln();
$pdf->Cell(0, 10, 'Email: ' . $formData['email']);
$pdf->Ln();
$pdf->Cell(0, 10, 'Doctor ID: ' . $docid);
$pdf->Ln();
$pdf->Cell(0, 10, 'Department: ' . $depname);
$pdf->Ln();
$pdf->Cell(0, 10, 'Position: ' . $posit);
$pdf->Ln();
$pdf->Cell(0, 10, 'Hospital: ' . $hosname);
$pdf->Ln();
$pdf->Image( $img, '', '',50,50);

// Output the PDF to the browser
ob_end_clean();
$pdf->Output(__DIR__ . '/pdf/form_data.pdf', 'FI');

?>
