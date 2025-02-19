<?php
// Include the Composer autoloader
require_once 'vendor/autoload.php';  // Correct path to the autoloader

use Dompdf\Dompdf;
use Dompdf\Options;

// Initialize DOMPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);  // Enable PHP in HTML content if needed
$dompdf = new Dompdf($options);

// Fetch data from your database (using your `get.php` file)
include 'get.php';  // Assuming this file fetches data into $records

// Start the HTML content for the PDF
$html = '
    <h2>User Data</h2>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Birth Date</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Nationality</th>
                <th>Residence Country</th>
                <th>Governorate</th>
                <th>Casa</th>
                <th>City</th>
                <th>Street</th>
                <th>Building</th>
                <th>Floor</th>
                <th>Email</th>
                <th>Number</th>
                <th>Occupation</th>
                <th>Education</th>
                <th>Front ID</th>
                <th>Back ID</th>
                <th>ID</th>
                <th>School</th>
                <th>Entry Year</th>
                <th>Final Year</th>
                <th>Grad Year</th>
                <th>Career</th>
                <th>Position</th>
                <th>Company</th>
                <th>Siblings</th>
                <th>Members</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>';

// Loop through the records and display the data in table rows
foreach ($records as $record) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($record['f_name']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['m_name']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['l_name']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['birth_date']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['phone_number']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['gender']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['nationality']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['residence_country']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['governorate']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['casa']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['city']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['street']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['building']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['floor']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['email']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['number']) . '</td>';
    $html .= '<td>' . (empty($record['occupation']) ? 'No Occupation' : implode(', ', $record['occupation'])) . '</td>';
    $html .= '<td>' . (empty($record['uni_dip']) ? 'No Education' : implode(', ', array_column($record['uni_dip'], 'university'))) . '</td>';
    $html .= '<td>' . (empty($record['fid_path']) ? 'No Image' : 'Image') . '</td>';
    $html .= '<td>' . (empty($record['bid_path']) ? 'No Image' : 'Image') . '</td>';
    $html .= '<td>' . (empty($record['id_path']) ? 'No Image' : 'Image') . '</td>';
    $html .= '<td>' . htmlspecialchars($record['school']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['entry_year']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['final_year']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['grad_year']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['career']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['position']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['company']) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['sibilings']) . '</td>';
    $html .= '<td>' . (empty($record['members']) ? 'No Members' : implode(', ', array_column($record['members'], 'name'))) . '</td>';
    $html .= '<td>' . htmlspecialchars($record['message']) . '</td>';
    $html .= '</tr>';
}

$html .= '
        </tbody>
    </table>';

// Load HTML into DOMPDF
$dompdf->loadHtml($html);

// Set paper size (optional)
$dompdf->setPaper([0, 0, 1440, 1080]);

// Render PDF (first pass for full HTML to PDF)
$dompdf->render();

// Output the generated PDF (force download)
$dompdf->stream("carmelite.pdf", array("Attachment" => 1));
?>
