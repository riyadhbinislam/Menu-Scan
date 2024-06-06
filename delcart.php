<?php include ("inc/header.php") ;?>

<?php
// Assuming $db is an instance of the Database class
if (!isset($_GET['cartId']) || $_GET['cartId'] == NULL) {
    echo "<script>window.location = 'cart.php';</script>";
} else {
    $cartId = $_GET["cartId"];
    $query  = "SELECT * FROM tbl_cart WHERE cartId='$cartId'";
    $getData = $db->select($query);

    if ($getData) {
        $delquery = "DELETE FROM tbl_cart WHERE cartId='$cartId' ";
        $delData = $db->delete($delquery);
        // Redirect to show all data in the table again after deleting a row
        //echo '<meta http-equiv="refresh" content="0;url=cart.php">';
        if ($delData) {
            $msg = "<span class='msg-alt'>Delete Data!</span>";
        } else {
            $msg = "<span class='msg-alt'>Failed To Delete Data!!</span>";
        }

        // Return the response message
        echo $msg;
        echo '<meta http-equiv="refresh" content="0;url=menuitems.php?tableid='.urlencode($tableid).'">';
       // header("Location: menuitems.php?tableid=" . urlencode($tableid));
        exit();
    }

};
?>

<?php include ("inc/footer.php") ;?>


