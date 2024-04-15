<?php
require_once './vendor/autoload.php';

use Dompdf\Dompdf;
define("DOMPDF_ENABLE_REMOTE", false);

$fileNeeded = $_SESSION['postdata']['file'];
if($fileNeeded === null){
    echo "No file selected";
    header ("Location: /fin/dashboard");
    exit();
}

// Start output buffering
ob_start();


// Include the script
if($fileNeeded === "Income"){
    require_once 'incomeReport.php';
}
else if($fileNeeded === "OwnerEquity"){
    require_once 'OwnersEquityReport.php';
}
else if($fileNeeded === "TrialBalance"){
    require_once 'TrialBalance.php';
}

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