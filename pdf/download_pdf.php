<?php
// Set headers for PDF download
header("Content-type: application/pdf");
header("Content-Disposition: attachment; filename=manual.pdf");

// Read the PDF file content
$pdf_data = file_get_contents('manual.pdf');

// Check if file was read successfully
if ($pdf_data === false) {
  die('Error reading PDF file!');
}

// Output the PDF data
echo $pdf_data;
