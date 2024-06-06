<?php
include "inc/header.php";
include_once "lib/Database.php";

require_once "phpqrcode/qrlib.php";

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tableName = $_POST['tableName'];
    $tableCapacity = $_POST['tableCapacity'];

    // Generate the link with protocol (http:// or https://)
    $link = 'https://riyadh4.r3al.win/menuitems.php?tableid=' . urlencode($tableName);

    // Generate the QR code with the link as a URL
    $qrcode = 'images/tableqr/' . time() . '.png';
    QRcode::png($link, $qrcode, QR_ECLEVEL_L, 10, 1); // Specify error correction level and pixel size

    // Save the QR code information to the database
    $query = "INSERT INTO tbl_table (tableName, tableCapacity, qrText, qrImg)
              VALUES ('$tableName', '$tableCapacity', '$link', '$qrcode')";
    $result = $db->insert($query);

    if ($result) {
        echo "<script>alert('Table added successfully');</script>";
        // Redirect the user to the index page
        echo "<script>window.location.href = 'diningtable.php';</script>";
        exit; // Ensure no further execution after redirection
    } else {
        echo "<script>alert('Failed to add table');</script>";
    }
}
?>

<?php include "inc/footer.php"; ?>
