<?php
include_once 'lib/Database.php';
include_once 'helpers/format.php';
?>


<?php
class Cart
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    //add product to cart
    public function addToCart($itemQuantity, $itemId, $tableid) {
        $itemQuantity   = $this->fm->validation($itemQuantity);
        $itemQuantity   = mysqli_real_escape_string($this->db->link, $itemQuantity);

        $itemId = $this->fm->validation($itemId);
        $itemId = mysqli_real_escape_string($this->db->link, $itemId);

        $tableid = $this->fm->validation($tableid);
        $tableid = mysqli_real_escape_string($this->db->link, $tableid);

        // Get session ID
        $sId = session_id();
        if(empty($itemQuantity) || empty($itemId) || empty($tableid)) {
            return "All fields are required.";
        }else{
            $squery      = "SELECT * FROM tbl_items WHERE itemId ='$itemId'";
            $result     = $this->db->select($squery)->fetch_assoc();

            $itemName = $result['itemName'];
            $itemPrice = $result['itemPrice'];


            $checkQuery = "SELECT * FROM tbl_cart WHERE sId ='$sId' AND itemId ='$itemId' ";
            $countResult = $this->db->select($checkQuery);


            if ($countResult) {
                // Item already exists in the cart, show a message and redirect
                echo "<script>";
                echo "var message = This product is already added to your cart.";
                echo "alert(message);";
                echo "</script>";
                echo "<script>window.location.href = 'menuitems.php?tableid=" . urlencode($tableid) . "';</script>";
                exit;

            } else {
                // Insert the item into the cart
                $query = "INSERT INTO tbl_cart (sId, itemId, itemName, itemPrice, itemQuantity, tableid)
                        //   VALUES ('$sId', '$itemId', '$itemName', '$itemPrice', '$itemQuantity', '$tableid')";

                $insertedRow = $this->db->insert($query);

                if ($insertedRow) {
                    echo "<script>alert('Item successfully added to the cart');</script>";
                    echo "<script>window.location.href = 'menuitems.php?tableid=" . urlencode($tableid) . "';</script>";
                } else {
                    // Unable to insert item into the cart, show an error message
                    echo "<div class='container'><h2>Failed To Add Items</h2></div>";
                }


            }

    }
}
    //Show item from the shopping cart According to  Session ID
    public function getCartProduct($tableid) {
        $query = "SELECT * FROM tbl_cart WHERE tableid = '$tableid'";
        $result = $this->db->select($query);
        return $result;
    }

    public function updateCart($itemQuantity, $cartId, $tableid, $itemId){
        $itemQuantity = $itemQuantity !== null ? mysqli_real_escape_string($this->db->link, $itemQuantity) : '';
        $cartId = $cartId !== null ? mysqli_real_escape_string($this->db->link, $cartId) : '';
        $tableid = $tableid !== null ? mysqli_real_escape_string($this->db->link, $tableid) : '';
        $itemId = $itemId !== null ? mysqli_real_escape_string($this->db->link, $itemId) : '';


        if(empty($itemQuantity) || empty($cartId) || empty($tableid) || empty($itemId)) {
            return "All fields are required.";
        }else{
            $updateQuery    = "UPDATE tbl_cart
                           SET itemQuantity ='$itemQuantity'
                           WHERE cartId = '$cartId' ";
            $updatedRow     = $this->db->update($updateQuery);

            if($updatedRow){
                $msg = "Update Quantity!";
                echo json_encode(['message' => $msg]);
                echo "<script>window.location.href = 'menuitems.php?tableid=" . urlencode($tableid) . "';</script>";
                }else{
                    $msg = "Failed To Update Quantity!";
                    echo json_encode(['message' => $msg]);
                    echo "<script>window.location.href = 'menuitems.php?tableid=" . urlencode($tableid) . "';</script>";
                    }
        }

    }


    public function  deleteFromCart($cartId){
        $cartId     = mysqli_real_escape_string($this->db->link, $cartId);
        $query      = "DELETE FROM tbl_cart WHERE cartId = '$cartId'";
        $deleteRow  = $this->db->delete($query);

        if($deleteRow){
            $msg  = "<span class='msg-alt'>Item Deleted From Cart Successfully!</span>";
            return $msg;
        }else{
            $msg  = "<span class='msg-alt'>Item Not Deleted From Cart !</span>";
            return $msg;

        }
    }

    public function checkCartTable(){
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
        $result  = $this->db->select($query);
        return  $result;
    }

      public function delCart(){
        $sId = session_id();
        $query = "DELETE FROM tbl_cart WHERE sId = '$sId'";
        $this->db->delete($query);
    }

    public function orderItem(){
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
        $getPro = $this->db->select($query);

        if($getPro){
            // Get the highest existing order group ID
            $query = "SELECT MAX(order_grp_id) AS max_id FROM tbl_order";
            $result = $this->db->select($query);
            $row = $result->fetch_assoc();
            $maxGroupId = $row['max_id'];

            // Determine the next order group ID
            $nextGroupId = uniqid();

            while($result   = $getPro->fetch_assoc()){
                $itemId     = $result['itemId'];
                $tableId     = $result['tableId'];
                $itemName   = $result['itemName'];
                $itemQuantity   = $result['itemQuantity'];
                $itemPrice      = $result['itemPrice'];
                $sId      = $result['sId'];

                // Insert the order with the determined group ID
                $query = "INSERT INTO tbl_order (itemId, tableId, itemPrice, itemQuantity, itemName, order_grp_id, sId)
                      VALUES ('$itemId', '$tableId', '$itemPrice', '$itemQuantity', '$itemName', '$nextGroupId', '$sId')";

                $inserted_row = $this->db->insert($query);
            }

            // Once all orders are inserted, delete them from the cart
            $query = "DELETE FROM tbl_cart WHERE sId = '$sId'";
            $this->db->delete($query);
        }
    }

    public function payableAmount($tableid){
        $query = "SELECT * FROM tbl_order WHERE tableId = '$tableid' AND date= now() ";
        $result  = $this->db->select($query);
        return  $result;
    }

    public function getOrderDetails($tableid, $sId){
        $query = "SELECT * FROM tbl_order WHERE tableid = '$tableid' AND sID = '$sId' ORDER BY itemId DESC";
        $result  = $this->db->select($query);
        return  $result;
    }

    public function chkOrder($tableid){
        $query = "SELECT * FROM tbl_order WHERE tableId = '$tableid'";
        $result  = $this->db->select($query);
        return  $result;
    }
    public function getAllorder(){
        $query = "SELECT * FROM tbl_order ORDER BY date  DESC";
        $result  = $this->db->select($query);
        return  $result;
    }

    public function getOrderDetailsByOrderId($orderGrpId){
        $query = "SELECT * FROM tbl_order WHERE order_grp_id = '$orderGrpId' ORDER BY itemId DESC";
        $result  = $this->db->select($query);
        return  $result;
    }
}
