<?php
// Start output buffering
ob_start();

// Include necessary files and initialize objects
require_once 'fpdf/fpdf.php'; // Include FPDF library
include_once "classes/order.php";
include "lib/Database.php";
include "lib/Session.php"; // Include Session class

// Initialize session
Session::init();

$db = new Database();
$or = new Order();
$ul = new User();

// Check if ordergrpid is set
if (isset($_POST['ordergrpid'])) {
    // Get the order group ID
    $ordergrpid = $_POST['ordergrpid'];

    // Fetch invoice data from the database
    $query = "SELECT * FROM tbl_order WHERE order_grp_id='$ordergrpid' ORDER BY date DESC";
    $invoice = $db->select($query);
    if ($invoice) {
        $invoiceresult = $invoice->fetch_all(MYSQLI_ASSOC);

        // Log the fetched data to a file for debugging
        file_put_contents('invoice_debug.log', print_r($invoiceresult, true));

        // Initialize FPDF object
        $pdf = new FPDF();
        $pdf->AddPage();

        // Add content to PDF
        $pdf->SetFont('Arial', 'B', 18);
        $pdf->Cell(0, 10, 'Invoice', 0, 1, 'C');

        // Add order summary header
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20, 10, 'SN.', 1);
        $pdf->Cell(40, 10, 'Item Name', 1);
        $pdf->Cell(30, 10, 'Unit Price', 1);
        $pdf->Cell(20, 10, 'Quantity', 1);
        $pdf->Cell(40, 10, 'Total', 1);
        $pdf->Ln();

        // Loop through invoice items and add to PDF
        $totalAmount = 0;
        $i = 1; // Initialize the counter
        foreach ($invoiceresult as $item) {
            $pdf->Cell(20, 10, $i++, 1); // Increment and display the counter
            $pdf->Cell(40, 10, $item['itemName'], 1);
            $pdf->Cell(30, 10, '$' . $item['itemPrice'], 1);
            $pdf->Cell(20, 10, $item['itemQuantity'], 1);
            $total = $item['itemPrice'] * $item['itemQuantity'];
            $pdf->Cell(40, 10, '$' . number_format($total, 2), 1);

            $pdf->Ln();
            $totalAmount += $total;
        }

        $pdf->Ln();
        // Add total amount
        $pdf->Cell(0, 10, 'Total Payable Amount: $' . number_format($totalAmount, 2), 0, 1);

        // Output PDF for download
        $pdf->Output('D', 'Invoice.pdf');
    } else {
        // Handle the case when no invoice data is found
        echo 'No invoice data found for the given order group ID.';
    }

    // End the output buffering and clean the output buffer
    ob_end_clean();
    exit;
} else {
    // Redirect back to the invoice page if ordergrpid is not set
    header("Location: orders.php");
    exit;
}
?>
