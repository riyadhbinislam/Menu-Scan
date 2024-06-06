<?php
include_once 'lib/Database.php';
include_once 'helpers/format.php';
?>

<?php
class Category
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function catAdd($data){
        if(is_array($data) && isset($data['catName'])) {
            $catName = $this->fm->validation($data['catName']);
            $catName = mysqli_real_escape_string($this->db->link, $catName);

            if (empty($catName)) {
                $msg = "Fields must not be empty !!<br>";
                return $msg;
            } else {
                $query = "INSERT INTO tbl_categories(catName) VALUES ('$catName')";
                $result = $this->db->insert($query);

                if ($result) {
                    $msg = "<span class='success'>Category Inserted Successfully</span><br>";
                    return $msg;
                } else {
                    $msg = "<span class='error'>Category Not Inserted</span><br>";
                    return $msg;
                }
            }
        } else {
            $msg = "<span class='error'>Invalid data format</span><br>";
            return $msg;
        }
    }


    public function catList(){
        $query = "SELECT * FROM tbl_categories ORDER BY proCategoriesId ASC";
        $result = $this->db->select($query);
        return $result;
    }

    // Catedit Function
    public function getCatById($catid){
        $catid = $this->fm->validation($catid);
        $catid = mysqli_real_escape_string($this->db->link, $catid);

        $query = "SELECT * FROM tbl_categories WHERE catid ='$catid'";
        $result = $this->db->select($query);
        return $result;
    }

    public function updateCategory($catid, $catName){
        // Validate inputs
        $catid = $this->fm->validation($catid);
        $catName = $this->fm->validation($catName);
        $catid = mysqli_real_escape_string($this->db->link, $catid);
        $catName = mysqli_real_escape_string($this->db->link, $catName);

        if(empty($catName) || empty($catid)){
            return false; // Return false if either name or id is empty
        }else{
             // Perform the update operation
         // Return the result of the update operation
        $query = "UPDATE tbl_categories SET catName = '$catName' WHERE catid = '$catid'";
        $result = $this->db->update($query);
        return $result;
        }
    }

    public function DeleteCategory($proCategoriesId){
        // Prepare and execute the delete query
        $query = "DELETE FROM tbl_categories WHERE proCategoriesId = '$proCategoriesId'";
        $result = $this->db->delete($query);
        // Return the result of the deletion
        return $result;
    }

}
