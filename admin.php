<?php
include "inc/header.php";
include_once "lib/Session.php"; // Include Session class
Session::init(); // Initialize session
Session::checkSession(); // Check if the user is logged in
?>

<?php include "inc/sidenav.php";?>

<div class="content" id="content">
    <!-- Content will be loaded here -->
</div>

<div class="main-content">
    <h2>Good Afternoon</h2>
    <h4 class="user-title"><?php echo Session::get('adminName'); ?></h4>
<div class="overview-wrapper">
    <h4 class="section-title" >Overview</h4>
    <div class="total-ov">
        <div class="total-ov-item total-sales">
            <span class="center-icon"><i class="fas fa-dollar-sign"></i></span>
            <h4 class="ov-title">Total Sales</h4>
        </div>
        <div class="total-ov-item total-orders">
            <span class="center-icon"><i class="fas fa-wallet"></i></span>
            <h4 class="ov-title">Total Orders</h4>
        </div>
        <div class="total-ov-item total-customers">
            <span class="center-icon"><i class="fas fa-users"></i></span>
            <h4 class="ov-title">Total Customers</h4>
        </div>
        <div class="total-ov-item total-menu-items">
            <span class="center-icon"><i class="fas fa-sticky-note"></i></span>
            <h4 class="ov-title">Total Menu Items</h4>
        </div>
    </div>
</div>


<?php include "inc/footer.php";?>