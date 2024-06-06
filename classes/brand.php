<?php
include_once 'lib/Database.php';
include_once 'helpers/format.php';
?>

<?php
class Brand
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function brandAdd($data) {
        $brandName = $this->fm->validation($data['brandName']);
        // Escape inputs to prevent SQL injection
        $brandName = mysqli_real_escape_string($this->db->link, $brandName);
        if (empty($brandName)) {
            $msg = "Fields must not be empty !!<br>";
            return $msg;
        } else {
                $query = "INSERT INTO tbl_brand(brandName) VALUES('$brandName')";
                $result = $this->db->insert($query);

                if ($result) {
                    return 'Inserted Successfully'; // Type inserted successfully
                } else {
                throw new Exception("Failed to Insert.");
            }
        }
    }


    public function brandList(){
        $query = "SELECT * FROM tbl_brand ORDER BY proBrandId ASC";
        $result = $this->db->select($query);
        return $result;
    }

    // Catedit Function
    public function getBrandById($proBrandId){
        $proBrandId = $this->fm->validation($proBrandId);
        $proBrandId = mysqli_real_escape_string($this->db->link, $proBrandId);

        $query = "SELECT * FROM tbl_brand WHERE proBrandId ='$proBrandId'";
        $result = $this->db->select($query);
        return $result;
    }

    public function updateBrand($proBrandId, $brandName){
        // Validate inputs
        $brandName = $this->fm->validation($brandName);
        $brandName = mysqli_real_escape_string($this->db->link, $brandName);

        $proBrandId = mysqli_real_escape_string($this->db->link, $proBrandId);

        // Perform the update operation
        $query = "UPDATE tbl_brand SET brandName = '$brandName' WHERE proBrandId = '$proBrandId'";
        $result = $this->db->update($query);

        return $result; // Return the result of the update operation
    }


    public function DeleteBrand($proBrandId){
        // Prepare and execute the delete query
        $query = "DELETE FROM tbl_brand WHERE proBrandId = '$proBrandId'";
        $result = $this->db->delete($query);
        // Return the result of the deletion
        return $result;
    }

}
