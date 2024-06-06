<?php include "inc/header.php";
Session::init(); // Initialize session
Session::checkSession(); // Check if the user is logged in
?>
<?php include "inc/sidenav.php";?>


<?php $db = new Database(); ?>

<div class="main-content">
<h2>Dashboard / Table</h2>
    <div class="container items-data-table">
        <div class="table-wrapper">
            <div class="formwrapper">

                <form action="qrcode.php" method="post" class="add-form" id="addTableForm" onsubmit="addTable(event)">
                    <label for="tableName">Table Name: </label>
                    <input type="text" name="tableName" id="tableName" required><br>

                    <label for="tableCapacity">Capacity : </label>
                    <input type="number" min="1" name="tableCapacity" id="tableCapacity"><br>

                    <button type="submit" name="addTable" onclick="addTable()">Submit</button>
                </form>
            </div>
        </div>
    </div>
<Section>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    function addTable(event) {
        // Prevent the default form submission behavior
        event.preventDefault();

        // Get form data
        var formData = $("#addTableForm").serialize();

        // Send AJAX request
        $.ajax({
            type: "POST",
            url: "qrcode.php",
            data: formData,
            success: function(response) {
                // Handle the response here
                alert("Table added successfully!");
                // Optionally, you can update the UI or redirect the user
            },
            error: function(xhr, status, error) {
                // Handle errors here
                alert("Error adding table: " + error);
            }
        });
    }
</script>

