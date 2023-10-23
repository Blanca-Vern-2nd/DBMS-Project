<?php
require_once('tcpdf/tcpdf.php');
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header('Location: login.php');
    exit();
}

// Get user ID from session variable
$user_id = $_SESSION['user_id'];

// Get form data
$name = $_GET['name'];
$amount = $_GET['amount'];

// Set organization name and logo
$org_name = 'Gyanganga';
$logo_url = 'https://example.com/logo.png';

// Generate unique receipt number
$receipt_number = time() . '-' . mt_rand(1000, 9999);

// Check if receipt has already been downloaded
if (receiptDownloaded($receipt_number)) {
    // Redirect to homepage
    header('Location: index.php');
    exit();
}

// Generate PDF receipt
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($org_name);
$pdf->SetTitle('Receipt');
$pdf->SetSubject('Receipt');
$pdf->SetKeywords('Receipt, PDF');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();
$pdf->Image($logo_url, 10, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, $org_name, 0, 1, 'R');
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 20, 'Receipt', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Name: ' . $name, 0, 1);
$pdf->Cell(0, 10, 'Amount: ' . $amount, 0, 1);
$pdf->Cell(0, 10, 'Receipt Number: ' . $receipt_number, 0, 1);

// Get PDF file contents
$pdf_file = $pdf->Output('', 'S');

// Save receipt number, user ID, and amount in database
$pdo = new PDO('mysql:host=localhost;dbname=dbms2023', 'root', '');
$stmt = $pdo->prepare('INSERT INTO receipts (user_id, receipt_number, receipt_file, amount) VALUES (?, ?, ?, ?)');
$stmt->execute([$user_id, $receipt_number, $pdf_file, $amount]);
// Display receipt number to user
echo 'Your receipt number is: ' . $receipt_number;

// Add "Return Home" button
echo '<br><br><a href="donor_dashboard.php">Return Home</a>';

// Function to check if receipt has already been downloaded
function receiptDownloaded($receipt_number) {
    $pdo = new PDO('mysql:host=localhost;dbname=dbms2023', 'root', '');
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM receipts WHERE receipt_number = ?');
    $stmt->execute([$receipt_number]);
    $count = $stmt->fetchColumn();
    return $count > 0;
}