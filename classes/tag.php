<?php
include_once 'lib/Database.php';
include_once 'helpers/format.php';
?>

<?php
class Tag
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function tagAdd($data) {
        $tagName = $this->fm->validation($data['tagName']);
        // Escape inputs to prevent SQL injection
        $tagName = mysqli_real_escape_string($this->db->link, $tagName);
        if (empty($tagName)) {
            $msg = "Fields must not be empty !!<br>";
            return $msg;
        } else {
                $query = "INSERT INTO tbl_tag(tagName) VALUES('$tagName')";
                $result = $this->db->insert($query);

                if ($result) {
                    return 'Inserted Successfully'; // Type inserted successfully
                } else {
                throw new Exception("Failed to Insert.");
            }
        }
    }


    public function tagList(){
        $query = "SELECT * FROM tbl_tag ORDER BY proTagId ASC";
        $result = $this->db->select($query);
        return $result;
    }

    // Catedit Function
    public function getTagById($proTagId){
        $proTagId = $this->fm->validation($proTagId);
        $proTagId = mysqli_real_escape_string($this->db->link, $proTagId);

        $query = "SELECT * FROM tbl_tag WHERE proTagId ='$proTagId'";
        $result = $this->db->select($query);
        return $result;
    }

    public function updateTag($proTagId, $tagName){
        // Validate inputs
        $tagName = $this->fm->validation($tagName);
        $tagName = mysqli_real_escape_string($this->db->link, $tagName);

        $proTagId = mysqli_real_escape_string($this->db->link, $proTagId);

        // Perform the update operation
        $query = "UPDATE tbl_tag SET tagName = '$tagName' WHERE proTagId = '$proTagId'";
        $result = $this->db->update($query);

        return $result; // Return the result of the update operation
    }


    public function DeleteTag($proTagId){
        // Prepare and execute the delete query
        $query = "DELETE FROM tbl_tag WHERE proTagId = '$proTagId'";
        $result = $this->db->delete($query);
        // Return the result of the deletion
        return $result;
    }

}
