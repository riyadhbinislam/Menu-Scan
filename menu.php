<?php include "inc/header.php";?>


<?php
// Start the session
Session::init();

// Check if table ID is set in the URL
if(isset($_GET['tableid'])) {
    // Store table ID in session
    $tableid  = $_GET['tableid'];
    $query = "SELECT * FROM tbl_table WHERE id = '$tableid'";
    $result = $db->select($query);
    if ($result) {
        while ($tabledata = $result->fetch_assoc()){
            $tableName           = $tabledata['tableName'];


if(isset($_GET['itemId'])){
    // 'itemId' parameter is set in the GET request
    $itemId = $_GET['itemId'];

    $query = "SELECT * FROM tbl_items WHERE itemId = '$itemId'";
    // Execute the query
    $result = $db->select($query);

    // Check if the table details are retrieved successfully
    if ($result) {
        while ($itemresult = $result->fetch_assoc()) {
            $itemId             = $itemresult['itemId'];
            $itemName           = $itemresult['itemName'];
            $itemCategory       = $itemresult['itemCategory'];
            $itemType           = $itemresult['itemType'];
            $itemDescription    = $itemresult['itemDescription'];
            $itemPrice          = $itemresult['itemPrice'];
            $itemImg            = $itemresult['itemImg'];
?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $itemQuantity = $_POST['itemQuantity'];
    $tableId = $_POST['tableName'];
    $addCart  = $cart->addToCart($itemQuantity, $itemId, $tableId);
    }
?>
            <div class="single-product-wrapper">
                <div class="sp-image">
                    <img src="<?php echo $itemresult['itemImg'];?>" alt="" />
                </div>
                <div class="sp-details">
                    <h1 class="sp-title"><?php echo $itemresult['itemName'];?></h1>
                    <div class="cart-wrap">
                        <form action="" method="post">
                            <input type="hidden" name="tableName" value="<?php echo $tableName; ?>">
                            <p class="sp-price">Price:<?php echo "$".$itemresult['itemPrice']." TK"; ?></p>
                            <span>Quantity:</span>
                            <input type="number" id="qty" value="1" name="itemQuantity"/>
                            <input type="submit" class="buysubmit" name="submit" value="Add To Cart">
                        </form>
                    </div>

                    <div class="sp-details">
                        <h4>Details</h4>
                        <span><?php echo $itemresult['itemDescription'];?></span>
                    </div>
                </div>
            </div>
            <?php    }}} ?>
<?php }}} else {
    // Handle case when 'itemId' parameter is missing
    header("Location: menuitems.php");
    exit();
}
?>


