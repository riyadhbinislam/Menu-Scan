<?php include "inc/header.php"; ?>
<style>
@media(min-width: 768px){
    .order-flex {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 50px !important;
    }

}
    .order-flex {
        display: grid;
        gap: 10px;
        margin-bottom: 50px;
        border-radius: 15px;
        box-shadow: 0 0 5px 5px #f8f8f8;
    }

    .order-group {
        order: -1;
        background-color: #f8f8f8 !important;
    }

    .order-group,
    .order-group .order-status-wrapper,
    .order-group .payment-wrapper{
        border: 1px solid #d8d8d8;
        padding: 20px;
        border-radius: 15px;
        background-color: #fff;
    }

    .order-status-wrapper {
        margin-bottom: 10px;
    }

    .order-status-wrapper p span,
    .payment-wrapper p span{
        color: #848484;
    }

    .order-status-wrapper p,
    .payment-wrapper p{
        color: #222
    }

    .order-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        align-items: center;
        margin-bottom: 20px;
    }
    .order-box,
    .itemName {
        position: relative;
    }

    .total-wrapper {
        position: absolute;
        bottom: 20px;
        right: 20px;
    }
    .order-box {
    padding: 30px;
    }

    .print button{
        position: absolute;
        bottom: 20px;
        left: 0;
        background-color: green !important;
        color: #fff
    }

</style>

<?php

// Get the session ID
$sId = session_id();
// Fetch order details for the logged-in user
$tableid = Session::get("tableid");

// Initialize an array to store orders grouped by their IDs
$orderGroups = [];
$getOrder = $cart->getOrderDetails($tableid, $sId);


  // Custom counter variable for order group ID
  $orderIdCounter = 1;

// Group orders by their unique order IDs
if ($getOrder) {
    while ($result = $getOrder->fetch_assoc()) {
        $orderId = $result['order_grp_id']; // Assuming 'order_grp_id' is the unique identifier for order groups
        $orderGroups[$orderId][] = $result;
    }
}

// Sort the order groups by their keys (Order Group ID)
ksort($orderGroups);
?>

<section class="main-body">
    <div class="container">
        <h2>Orders List</h2>
        <h3 style="margin-bottom: 30px;">Below, you'll find a comprehensive list of all your orders.</h3>


                        <!-- Display order details grouped by order group IDs -->
                    <?php
                    foreach ($orderGroups as $orderId => $orders) {
                        // Initialize total sum for the group
                        $totalSum = 0;
                    ?>
                    <div class="order-flex">

                        <!-- Order details container -->

                        <div class="order-box" id="order-group-<?php echo $orderId; ?>" >
                            <table>
                            <!-- Loop through orders in this group -->
                            <div class="order-wrapper">
                                    <span><strong>Item Name & Quantity: </strong></span>
                                    <!-- <span>Item Quantity:</span> -->
                                    <span><strong>Item Price: </strong></span>
                                    <span><strong>Total:</strong></span>

                                <!-- Add more order details as needed -->
                            </div>

                            <?php foreach ($orders as $order) { ?>
                                <div class="order-wrapper">
                                    <span class="itemName"><?php echo $order['itemName']; ?><span class="itemQuantity"><?php echo $order['itemQuantity']; ?></span></span>
                                    <span class="itemPrice"><?php echo $order['itemPrice']; ?></span>

                                    <span class="total">
                                        $<?php
                                        $total = $order["itemPrice"] * $order["itemQuantity"];
                                        echo number_format((float)$total, 2, '.', '');
                                        // Add the total to the group total sum
                                        $totalSum += $total;
                                        ?>
                                    </span>

                                    <!-- Add more order details as needed -->
                                </div>

                            <?php } ?>

                            </table>
                            <div class="total-wrapper">
                                    <span>Total Payable - </span>
                                    <td><strong><span>$<?php echo number_format((float)$totalSum, 2, '.', ''); ?></span></strong></td>
                            </div>
                            <div class="print invoice">
                                    <a href="invoice.php?ordergrpid=<?php echo $orderId;?>" target="_blank" class="btn btn-primary"> <button>Print Invoice</button></a>
                            </div>

                            <!-- Total Payable for the group -->




                        </div>
                        <div class="order-group">
                            <div class="order-status-wrapper">
                                <h3><span>Order Id:</span>  <?php echo $orderId; ?></h3>
                                <p><span id="<?= 'TableId' . $tableid ?>">Table Id: </span><?= $tableid ?></p>
                                <p class="status-wrapper">
                                    <span>Order Status - </span>
                                    <td><?php echo $order['orderStatus']; ?></td>
                                </p>
                            </div>

                            <div class="payment-wrapper">
                                <h3>Payment Info</h3>
                                <p><span>Payment Method - </span>Cash or Card</strong></p>
                                <p><span>Payment Status - </span>Unpaid</strong></p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

    </div>


</section>



<?php include "inc/footer.php"; ?>
