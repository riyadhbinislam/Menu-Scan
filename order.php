<?php include "inc/header.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);?>
<style>
    .popup-content {
    width: 500px;
    max-width: 100%;
    margin: 150px auto;
    padding: 40px;
    border: 1px solid #d8d8d8;
    border-radius: 15px;
    position: relative;
}

span.popup-close {
    position: absolute;
    top: 10px;
    right: 20px;
    font-weight: bold;
    color: red;
    cursor: pointer;
    width: 20px;
    height: 20px;
    text-align: center;
    box-shadow: 0 0 20px 0px #00000054;
    border-radius: 15%;
}

.note-area a {
    cursor: pointer;
    display: block;
    border: 1px solid #ccc;
    width: fit-content;
    text-align: center;
    padding: 0 35px;
    border-radius: 15px;
    margin-top: 15px;
    transition: 0.3s;
}

.note-area a:hover {
    opacity: 0.7;
}
</style>
<?php
if (isset($_GET['orderId']) && $_GET['orderId'] == 'order') {
    $insertOrder = $cart->orderItem();
    if ($insertOrder) {
        $delData = $cart->delCart();
        echo '<script>window.location="order.php"</script>';
        exit;
    }
}


?>
<section class="main-body">

    <?php
    Session::init();
    $sId = session_id();
    $_SESSION['tableid'] = $tableid;

    $tableid = Session::get("tableid");
    //echo "Debug: Table ID - $tableId";
    $getOrder = $cart->getOrderDetails($tableid, $sId);

    // Initialize an array to store orders grouped by their IDs
    $orderGroups = [];

    // Group orders by their unique order IDs
    if ($getOrder) {
        while ($result = $getOrder->fetch_assoc()) {
            $orderId = $result['order_grp_id']; // Assuming 'order_grp_id' is the unique identifier for order groups
            $orderGroups[$orderId][] = $result;
        }}?>

    <!-- Popup Trigger Button -->
    <button id="popupTrigger" style="display: none;">Show Popup</button>

    <!-- Popup Container -->
    <div id="popupContainer" class="popup" style="display: none;">
        <div class="popup-content">
            <span class="popup-close" onclick="closePopup()">&times;</span>
            <div class="note-area">
                <p>Thank you for your purchase.<br><b>Your order has been successfully received.</b></p>
                <h2>Your food will be served to your table shortly.</h2>
            </div>
        </div>
    </div>
</section>

<script>
    // Function to show the popup
    function showPopup() {
        var popup = document.getElementById('popupContainer');
        popup.style.display = 'block';
    }

    // Function to close the popup and redirect to orders.php
    function closePopup() {
        var popup = document.getElementById('popupContainer');
        popup.style.display = 'none';
        window.location.href = 'orders.php'; // Redirect to orders.php
    }

    // Show the popup when the page loads
    window.onload = function() {
        showPopup();
        // Set a timeout to automatically redirect after 5 seconds
        setTimeout(function() {
            window.location.href = 'orders.php'; // Redirect to orders.php
        }, 5000); // 5000 milliseconds = 5 seconds
    };
</script>
