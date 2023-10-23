<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header('Location: login.php');
    exit();
}
?>
<?php
require_once('tcpdf/tcpdf.php');

// Get form data
$name = $_GET['name'];
$amount = $_GET['amount'];

// Set organization name and logo
$org_name = 'Gyanganga';
$logo_url = 'https://example.com/logo.png';

// Generate unique receipt number
$receipt_number = time() . '-' . mt_rand(1000, 9999);
$user_id = $_SESSION['user_id'];

// Create new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator($org_name);
$pdf->SetAuthor($org_name);
$pdf->SetTitle('Payment Receipt');
$pdf->SetSubject('Payment Receipt');
$pdf->SetKeywords('Payment, Receipt');

// Set default header data
$pdf->SetHeaderData($logo_url, 30, $org_name . ' Payment Receipt', '');

// Set header and footer fonts
$pdf->setHeaderFont(Array('helvetica', '', 14));
$pdf->setFooterFont(Array('helvetica', '', 8));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont('courier');

// Set margins
$pdf->SetMargins(15, 15, 15);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 15);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set font
$pdf->SetFont('helvetica', '', 12);

// Add page
$pdf->AddPage();

// Output logo
$pdf->Image($logo_url, 15, 15, 30, 30, 'PNG');

// Output text
$pdf->Write(0, $org_name . " Payment Receipt\n\n");
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Write(0, "Receipt Number: ");
$pdf->SetFont('helvetica', '', 12);
$pdf->Write(0, $receipt_number . "\n\n");
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Write(0, "Customer Details:\n\n");
$pdf->SetFont('helvetica', '', 12);
$pdf->Write(0, "UserID: $user_id\n");
$pdf->Write(0, "Name: $name\n");
$pdf->Write(0, "Amount: $amount\n");

// Output PDF as attachment
ob_clean();
$pdf->Output('payment_receipt.pdf', 'D');
?>