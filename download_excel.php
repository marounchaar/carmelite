<?php
// Include the Composer autoloader
require 'vendor/autoload.php';  // Correct path to the autoloader

// Use the PhpSpreadsheet classes
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Initialize PhpSpreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Fetch data from your database (using your `get.php` file)
include 'get.php';  // Assuming this file fetches data into $records

// Set the header for the Excel sheet
$sheet->setCellValue('A1', 'First Name')
      ->setCellValue('B1', 'Middle Name')
      ->setCellValue('C1', 'Last Name')
      ->setCellValue('D1', 'Birth Date')
      ->setCellValue('E1', 'Phone')
      ->setCellValue('F1', 'Gender')
      ->setCellValue('G1', 'Nationality')
      ->setCellValue('H1', 'Residence Country')
      ->setCellValue('I1', 'Governorate')
      ->setCellValue('J1', 'Casa')
      ->setCellValue('K1', 'City')
      ->setCellValue('L1', 'Street')
      ->setCellValue('M1', 'Building')
      ->setCellValue('N1', 'Floor')
      ->setCellValue('O1', 'Email')
      ->setCellValue('P1', 'Number')
      ->setCellValue('Q1', 'Occupation')
      ->setCellValue('R1', 'Education')
      ->setCellValue('S1', 'Front ID')
      ->setCellValue('T1', 'Back ID')
      ->setCellValue('U1', 'ID')
      ->setCellValue('V1', 'School')
      ->setCellValue('W1', 'Entry Year')
      ->setCellValue('X1', 'Final Year')
      ->setCellValue('Y1', 'Grad Year')
      ->setCellValue('Z1', 'Career')
      ->setCellValue('AA1', 'Position')
      ->setCellValue('AB1', 'Company')
      ->setCellValue('AC1', 'Siblings')
      ->setCellValue('AD1', 'Members')
      ->setCellValue('AE1', 'Message');

// Loop through the records and populate the Excel sheet
$row = 2; // Start from the second row
foreach ($records as $record) {
    $sheet->setCellValue('A' . $row, htmlspecialchars($record['f_name']))
          ->setCellValue('B' . $row, htmlspecialchars($record['m_name']))
          ->setCellValue('C' . $row, htmlspecialchars($record['l_name']))
          ->setCellValue('D' . $row, htmlspecialchars($record['birth_date']))
          ->setCellValue('E' . $row, htmlspecialchars($record['phone_number']))
          ->setCellValue('F' . $row, htmlspecialchars($record['gender']))
          ->setCellValue('G' . $row, htmlspecialchars($record['nationality']))
          ->setCellValue('H' . $row, htmlspecialchars($record['residence_country']))
          ->setCellValue('I' . $row, htmlspecialchars($record['governorate']))
          ->setCellValue('J' . $row, htmlspecialchars($record['casa']))
          ->setCellValue('K' . $row, htmlspecialchars($record['city']))
          ->setCellValue('L' . $row, htmlspecialchars($record['street']))
          ->setCellValue('M' . $row, htmlspecialchars($record['building']))
          ->setCellValue('N' . $row, htmlspecialchars($record['floor']))
          ->setCellValue('O' . $row, htmlspecialchars($record['email']))
          ->setCellValue('P' . $row, htmlspecialchars($record['number']))
          ->setCellValue('Q' . $row, empty($record['occupation']) ? 'No Occupation' : implode(', ', $record['occupation']))
          ->setCellValue('R' . $row, empty($record['uni_dip']) ? 'No Education' : implode(', ', array_column($record['uni_dip'], 'university')))
          ->setCellValue('S' . $row, empty($record['fid_path']) ? 'No Image' : 'Image')
          ->setCellValue('T' . $row, empty($record['bid_path']) ? 'No Image' : 'Image')
          ->setCellValue('U' . $row, empty($record['id_path']) ? 'No Image' : 'Image')
          ->setCellValue('V' . $row, htmlspecialchars($record['school']))
          ->setCellValue('W' . $row, htmlspecialchars($record['entry_year']))
          ->setCellValue('X' . $row, htmlspecialchars($record['final_year']))
          ->setCellValue('Y' . $row, htmlspecialchars($record['grad_year']))
          ->setCellValue('Z' . $row, htmlspecialchars($record['career']))
          ->setCellValue('AA' . $row, htmlspecialchars($record['position']))
          ->setCellValue('AB' . $row, htmlspecialchars($record['company']))
          ->setCellValue('AC' . $row, htmlspecialchars($record['sibilings']))
          ->setCellValue('AD' . $row, empty($record['members']) ? 'No Members' : implode(', ', array_column($record['members'], 'name')))
          ->setCellValue('AE' . $row, htmlspecialchars($record['message']));
    $row++;
}

// Create the Excel writer
$writer = new Xlsx($spreadsheet);

// Set the header for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="user_data.xlsx"');
header('Cache-Control: max-age=0');

// Output the file to the browser
$writer->save('php://output');
?>
