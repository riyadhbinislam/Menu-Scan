<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once "config/config.php";
include_once "lib/Database.php";
include_once "helpers/format.php";
include_once "classes/product.php";
include_once "classes/category.php";
include_once "classes/type.php";
include_once "classes/brand.php";
include_once "classes/tag.php";
include_once "classes/order.php";
include_once "classes/adminlogin.php";
// Ensure the Product class is included

$db     	= new Database();
$fm     	= new Format();
$pro 		= new Product();
$ct 		= new category();
$protyp 	= new Type();
$brand 		= new Brand();
$tag 		= new Tag();
$al 		= new Adminlogin();
$or 		= new Order();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $addpro = $pro->proAdd($_POST, $_FILES);
    if ($addpro) {
        echo "Item added successfully.";
    } else {
        echo "Failed to add item.";
    }

}

