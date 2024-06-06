<?php
include_once 'lib/Database.php';
include_once 'helpers/format.php';
?>

<?php
class Product
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function proAdd($data, $file) {
        $itemName = $this->fm->validation($data['itemName']);
        $cateId = $this->fm->validation($data['cateId']);
        $typeId = $this->fm->validation($data['typeId']);
        $itemDescription = $this->fm->validation($data['itemDescription']);
        $itemPrice = $this->fm->validation($data['itemPrice']);
        $itemStatus = $this->fm->validation($data['itemStatus']);
        $itemSlug = $this->fm->validation($data['itemSlug']);

        // Escape inputs to prevent SQL injection

        $itemName = mysqli_real_escape_string($this->db->link, $itemName);
        $cateId = mysqli_real_escape_string($this->db->link, $cateId);
        $typeId = mysqli_real_escape_string($this->db->link, $typeId);
        $itemDescription = mysqli_real_escape_string($this->db->link, $itemDescription);
        $itemPrice = mysqli_real_escape_string($this->db->link, $itemPrice);
        $itemStatus = mysqli_real_escape_string($this->db->link, $itemStatus);
        $itemSlug = mysqli_real_escape_string($this->db->link, $itemSlug);

        $permited = array('jpg', 'jpeg', 'png', 'gif', 'webP');
        $file_name = $file['itemImg']['name'];
        $file_size = $file['itemImg']['size'];
        $file_temp = $file['itemImg']['tmp_name'];

        $file_parts = explode('.', $file_name);
        $file_ext = strtolower(end($file_parts));
        // Assuming the script is in the root directory and 'upload' folder exists
        $upload_directory = 'images/menu-items'; // Define upload directory
        $uploaded_image = $upload_directory . uniqid() . '.' . $file_ext; // Construct upload path

        // Check if the directory exists, if not, create it
        if (!file_exists($upload_directory)) {
            mkdir($upload_directory, 0777, true); // Create directory recursively
        }

        // Check if the directory creation was successful
        if (file_exists($upload_directory)) {
            // Move the uploaded file to the upload directory
            if (move_uploaded_file($file_temp, $uploaded_image)) {
                // File moved successfully, now insert into the database
                $query = "INSERT INTO tbl_items( itemName, itemCategory, itemType, itemDescription, itemPrice, itemStatus, itemImg, itemSlug )
                        VALUES('$itemName', '$cateId', '$typeId', '$itemDescription','$itemPrice','$itemStatus', '$uploaded_image', '$itemSlug')";
                $result = $this->db->insert($query);

                if ($result) {
                    return true; // Product inserted successfully
                } else {
                    return false; // Failed to insert product
                }
            } else {
                return false; // Failed to move the uploaded file
            }
        } else {
            return false; // Failed to create upload directory
        }
    }

    public function proList(){
        $query = "SELECT tbl_items.*,
        tbl_category.cateName AS categoryName,
        tbl_type.typeName AS typeName
        FROM tbl_items
        INNER JOIN tbl_category ON tbl_items.itemCategory = tbl_category.cateId
        INNER JOIN tbl_type ON tbl_items.itemType = tbl_type.typeId
        ORDER BY tbl_items.itemId DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function getProById($itemId){
        $itemId = $this->fm->validation($itemId);
        $itemId = mysqli_real_escape_string($this->db->link, $itemId);

        $query = "SELECT * FROM tbl_items WHERE itemId ='$itemId'";
        $result = $this->db->select($query);
        return $result;
    }

    public function updateProduct($itemName, $itemCategory, $itemType, $itemDescription, $itemPrice, $itemStatus, $uploaded_image, $itemId, $itemSlug){
        // Validate and sanitize form data
        $itemName = $this->fm->validation($_POST['itemName']);
        $itemCategory = $this->fm->validation($_POST['itemCategory']);
        $itemType = $this->fm->validation($_POST['itemType']);
        $itemDescription = $this->fm->validation($_POST['itemDescription']);
        $itemPrice = $this->fm->validation($_POST['itemPrice']);

        $itemStatus = $this->fm->validation($_POST['itemStatus']);
        $itemSlug = $this->fm->validation($_POST['$itemSlug']);


        // Escape inputs to prevent SQL injection
        $itemName = mysqli_real_escape_string($this->db->link, $itemName);
        $itemCategory = mysqli_real_escape_string($this->db->link, $itemCategory);
        $itemType = mysqli_real_escape_string($this->db->link, $itemType);
        $itemDescription = mysqli_real_escape_string($this->db->link, $itemDescription);
        $itemPrice = mysqli_real_escape_string($this->db->link, $itemPrice);
        $itemStatus = mysqli_real_escape_string($this->db->link, $itemStatus);
        $itemId = mysqli_real_escape_string($this->db->link, $itemId);
        $itemSlug = mysqli_real_escape_string($this->db->link, $itemSlug);

        // Check if a file is uploaded
        if ($_FILES['image']['name']) {
            $permited = array('jpg', 'jpeg', 'png', 'gif', 'webP');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];

            $file_parts = explode('.', $file_name);
            $file_ext = strtolower(end($file_parts));
            $uploaded_image = '../images/' . uniqid() . '.' . $file_ext;
            $upload_path = $uploaded_image;

            // Move the uploaded file to the "upload" folder
            if (in_array($file_ext, $permited) && $file_size <= 1048576) {
                if (move_uploaded_file($file_temp, $upload_path)) {
                    // Update with the new image
                    $query = "UPDATE tbl_items SET
                                itemName    = '$itemName',
                                itemCategory    = '$itemCategory',
                                itemType  = '$itemType',
                                itemDescription       = '$itemDescription',
                                itemPrice     = '$itemPrice',
                                itemStatus      = '$itemStatus',
                                itemImg    = '$uploaded_image'
                                WHERE itemId = '$itemId'";
                } else {
                    // Failed to move the uploaded file
                    return false;
                }
            } else {
                // Invalid file type or size exceeds the limit
                return false;
            }
        } else {
            // Update without changing the image
            $query = "UPDATE tbl_items SET
                        itemName    = '$itemName',
                        itemCategory    = '$itemCategory',
                        itemType  = '$itemType',
                        itemDescription       = '$itemDescription',
                        itemPrice     = '$itemPrice',
                        itemStatus      = '$itemStatus',
                        itemSlug      = '$itemSlug'
                        WHERE itemId = '$itemId'";
        }

        // Execute the update query
        $result = $this->db->update($query);

        // Check if the update was successful
        if ($result) {
            return true; // Product updated successfully
        } else {
            return false; // Failed to update product
        }
    }


    public function DeleteProduct($itemId){
        // Prepare and execute the delete query
        $query = "DELETE FROM tbl_items WHERE itemId = '$itemId'";
        $result = $this->db->delete($query);
        // Return the result of the deletion
        return $result;
    }
}
      // Catedit Function
?>

