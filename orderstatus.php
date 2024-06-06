<?php include "inc/header.php"; ?>


<style>
    .cart-wrapper-table tbody tr {grid-template-columns: 1fr 2fr 1fr 1fr 2fr;}
</style>
<section class="main-body">
    <div class="container">
        <h2>Order Status</h2>
<?php
// Check if the order ID is set in the URL
if(isset($_GET['orderid'])) {
    $orderGrpId = $_GET["orderid"];

    // Fetch order details for the specified order group ID
    $getOrder = $cart->getOrderDetailsByOrderId($orderGrpId);

    // Check if the order details are retrieved successfully
    if ($getOrder) {
?>

<div class="order-box" id="order-group-<?php echo $orderGrpId; ?>"> <!-- Add ID with Order Group ID -->
    <h3>Order Group ID: <?php echo $orderGrpId; ?></h3>
    <table class="cart-wrapper-table">
        <!-- Table headers -->
        <tr class="table-heading">
            <th>Sl No.</th>
            <th>Item Name</th>
            <th>Item Quantity</th>
            <th>Total Price</th>
            <th>Status</th>
        </tr>
        <!-- Table data -->
        <?php
        $i = 0;
        $sum = 0; // Initialize the total sum outside the loop
        while ($order = $getOrder->fetch_assoc()) { // Loop through each order in the order group
            $i++;
            $total = $order["itemPrice"] * $order["itemQuantity"]; // Calculate total for each order
            $sum += $total; // Accumulate the total sum
        ?>
            <tr class="table-data">
                <td><?= $i ?></td>
                <td><?= $order["itemName"] ?></td>
                <td><?= $order["itemQuantity"] ?></td>
                <td>$<?= number_format((float)$total, 2, '.', '') ?></td>
                <td>
                    <?php
                    if ($order["orderStatus"] == 1) {
                        echo "<span class='msg'>Product Shifted To Your Address.</span>";
                    } else {
                        echo "<span class='msg'>Order Received<br>Waiting for Shift.</span>";
                    }
                    ?>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
    <!-- Display total quantity and sum for this order group -->
    <div class="payable-amount">
        <!-- <span>
            <span class="amount-heading">Total Quantity :</span>
            <span class="final-amount"><?= $i ?></span>
        </span> -->
        <span>
            <span class="amount-heading">Sub Total :</span>
            <span class="final-amount">$<?php echo number_format((float)$sum, 2, '.', '') ?></span>
        </span>
        <!-- <span>
            <span class="amount-heading">VAT :</span>
            <span class="final-amount">15%</span>
        </span>
        <span>
            <span class="amount-heading">Grand Total :</span>
            <span class="final-amount">$<?php
                $vat = $sum * 0.15;
                $grandTotal = $sum + $vat;
                echo number_format($grandTotal, 2);
                ?>
            </span> -->
        </span>
    </div>
</div>

<?php
    } else {
        echo "<div class='container'><h3 style='text-align:center'>No orders found for the specified order ID.</h3></div>";
    }
} else {
    echo "<div class='container'>
              <h3 style='text-align:center'><b>Please provide a valid order ID to view the details.</b></h3>
          </div>";
}
?>
    </div>
</section>

<?php include "inc/footer.php"; ?>
