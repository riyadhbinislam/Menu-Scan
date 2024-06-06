<?php
include_once 'lib/Database.php';
include_once 'helpers/format.php';
?>

<?php
class Type
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function typeAdd($data) {
        $typeName = $this->fm->validation($data['typeName']);
        $typeName = mysqli_real_escape_string($this->db->link, $typeName);

        // Insert into the database
        $query = "INSERT INTO tbl_type(typeName) VALUES('$typeName')";
        $result = $this->db->insert($query);

        if ($result) {
            return true; // Type inserted successfully
        } else{
            return false; // Type inserted failed
        }
    }

    public function typeList(){
        $query = "SELECT * FROM tbl_type ORDER BY proTypeId ASC";
        $result = $this->db->select($query);
        return $result;
    }

    // Catedit Function
    public function getTypeById($proTypeId){
        $proTypeId = $this->fm->validation($proTypeId);
        $proTypeId = mysqli_real_escape_string($this->db->link, $proTypeId);

        $query = "SELECT * FROM tbl_type WHERE proTypeId ='$proTypeId'";
        $result = $this->db->select($query);
        return $result;
    }

    public function updateType($typeName, $typeImage, $proTypeId){
        // Validate inputs
        $typeName = $this->fm->validation($typeName);
        $typeName = mysqli_real_escape_string($this->db->link, $typeName);

        $proTypeId = mysqli_real_escape_string($this->db->link, $proTypeId);

        // File upload handling
        $file_name = $typeImage['name'];
        $file_size = $typeImage['size'];
        $file_temp = $typeImage['tmp_name'];

        $file_parts = explode('.', $file_name);
        $file_ext = strtolower(end($file_parts));
        // Assuming the script is in the root directory and 'upload' folder exists
        $upload_directory = '../uploads/'; // Define upload directory
        $uploaded_image = $upload_directory . uniqid() . '.' . $file_ext; // Construct upload path

        // Check if the directory exists, if not, create it
        if (!file_exists($upload_directory)) {
            mkdir($upload_directory, 0777, true); // Create directory recursively
        }

        // Check if the directory creation was successful
        if (file_exists($upload_directory)) {
            // Move the uploaded file to the upload directory
            if (move_uploaded_file($file_temp, $uploaded_image)){
                // Perform the update operation
                $query = "UPDATE tbl_type SET
                            typeName        = '$typeName',
                            typeImage       = '$uploaded_image'
                            WHERE proTypeId    = '$proTypeId'";
                $result = $this->db->update($query);

                return $result; // Return the result of the update operation
            }
        }
    }

    public function DeleteType($proTypeId){
        // Prepare and execute the delete query
        $query = "DELETE FROM tbl_type WHERE proTypeId = '$proTypeId'";
        $result = $this->db->delete($query);
        // Return the result of the deletion
        return $result;
    }

}
