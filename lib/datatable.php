<?php
// Include Database class
include_once 'lib/Database.php';

// Create a new instance of Database class
$db = new Database();

// Create a connection
$conn = $db->connectDB();

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to create the table
$sql = "CREATE TABLE IF NOT EXISTS tbl_product (
    proId INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    proName VARCHAR(30) NOT NULL,
    proBrandId INT(12) NOT NULL,
    proTypeId INT(12) NOT NULL,
    proCategoriesId INT(12) NOT NULL,
    proTagId INT(12) NOT NULL,
    proSize INT(12) NOT NULL,
    proPrice INT(12) NOT NULL,
    proDescription VARCHAR(255) NOT NULL,
    proManufacturer VARCHAR(255) NOT NULL,
    proReviews VARCHAR(255) NOT NULL,
    proImg VARCHAR(255) NOT NULL
)";

// Execute SQL query
if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";

} else {
    echo "Error creating table: " . $conn->error;
}

// Close the connection
$conn->close();
?>
