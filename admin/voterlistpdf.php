<?php
// Require TCPDF library
require_once('tcpdf/tcpdf.php');

// Include database connection file
include('dbcon.php');

// Function to set table headers
function setTableHeader($pdf) {
    $pdf->SetFont('CourierB', 'B', 12);
    $pdf->SetFillColor(220, 220, 220);
    $pdf->Cell(85, 10, 'Name', 1, 0, 'C', 1);
    $pdf->Cell(60, 10, 'Unique ID', 1, 0, 'C', 1);
    $pdf->Cell(25, 10, 'Session', 1, 0, 'C', 1);
    $pdf->Cell(15, 10, 'Dept.', 1, 1, 'C', 1);
}

// Get the current year
$currentYear = date('Y');

// Calculate the start year for the last 4 years
$startYear = $currentYear - 4;

// Query to fetch members within the last 4 years
$query = mysqli_query($conn, "SELECT * FROM reg_member WHERE admityr >= $startYear") or die(mysqli_error($conn));

// Create new PDF instance
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document information and properties
$pdf->SetCreator('Your Name');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Voter List');
$pdf->SetSubject('Voter List');
$pdf->SetKeywords('Voter, List, PDF');

// Set font sizes and styles
$fontRegular = 10;
$fontBold = 'B';
$fontTitle = 'CourierB';
$fontSubtitle = 'Courier';

// Set the font directory
$fontDir = dirname(__FILE__) . '/admin/font/';

// Add Courier font
$pdf->AddFont('Courier', '', $fontDir . 'courier.php');
$pdf->AddFont('CourierB', '', $fontDir . 'courierb.php');
$pdf->AddFont('CourierBI', '', $fontDir . 'courierbi.php');

// Set overall table width
$pdf->SetLeftMargin(10);
$pdf->SetRightMargin(10);

// Add a page
$pdf->AddPage();

$logo = '../img/logo-gry.png';
$imageWidth = 58;
$imageHeight = 0;
$pdf->Image($logo, 10, 10, $imageWidth, $imageHeight, 'PNG', '', 'T', false);

// Set email and website information to the right of the page
$pdf->SetFont($fontSubtitle, '', 12);
$pdf->SetY(10);
$pdf->SetX(80);
$pdf->Cell(0, 10, 'Website: https://bcc.baiust.ac.bd', 0, 1, 'R');

$pdf->SetX(80);
$pdf->Cell(0, 10, 'Email: computerclub@baiust.ac.bd', 0, 1, 'R');

// Set header data (title and subtitle)
$pdf->SetHeaderData('', '', 'BAIUST Computer Club', '');
$pdf->SetHeaderFont(array($fontTitle, '', 16));
$pdf->SetHeaderFont(array($fontSubtitle, '', 14));

// Set font for title
$pdf->SetFont($fontTitle, '', 16);

// Write title
$pdf->Cell(0, 10, 'BAIUST Computer Club', 0, 1, 'C');

// Set font for subtitle
$pdf->SetFont($fontSubtitle, '', 14);

// Write subtitle with current year
$subtitle = 'Voters List ' . $currentYear;
$pdf->Cell(0, 10, $subtitle, 0, 1, 'C');

// Set table headers on the first page
setTableHeader($pdf);

// Define the cell height
$cellHeight = 10;
$maxRowsPerPage = 21; // Maximum rows per page

// Initialize row count
$rowCount = 0;
$pageNumber = 1;

// Check if there are members
if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_array($query)) {
        if ($rowCount >= $maxRowsPerPage) {
            $pdf->AddPage();
            $pdf->SetHeaderData('', '', 'BAIUST Computer Club', '');
            setTableHeader($pdf);
            $rowCount = 0;
            $pageNumber++;
        }

        // Display Name, Unique ID, Session Year, and Department
        $pdf->SetFont('Courier', '', $fontRegular);
        $pdf->Cell(85, $cellHeight, $row['fullname'], 1);
        $pdf->Cell(60, $cellHeight, $row['std_id'], 1);
        $pdf->Cell(25, $cellHeight, $row['session'] . ' ' . $row['admityr'], 1);
        $pdf->Cell(15, $cellHeight, $row['dept'], 1);
        $pdf->Ln();

        $rowCount++;
    }
} else {
    // No members found
    $pdf->SetFont('CourierB', $fontBold, $fontRegular);
    $pdf->Cell(0, 10, 'No members found within the last 7 years.', 0, 1);
}

// If it's not the first page, add empty rows to make it 25 rows
if ($pageNumber > 1) {
    while ($rowCount < $maxRowsPerPage) {
        $pdf->Cell(85, $cellHeight, '', 1);
        $pdf->Cell(60, $cellHeight, '', 1);
        $pdf->Cell(25, $cellHeight, '', 1);
        $pdf->Cell(15, $cellHeight, '', 1);
        $pdf->Ln();
        $rowCount++;
    }
}

// Generate the filename
$filename = 'VoterList' . $currentYear . '.pdf';

// Output PDF as a downloadable file
$pdf->Output($filename, 'D');

// Close the database connection
mysqli_close($conn);
?>
