
<?php include "inc/header.php";
Session::init(); // Initialize session
Session::checkSession(); // Check if the user is logged in
?>
<?php include "inc/sidenav.php";?>


<div class="main-content">
        <h2>Dashboard / Dining Table List</h2>

        <div class="items-data-table">
            <div class="table-heading">
                <span class="left">Table List</span>
                <div class="button-wrapper">
                    <a href="#filter" id="filter" class="border-button "><i class="fas fa-filter"></i><span>Filter</span></a>
                    <a href="#export" id="export" class="border-button "><i class="fas fa-file-export"></i><span>Export</span></a>
                    <a href="addtable.php" id="addItemBtn" class="border-button regular-button"><i class="fas fa-plus"></i><span>Add Table</span></a>
                </div>
            </div>
            <div class="container">
                <div class="table-wrapper">
                    <table class="item-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Seats</th>
                                <th>QR Link</th>
                                <th>QR Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php
                                    // Fetch product data and loop through each row to display it
                                    $query = "SELECT * FROM tbl_table ORDER BY id ASC";
                                    $result = $db->select($query);

                                    if ($result) {
                                        while ($tableresult = $result->fetch_assoc()) {
                                            // echo '<pre>';
                                            // print_r( $result );
                                            // echo '</pre>';
                                ?>
                            <tr>
                                <td><?php echo ucwords($tableresult['tableName']); ?></td>
                                <td><?php echo $tableresult['tableCapacity']; ?></td>
                                <td><?php echo $tableresult['qrText']; ?></td>
                                <td><img src="<?php echo $tableresult['qrImg']; ?>" alt="" width="80px" height="80px"></td>
                                <td>Active</td>
                                <td>
                                    <a href="itemedit.php?itemID=1" class="action-button edit-button"><i class="fas fa-edit"></i></a>
                                    <a href="itemdelete.php?itemID=1" class="action-button delete-button"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                           <?}}?>
                        </tbody>
                    </table>
        </div>
    </div>
</div>

