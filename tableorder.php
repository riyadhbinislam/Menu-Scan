<?php
include "inc/header.php";

Session::init(); // Initialize session
Session::checkSession(); // Check if the user is logged in

// Handle the form submission to update order status
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderGrpId = $_POST['orderGrpId'];
    $orderStatus = $_POST['orderStatus'];

    // Update the order status for all items in the order group
    $query = "UPDATE tbl_order SET orderStatus = ? WHERE order_grp_id = ?";
    $stmt = $db->link->prepare($query);
    $stmt->bind_param("ss", $orderStatus, $orderGrpId); // Bind parameters as strings
    if ($stmt->execute()) {
        // Redirect back to the orders page or display a success message
        header("Location: tableorder.php");
        exit();
    } else {
        // Handle the error
        echo "Error updating order status: " . $stmt->error;
    }
}
?>

<?php include "inc/sidenav.php";?>
<style>
    .view-order-btn {
        border-bottom: 1px solid #ccc !important;
        background-color: transparent;
        border: none;
        color: #4f4a70;
        padding: 0 5px 5px;
        margin: 10px 20px 0;
        cursor: pointer;
    }
    .order-box {
        width: 700px;
        margin: 15px auto;
        border: 1px solid #d8d8d8;
        padding: 25px;
        border-radius: 8px;
        background-color: #f8f8f8;
    }
</style>

<?php

// Initialize arrays to store orders based on their status
$orderGroups = [];
$completedOrders = [];
$getOrder = $cart->getAllorder();

// Group orders by their unique order IDs and filter by status
if ($getOrder) {
    while ($result = $getOrder->fetch_assoc()) {
        $orderId = $result['order_grp_id']; // Assuming 'order_grp_id' is the unique identifier for order groups
        $orderStatus = $result['orderStatus'];
        if ($orderStatus == 'Order Complete') {
            $completedOrders[$orderId][] = $result;
        } else {
            $orderGroups[$orderId][] = $result;
        }
    }
}

// Count the total number of unique order groups (excluding completed orders)
$totalOrders = count($orderGroups);

// Sort the order groups by their keys (Order Group ID)
ksort($orderGroups);
?>

<section class="main-body">
    <div class="Orders">
        <div>
            <h3>Total Orders - <span style="color: red;"><?php echo $totalOrders; ?></span></h3>
            <h2>Orders List</h2>
        </div>
        <div>
            <!-- Display order details grouped by order group IDs -->
            <?php foreach ($orderGroups as $orderId => $orders) {
                $tableid = $orders[0]['tableId']; // Retrieve table ID from the first order in the group
            ?>
                <div class="order-group">
                    <p class="table-number"><strong id="<?= 'TableId' . $tableid ?>">Table Id: </strong><?= htmlspecialchars($tableid) ?></p>
                    <button class="view-order-btn" data-order-id="<?= htmlspecialchars($orderId); ?>">View Order No - <?= htmlspecialchars($orderId); ?></button><br>
                </div>
                <!-- Order details container -->
                <div class="order-box" id="order-group-<?= htmlspecialchars($orderId); ?>" style="display: none;">
                    <table>
                        <tr class="order-wrapper">
                            <th>Item Name: </th>
                            <th>Item Price: </th>
                            <th>Item Quantity:</th>
                        </tr>
                        <?php foreach ($orders as $order) { ?>
                            <tr class="order-wrapper">
                                <td><?= htmlspecialchars($order['itemName']); ?></td>
                                <td><?= htmlspecialchars($order['itemPrice']); ?></td>
                                <td><?= htmlspecialchars($order['itemQuantity']); ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                    <div class="status-wrapper">
                        <span>Order Status - </span>
                        <form action="" method="post">
                            <input type="hidden" name="orderGrpId" value="<?= htmlspecialchars($orderId); ?>">
                            <select name="orderStatus">
                                <option value="Order Received" <?php if ($orders[0]['orderStatus'] == 'Order Received') echo 'selected'; ?>>Order Received</option>
                                <option value="Order Processing" <?php if ($orders[0]['orderStatus'] == 'Order Processing') echo 'selected'; ?>>Order Processing</option>
                                <option value="Order Complete" <?php if ($orders[0]['orderStatus'] == 'Order Complete') echo 'selected'; ?>>Order Complete</option>
                            </select>
                            <button type="submit">Update Status</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<section style="margin-top: 50px;">
    <div class="complete-list">
        <h2>Completed Orders</h2>
        <div class="order-list">
            <?php foreach ($completedOrders as $orderId => $orders) { ?>
                <div class="order-group">
                    <p class="table-number"><strong id="<?= 'TableId' . $orders[0]['tableId'] ?>">Table Id: </strong><?= htmlspecialchars($orders[0]['tableId']) ?></p>
                    <button class="view-order-btn" data-order-id="<?= htmlspecialchars($orderId); ?>">View Order No - <?= htmlspecialchars($orderId); ?></button><br>
                </div>
                <div class="order-box" id="order-group-<?= htmlspecialchars($orderId); ?>" style="display: none;">
                    <table>
                        <tr class="order-wrapper">
                            <th>Item Name: </th>
                            <th>Item Price: </th>
                            <th>Item Quantity:</th>
                        </tr>
                        <?php foreach ($orders as $order) { ?>
                            <tr class="order-wrapper">
                                <td><?= htmlspecialchars($order['itemName']); ?></td>
                                <td><?= htmlspecialchars($order['itemPrice']); ?></td>
                                <td><?= htmlspecialchars($order['itemQuantity']); ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                    <span>Order Date: </span>
                    <span><?= htmlspecialchars($orders[0]['date']); ?></span>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add click event listener to view order button
        document.querySelectorAll('.view-order-btn').forEach(btn => {
            btn.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default action
                const orderId = this.getAttribute('data-order-id');
                const orderBox = document.getElementById(`order-group-${orderId}`);
                if (orderBox.style.display === 'none' || orderBox.style.display === '') {
                    orderBox.style.display = 'block';
                } else {
                    orderBox.style.display = 'none';
                }
            });
        });

        // Add click event listener to window to hide order boxes when clicked outside
        window.addEventListener('click', function(event) {
            if (!event.target.matches('.view-order-btn')) {
                const orderBoxes = document.querySelectorAll('.order-box');
                orderBoxes.forEach(orderBox => {
                    if (!orderBox.contains(event.target)) {
                        orderBox.style.display = 'none';
                    }
                });
            }
        });
    });
</script>

<?php include "inc/footer.php"; ?>
