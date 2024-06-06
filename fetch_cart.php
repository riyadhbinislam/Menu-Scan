<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once "config/config.php";
include_once "lib/Database.php";
include_once "lib/Session.php";
include_once "helpers/format.php";
include_once "classes/cart.php";

Session::init();

$db = new Database();
$fm = new Format();
$cart = new Cart();

$tableid = isset($_SESSION['tableid']) ? $_SESSION['tableid'] : null;

if ($tableid) {
    $cartItems = $cart->getCartProduct($tableid);
    $items = [];

    if ($cartItems) {
        while ($result = $cartItems->fetch_assoc()) {
            $items[] = $result;
        }
    }

    echo json_encode($items);
} else {
    echo json_encode([]);
}

