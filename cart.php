<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    include_once "config/config.php";
    include_once "lib/Database.php";
    include_once "lib/Session.php";
    Session::init();
    include_once "helpers/format.php";
    include_once "classes/cart.php";
    include_once "classes/order.php";

    $db = new Database();
    $fm = new Format();
    $cart = new Cart();

    $tableid = isset($_SESSION['tableid']) ? $_SESSION['tableid'] : null;
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
            <div class="cart-items"></div>
            <div class="total-price"></div>
            <div class="ordernow">
                <a href="order.php?orderId=order" class="regular-button" style="margin-top: 50px;">Place Order</a>
            </div>
        </div>
    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    function loadCart() {
        $.ajax({
            url: 'fetch_cart.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var cartItems = '';
                var total = 0;
                var itemQuantity = 0;

                if (response.length > 0) {
                    $.each(response, function(index, item) {
                        var itemTotal = parseFloat(item.itemPrice) * parseInt(item.itemQuantity);
                        total += itemTotal;
                        itemQuantity += parseInt(item.itemQuantity);

                        cartItems += `
                            <div class="cart-solo-row">
                                <div class="data-info">
                                    <span class="itemName">${item.itemName}</span>
                                    <span class="itemPrice">$${parseFloat(item.itemPrice).toFixed(2)}</span>
                                    <span class="itemQuantity">${item.itemQuantity}</span>
                                </div>
                                <div class="data-action-alt">
                                    <span class="action-button">
                                        <a href="delcart.php?cartId=${item.cartId}" class="delete-item"><i class="fas fa-trash-alt"></i></a>
                                    </span>
                                </div>
                                <div class="data-amount">
                                    <span>$${itemTotal.toFixed(2)}</span>
                                </div>
                            </div>
                        `;
                    });

                    $('#cart-wrapper .cart-items').html(cartItems);
                    $('#cart-wrapper .total-price').html(`<span>Sub Total:</span> <span>$${total.toFixed(2)}</span>`);
                    $('#cartButton strong').text(itemQuantity); // Update cart quantity in header
                } else {
                    $('#cart-wrapper .cart-items').html("<span class='msg-alt'>Your Cart is Empty! Please add some products to your cart.</span>");
                    $('#cart-wrapper .total-price').empty();
                    $('#cartButton strong').text('0'); // Update cart quantity in header
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    // Load cart on page load
    loadCart();
});
</script>
