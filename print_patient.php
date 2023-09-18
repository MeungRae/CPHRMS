<?php
include('dbconfig.php');
include('security.php');
include('../encryption/encryption.php');


// Include the TCPDF library
require_once('TCPDF-main/tcpdf.php');

// Connect to the database
$student_id = mysqli_real_escape_string($connection, $_GET['id']);

// Retrieve the form data from the database
$result = $connection->query("SELECT * FROM user inner join patient on user.user_id=patient.user_id WHERE user.user_id = '$student_id'");
$result2 = $connection->query("SELECT * FROM allergy WHERE user_id = '$student_id'");
$result3 = $connection->query("SELECT * FROM history  WHERE user_id = '$student_id'");

// Fetch the form data as an associative array
$formData = $result->fetch_assoc();

$bdate=$formData['bdate'];
$bplace=$formData['bplace'];
$gender=$formData['gender'];
$cstatus=$formData['cstatus'];
$hnum=$formData['hnum'];
$street=$formData['street'];
$brgy=$formData['brgy'];
$mun=$formData['mun'];
$prov=$formData['prov'];
$phone=$formData['phone'];
$gname=$formData['gname'];
$gphone=$formData['gphone'];
$gemail=$formData['gemail'];
$gaddress=$formData['gaddress'];

$bplace=decryptthis($bplace,$key);
$gender=decryptthis($gender,$key);
$cstatus=decryptthis($cstatus,$key);
$street=decryptthis($street,$key);
$brgy=decryptthis($brgy,$key);
$mun=decryptthis($mun,$key);
$prov=decryptthis($prov,$key);
$phone=decryptthis($phone,$key);
$gname=decryptthis($gname,$key);
$gphone=decryptthis($gphone,$key);
$gemail=decryptthis($gemail,$key);
$gaddress=decryptthis($gaddress,$key);

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
$pdf->Cell(0, 10, 'USER ID: ' . $formData['user_id']);
$pdf->Ln();
$pdf->Cell(0, 10, 'Name: ' . $formData['name']);
$pdf->Ln();
$pdf->Cell(0, 10, 'Gender: ' . $gender);
$pdf->Ln();
$pdf->Cell(0, 10, 'Birth Date: ' . $bdate);
$pdf->Ln();
$pdf->Cell(0, 10, 'Age: ' . $age);
$pdf->Ln();
$pdf->Cell(0, 10, 'Birth Place: ' . $bplace);
$pdf->Ln();
$pdf->Cell(0, 10, 'Civil Status: ' . $cstatus);
$pdf->Ln();
$pdf->Cell(0, 10, 'Address: ' . $address);
$pdf->Ln();
$pdf->Cell(0, 10, 'Phone Number: ' . $phone);
$pdf->Ln();
$pdf->Cell(0, 10, 'Email: ' . $formData['email']);
$pdf->Ln();
$pdf->Cell(0, 10, 'Guardian Name: ' . $gname);
$pdf->Ln();
$pdf->Cell(0, 10, 'Guardian Phone: ' . $gphone);
$pdf->Ln();
$pdf->Cell(0, 10, 'Guardian Email: ' . $gemail);
$pdf->Ln();
$pdf->Cell(0, 10, 'Guardian Address: ' . $gaddress);
$pdf->Ln();
$pdf->Cell(0, 10, 'Allergies: ' );
$pdf->Ln();
while ($row = mysqli_fetch_assoc($result2)) {
    $row['allergy']=decryptthis($row['allergy'],$key);
    $pdf->MultiCell(50, 10, $row['allergy'], 1, 'C', 0, 0);
    $pdf->MultiCell(50, 10, $row['date_started'], 1, 'C', 0, 1);

}
$pdf->Cell(0, 10, 'History: ' );
$pdf->Ln();
while ($row = mysqli_fetch_assoc($result3)) {
    $row['history']=decryptthis($row['history'],$key);
    $pdf->MultiCell(50, 10, $row['history'], 1, 'C', 0, 0);
    $pdf->MultiCell(50, 10, $row['date_started'], 1, 'C', 0, 1);
  
}
$pdf->Ln();

$pdf->Image( $img, '', '',50,50);




// Output the PDF to the browser
ob_end_clean();
$pdf->Output(__DIR__ . '/pdf/form_data.pdf', 'FI');

?>
