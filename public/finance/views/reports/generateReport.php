<?php
require_once '../../../../vendor/autoload.php';

use Dompdf\Dompdf;

// Start output buffering
ob_start();


// Include the script
require_once 'incomeReport.php';

// Get the output of the script
$html = ob_get_clean();

// Instantiate Dompdf class
$dompdf = new Dompdf();

// Load HTML content
$dompdf->loadHtml($html);

// (Optional) Set paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render PDF (output)
$dompdf->render();

// Output PDF to browser for download
$dompdf->stream("income_report.pdf", array("Attachment" => 0));
// Or save PDF to file: $dompdf->output(); and write to file
?>