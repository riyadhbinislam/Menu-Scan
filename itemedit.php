<?php
    include "inc/adminheader.php";
    include_once "../classes/product.php";
    include_once "../lib/Database.php";

    // Check if itemID is provided in the URL
    if (!isset($_GET['itemID']) ||  $_GET['itemID'] == NULL) {
        echo "<script>window.location='items.php'</script>";
        exit; // Stop further execution
    } else {
        $itemID = $_GET['itemID'];
    }

    $pro = new Product();

    // Fetch product details by ID
    $product = $pro->getProById($itemID);
    $productResult = $product->fetch_assoc();
    // print_r( $_POST );
    // print_r( $_FILES );

?>
<div class="main-dashboard">
    <h2 class="section-title">Update Items</h2>
    <div class="block">
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Retrieve form data
            $itemName = $_POST['itemName'];
            $itemPrice = $_POST['itemPrice'];
            $itemDescription = $_POST['itemDescription'];
            $itemStatus = $_POST['itemStatus'];
            $itemSlug = $_POST['itemSlug'];
            $cateId = $_POST['cateId'];
            $typeId = $_POST['typeId'];
            $uploaded_image = $_FILES['image']['name'];

            if ($cateId == 'Select Category' || $typeId == 'Select Type') {
                echo '<span class="alert alert-danger">Please select valid options for category, brand, and type.</span>';
                exit; // Stop further execution
            }

            $updatePro = $pro->updateProduct($itemName, $itemPrice, $itemDescription, $itemStatus, $itemSlug, $cateId, $typeId, $uploaded_image, $itemId);
            if ($updatePro) {
                header("Location: items.php");
                exit;
            } else {
                echo '<span class="alert alert-danger">Failed to Update Product</span>';
            }
        }
    ?>
    <?php
        // Fetch product details by ID
        $product = $pro->getProById($itemId);
        if ($productResult = $product->fetch_assoc()) {
    ?>
        <form action="" method="post" enctype="multipart/form-data">
            <table class="add-product-form">
                <tr>
                    <td>
                        <label>Item Name</label>
                    </td>
                    <td>
                        <input type="text" name="itemName" value="<?php echo htmlspecialchars($productResult['itemName']); ?>" class="medium" />
                    </td>
                </tr>
                <label for="itemStatus">Item Status:</label>
                <select id="itemStatus" name="itemStatus">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select><br>
                <tr>
                    <td>
                        <label>Item Description</label>
                    </td>
                    <td>
                        <textarea type="text" name="itemDescription" cols="40" rows="5"><?php echo htmlspecialchars($productResult['itemDescription']); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Item Description</label>
                    </td>
                    <td>
                        <textarea type="text" name="itemDescription" cols="40" rows="5"><?php echo htmlspecialchars($productResult['itemDescription']); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label>Product Price</label>
                    </td>
                    <td>
                        <input type="text" name="itemPrice" value="<?php echo htmlspecialchars($productResult['itemPrice']); ?>" class="medium" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Upload Product Image</label>
                    </td>
                    <td>
                        <input type="file" name="image" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Category</label>
                    </td>
                    <td>
                        <select id="select" name="cateId">
                            <option>Select Category</option>
                            <?php
                                $query = "SELECT * FROM tbl_category";
                                $category = $db->select($query);
                                if ($category) {
                                    while ($result = $category->fetch_assoc()) {?>
                                        <option value="<?php echo $result['cateId']; ?>"><?php echo $result['cateName']; ?></option>
                            <?php }} ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Type</label>
                    </td>
                    <td>
                        <select id="select" name="typeId">
                            <option>Select Type</option>
                            <?php
                                $query = "SELECT * FROM tbl_type";
                                $category = $db->select($query);
                                if ($category) {
                                    while ($result = $category->fetch_assoc()) {?>
                                        <option value="<?php echo $result['typeId']; ?>"><?php echo $result['typeName']; ?></option>
                            <?php }} ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="Update" />
                    </td>
                </tr>
            </table>
        </form>
        <?php
                } else {
                    echo "Product not found."; // Handle product not found error
                }
            ?>
        </div>
    </div>
</div>
<?php //include "inc/adminfooter.php";?>
