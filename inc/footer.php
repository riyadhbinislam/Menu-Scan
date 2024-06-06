<section id="footer" class="footer">

<div id="sideNav">
    <!-- Your side navigation content here -->
    <?php include "cart.php";?>
</div>

</section>
</body>
</html>

<script src="js/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    var cartButton = document.getElementById('cartButton');
    var sideNav = document.getElementById('sideNav');

    // Toggle side nav visibility when cart button is clicked
    cartButton.addEventListener('click', function (event) {
        event.stopPropagation(); // Prevent click event from bubbling up to window
        sideNav.style.right = sideNav.style.right === '0px' ? '-350px' : '0px';
    });

    // Close side nav when clicking outside of it
    window.addEventListener('click', function (event) {
        if (!sideNav.contains(event.target) && sideNav.style.right === '0px') {
            sideNav.style.right = '-350px';
        }
    });
});

</script>

<script>
    // Get the modal element
    var modal = document.getElementById("confirmationModal");

    // Get all elements with the class ".acction-button"
    var buttons = document.querySelectorAll(".acction-button a");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // Function to handle click on each button
    buttons.forEach(function(button) {
        button.onclick = function() {
            modal.style.display = "block";
            var link = this;
            // When the user clicks on the confirm button, proceed with the action
            document.getElementById("confirmBtn").onclick = function() {
                window.location.href = link.href;
            }
            return false; // prevent default action of the link
        }
    });

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

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
            }
        });
    }

    // Load cart on page load
    loadCart();

    // Bind add to cart functionality and update cart on success
    $('.buysubmit').click(function(e){
        e.preventDefault();
        var $form = $(this).closest('.add-to-cart-form');
        var itemId = $form.find('input[name="itemId"]').val();
        var tableid = $form.find('input[name="tableid"]').val();
        var itemQuantity = $form.find('.qty').val();

        $.ajax({
            type: "POST",
            url: "add_to_cart.php",
            data: {
                itemId: itemId,
                tableid: tableid,
                itemQuantity: itemQuantity
            },
            success: function(response){
                $('#cartMessage').html(response).addClass('show');
                setTimeout(function(){
                    $('#cartMessage').removeClass('show');
                }, 3000); // Hide after 3 seconds

                loadCart(); // Reload cart after adding item
            },
            error: function(){
                $('#cartMessage').html("There was an error adding the item to the cart.").addClass('show');
                setTimeout(function(){
                    $('#cartMessage').removeClass('show');
                }, 3000); // Hide after 3 seconds
            }
        });
    });
});
</script>