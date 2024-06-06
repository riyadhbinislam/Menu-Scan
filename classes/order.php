<?php
include_once 'lib/Database.php';
include_once 'helpers/format.php';
?>


<?php
class Order
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    //add product to cart
    public function getAllorder(){
        $query = "SELECT * FROM tbl_order ORDER BY date  DESC";
        $result  = $this->db->select($query);
        return  $result;
    }

    public function proshift($userId, $proPrice, $date){
        $userId = $this->fm->validation($userId);
        $userId = mysqli_real_escape_string($this->db->link, $userId);

        $proPrice = $this->fm->validation($proPrice);
        $proPrice = mysqli_real_escape_string($this->db->link, $proPrice);

        $date = $this->fm->validation($date);
        $date = mysqli_real_escape_string($this->db->link, $date);

        $query = "UPDATE tbl_order
                SET status = '1'
                WHERE userId = '$userId' AND
                date = '$date' AND
                proPrice = '$proPrice' ";

        // Debug: Check the query
        // echo "Query: " . $query;

        $updated_row = $this->db->update($query);
        if ($updated_row) {
            $msg = "<span class='msg'>Product Shifted Successfully</span>";
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "checkorder";
                    }, 3000);
                  </script>';
            return $msg;
        } else {
            $msg = "<span>Product Not Shifted</span>";
            return $msg;
        }
    }

    public function delProShift($userId, $price, $date){
        $userId = $this->fm->validation($userId);
        $userId = mysqli_real_escape_string($this->db->link, $userId);

        $price = $this->fm->validation($price);
        $price = mysqli_real_escape_string($this->db->link, $price);

        $date = $this->fm->validation($date);
        $date = mysqli_real_escape_string($this->db->link, $date);

        $query = "DELETE FROM  tbl_order WHERE userId = '$userId' AND date = '$date' AND  price = '$price' ";;
        $result = $this->db->delete($query);
        if($result){
            $msg = "<span>Data Deleted Successfully</span>";
            return $msg;
        }else{
            $msg = "<span>Data Not Deleted</span>";
            return $msg;
        }
    }

    public function getInvoice($orderGroupId){
        $query = "SELECT * FROM tbl_order WHERE order_grp_id = '$orderGroupId' ORDER BY date DESC";
        $result  = $this->db->select($query);
        return  $result;
    }


}