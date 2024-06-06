<?php include "inc/header.php";?>
<?php include_once "lib/Database.php";?>
<?php include "inc/sidenav.php";?>

<style>
    #additem {
        width: 700px;
        max-width: 100%;
        margin: 0 auto;
        border: 1px solid #d8d8d8;
        padding: 30px 40px;
    }

    #additem label {
        font-size: 1.8rem;
        line-height: 1.8;
    }

    #itemDescription,
    input {
        width: 100%;
        padding: 5px;
        line-height: 1.8;
        font-size: 1.8rem;
        border-radius: 8px;
        border-color: #d1d1d1;
        margin: 5px 0;
    }

    #itemStatus {
        font-size: 1.8rem;
        padding: 5px;
        margin-left: 30px;
    }

    #additem input[type="submit"] {
        margin-top: 30px;
        cursor: pointer; /* Add cursor pointer for submit button */
    }

    .message {
        margin-top: 20px;
        font-size: 1.6rem;
    }
</style>

<section>
    <div class="container">
        <h1>Add New Item</h1>

        <form id="additem" enctype="multipart/form-data">
            <label class="" for="itemName">Item Name:</label><br>
            <input class="" type="text" id="itemName" name="itemName"><br>

            <label for="itemCategory">Item Category:</label>
            <select id="proCategoriesId" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="cateId">
                <option>Select Category</option>
                <?php
                    $query = "SELECT * FROM tbl_category";
                    $category = $db->select($query);
                    if ($category) {
                        while ($result = $category->fetch_assoc()) {?>
                            <option value="<?php echo $result['cateId']; ?>"><?php echo $result['cateName']; ?></option>
                <?php }} ?>
            </select><br>

            <label for="itemType">Item Type:</label>
            <select id="proCategoriesId" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="typeId">
                <option>Select Type</option>
                <?php
                    $query = "SELECT * FROM tbl_type";
                    $category = $db->select($query);
                    if ($category) {
                        while ($result = $category->fetch_assoc()) {?>
                            <option value="<?php echo $result['typeId']; ?>"><?php echo $result['typeName']; ?></option>
                <?php }} ?>
            </select><br>

            <label for="itemDescription">Item Description:</label><br>
            <textarea id="itemDescription" name="itemDescription" rows="4" cols="50"></textarea><br>

            <label for="itemPrice">Item Price:</label><br>
            <input type="text" id="itemPrice" name="itemPrice"><br>

            <label for="itemStatus">Item Status:</label>
            <select id="itemStatus" name="itemStatus">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select><br>

            <label for="itemImg">Item Image:</label><br>
            <input type="file" id="itemImg" name="itemImg"><br>

            <label for="itemSlug">Item Slug:</label><br>
            <input type="text" id="itemSlug" name="itemSlug"><br>

            <input type="submit" class="submit" value="Submit">
            <div id="message"></div>
        </form>

    </div>
</section>
<script src="js/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#additem').submit(function(e){
            e.preventDefault(); // Prevent the form from submitting normally

            let formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "additem_handler.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    $('#message').html(response);
                    $('#additem')[0].reset(); // Clear the form fields after successful submission
                },
                error: function(){
                    $('#message').html("There was an error adding the item to the cart.");
                }
            });
        });
    });
</script>
<?php include "inc/footer.php"; ?>
