<!-- cart.php -->


<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    include_once "lib/Database.php";
    include_once "lib/Session.php";
    Session::init();
    include_once "helpers/format.php";
    include_once "classes/cart.php";
    include_once "classes/order.php";

    $db     	= new Database();
    $fm     	= new Format();
    $cart 		= new Cart();

    // Check if 'tableid' is set in the session
    $tableid = isset($_SESSION['tableid']) ? $_SESSION['tableid'] : null;

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $itemQuantity = $_POST['itemQuantity'];
        $itemId = $_POST['itemId'];
        $tableid = $_POST['tableid'];
        $cartId = $_POST['cartId'];
        $updateCart  = $cart->updateCart($itemQuantity, $cartId, $tableid, $itemId);
        if($itemQuantity <= 0){
            $delProduct = $cart->deleteFromCart($cartId);
        }
    }

?>
<style>
    .itemQuantity {
        position: absolute;
        top: -9px;
        left: -19px;
        height: 20px;
        width: 20px;
        border-radius: 50%;
        background-color: #000;
        color: #fff;
        text-align: center;
    }

    .data-info {
        position: relative;
    }

    .data-action-alt a i {
        margin: 0;
    }
</style>

<section class="main-content">
    <div class="container">
        <h2 class="section-title">Your Cart</h2>
        <div id="cart-wrapper" class="sec-cat-product">
            <div class="cart-items">
                <?php
                    if ($tableid) {
                        $cartItems = $cart->getCartProduct($tableid);
                        $items = [];

                        if ($cartItems) {
                            $i = 0;
                            $sum = 0;
                            $itemQuantity = 0;

                            while ($result = $cartItems->fetch_assoc()) {
                                $i++;
                ?>
                <div class="cart-solo-row">
                    <div class="data-info">
                        <span class="itemName"><?= $result["itemName"] ?></span>
                        <span class="itemPrice">$<?= $result["itemPrice"] ?></span>
                        <span class="itemQuantity"><?= $result["itemQuantity"] ?></span>
                    </div>
                    <div class="data-action-alt">
                        <span class="action-button">
                            <a href="delcart.php?cartId=<?= $result['cartId'] ?>" class="delete-item"><i class="fas fa-trash-alt"></i></a>
                        </span>
                    </div>
                    <div class="data-amount">
                        <span>
                            $<?php
                                $total = $result["itemPrice"] * $result["itemQuantity"];
                                echo number_format((float)$total, 2, '.', '');
                            ?>
                        </span>
                    </div>
                </div>
                <?php
                                $itemQuantity += $result['itemQuantity'];
                                $sum += $total;
                                Session::set("itemQuantity", $itemQuantity);
                                Session::set("sum", $sum);
                            }
                        }
                    }
                ?>
            </div>
            <?php if (empty($cartItems)) {
                echo "<span class='msg-alt'>Your Cart is Empty! Please add some products to your cart.</span>";
            } else { ?>
            <div class="total-price">
                <span> Sub Total: </span>
                <span>$<?php echo number_format((float)$sum, 2, '.', '') ?></span>
            </div>
            <form action="" method="post" enctype='multipart/form-data'>
                <div class="contact-info">
                    <h3>Billing address</h3>
                    <div>
                        <strong>Table ID: </strong><span><?= $tableid; ?></span>
                    </div>
                </div>
                <div class="payment-info">
                    <h3>Payment</h3>
                    <input type="radio" id="cash" name="payment_method" value="Cash">
                    <label for="cash">Cash</label><br>
                    <input type="radio" id="card" name="payment_method" value="Card">
                    <label for="card">Card</label><br>
                </div>
            </form>
            <div class="ordernow">
                <a href="order.php?orderId=order" class="regular-button" style="margin-top: 50px;">Place Order</a>
            </div>
            <?php } ?>
        </div>
    </div>
</section>