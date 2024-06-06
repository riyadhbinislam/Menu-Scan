<div class="main-body">
    <div class="page-wrapper">
        <div class="container">
            <div class="side-nav-wrapper">
                <a href="admin.php" class="active">Dashboard</a>
                <a href="items.php" >Items</a>
                <a href="diningtable.php">Dining Tables</a>
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
                <a href="tableorder.php">Table Orders<sup style="color:red"><?php echo $totalOrders; ?></sup></a>


                <!-- <a href="#users" >USERS</a>
                    <div class="collapse submenu" id="users">
                        <a href="#">Administrators</a>
                        <a href="#">Employees</a>
                    </div>
                <a href="#accounts" >ACCOUNTS</a>
                    <div class="collapse submenu" id="accounts">
                        <a href="#">Transactions</a>
                    </div>
                <a href="#reports" >REPORTS</a>
                    <div class="collapse submenu" id="reports">
                        <a href="#">Sales Report</a>
                        <a href="#">Items Report</a>
                        <a href="#">Credit Balance Report</a>
                    </div>
                <a href="#setup" >SETUP</a>
                    <div class="collapse submenu" id="setup">
                        <a href="#">Settings</a>
                    </div> -->
            </div>

            <div class="main-container">



