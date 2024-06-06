<?php include "inc/header.php";
Session::init(); // Initialize session
Session::checkSession(); // Check if the user is logged in
?>
<?php include "inc/sidenav.php";?>
<style>

</style>
    <div class="main-content">
        <h2>Dashboard / Items</h2>

        <div class="items-data-table">
            <div class="table-heading">
                <span class="left">Items Table</span>
                <div class="button-wrapper">
                    <a href="#filter" id="filter" class="border-button "><i class="fas fa-filter"></i><span>Filter</span></a>
                    <a href="#export" id="export" class="border-button "><i class="fas fa-file-export"></i><span>Export</span></a>
                    <a href="additem.php" id="addItemBtn" class="border-button regular-button"><i class="fas fa-plus"></i><span>Add Item</span></a>
                </div>
            </div>
            <div class="container">
                <div class="table-wrapper">
                    <table class="item-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // Fetch product data and loop through each row to display it
                                $products = $pro->proList();

                                if ($products) {
                                    while ($result = $products->fetch_assoc()) {
                                        // echo '<pre>';
                                        // print_r( $result );
                                        // echo '</pre>';
                            ?>
                            <tr>
                                <td>
                                    <img src="../<?php echo $result['itemImg']; ?>" alt="<?php echo $result['itemName']; ?>" style="max-width: 100px;">
                                </td>
                                <td><?php echo $result['itemName']; ?></td>
                                <td><?php echo $result['itemCategory']; ?></td>
                                <td><?php echo $result['itemType']; ?></td>
                                <td><?php echo $fm->readmore($result['itemDescription'], 50); ?></td>
                                <td><?php echo $result['itemPrice']; ?></td>
                                <td><?php echo $result['itemStatus']; ?></td>


                                <td>
                                    <a href="singleitem.php?itemId=<?php echo $result['itemId'];?>" class="action-button view-button"><i class="fas fa-eye"></i></a>
                                    <a href="itemedit.php?itemId=<?php echo $result['itemId'];?>" class="action-button edit-button"><i class="fas fa-edit"></i></a>
                                    <span class="acction-button">
                                        <a onclick="return confirm ('Are You sure to Delete')" href="itemdelete.php?itemId=<?php echo $result['itemId'];?>" class="action-button delete-button"><i class="fas fa-trash-alt"></i></a>
                                    </span>
                                </td>
                            </tr>
                            <?}}?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>


<?php include "inc/footer.php";?>
