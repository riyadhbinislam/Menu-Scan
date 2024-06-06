<?php
//include "inc/header.php";
// include_once "config/config.php";
	// include_once "lib/Database.php";
	// include_once "lib/Session.php";
	// Session::init();
	// include_once "helpers/format.php";
	// include_once "classes/product.php";
	// include_once "classes/category.php";
	// include_once "classes/type.php";
	// include_once "classes/brand.php";
	// include_once "classes/tag.php";
	// include_once "classes/cart.php";
	// include_once "classes/user.php";
	// include_once "classes/order.php";
	// include_once "classes/adminlogin.php";
// Session::init();
//
// $db     	= new Database();
// $fm     	= new Format();
// $pro 		= new Product();
// $ct 		= new category();
// $protyp 	= new Type();
// $brand 		= new Brand();
// $tag 		= new Tag();
// $cart 		= new Cart();
// $ul 		= new User();
// $al 		= new Adminlogin();
// $or 		= new Order();
//
// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['itemId'])){
    // $itemQuantity = isset($_POST['itemQuantity']) ? trim($_POST['itemQuantity']) : '';
    // $itemId = isset($_POST['itemId']) ? $_POST['itemId'] : null;
    // $tableid = isset($_POST['tableid']) ? $_POST['tableid'] : null;
//
    // Ensure $itemId and $tableid are not null before processing
    // if ($itemId !== null && $tableid !== null) {
        // $addCart = $cart->addToCart($itemQuantity, $itemId, $tableid);
        // if ($addCart) {
            // echo "Item added to cart successfully.";
        // } else {
            // echo "Failed to add item to cart.";
        // }
    // } else {
        // echo "Item ID or Table ID is missing.";
    // }
// }


include_once "config/config.php";
include_once "lib/Database.php";
include_once "lib/Session.php";
include_once "helpers/format.php";
include_once "classes/product.php";
include_once "classes/category.php";
include_once "classes/type.php";
include_once "classes/brand.php";
include_once "classes/tag.php";
include_once "classes/cart.php";
include_once "classes/user.php";
include_once "classes/order.php";
include_once "classes/adminlogin.php";

Session::init();

$db     	= new Database();
$fm     	= new Format();
$pro 		= new Product();
$ct 		= new category();
$protyp 	= new Type();
$brand 		= new Brand();
$tag 		= new Tag();
$cart 		= new Cart();
$ul 		= new User();
$al 		= new Adminlogin();
$or 		= new Order();

function addToCart($itemQuantity, $itemId, $tableid) {
    global $fm, $db;

    $itemQuantity   = $fm->validation($itemQuantity);
    $itemQuantity   = mysqli_real_escape_string($db->link, $itemQuantity);

    $itemId = $fm->validation($itemId);
    $itemId = mysqli_real_escape_string($db->link, $itemId);

    $tableid = $fm->validation($tableid);
    $tableid = mysqli_real_escape_string($db->link, $tableid);

    $sId = session_id();
    if(empty($itemQuantity) || empty($itemId) || empty($tableid)) {
        return json_encode( 'All fields are required.');
    } else {
        $squery = "SELECT * FROM tbl_items WHERE itemId ='$itemId'";
        $result = $db->select($squery)->fetch_assoc();

        if ($result) {
            $itemName = $result['itemName'];
            $itemPrice = $result['itemPrice'];

            $checkQuery = "SELECT * FROM tbl_cart WHERE sId ='$sId' AND itemId ='$itemId'";
            $countResult = $db->select($checkQuery);

            if ($countResult) {
                return json_encode( 'This product is already added to your cart.');
            } else {
                $query = "INSERT INTO tbl_cart (sId, itemId, itemName, itemPrice, itemQuantity, tableid)
                          VALUES ('$sId', '$itemId', '$itemName', '$itemPrice', '$itemQuantity', '$tableid')";

                $insertedRow = $db->insert($query);

                if ($insertedRow) {
                    return json_encode( 'Item successfully added to the cart.');
                } else {
                    return json_encode( 'Failed to add item to the cart.');
                }
            }
        } else {
            return json_encode( 'Item not found.');
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['itemId'])){
    $itemQuantity = isset($_POST['itemQuantity']) ? trim($_POST['itemQuantity']) : '';
    $itemId = isset($_POST['itemId']) ? $_POST['itemId'] : null;
    $tableid = isset($_POST['tableid']) ? $_POST['tableid'] : null;

    if ($itemId !== null && $tableid !== null) {
        echo addToCart($itemQuantity, $itemId, $tableid);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Item ID or Table ID is missing.']);
    }
    exit();
}
