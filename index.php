<?php include "inc/header.php";?>

<style>
    .login-wrapper {
        min-height: 100vh;
    }
</style>
<section class="main-content ">
        <div class="login-wrapper container">
            <h2>Dashboard / Dining Table List</h2>
            <div id="show-qr" class="flex-wrapper">
                <?php
                    $query = "SELECT * FROM tbl_table ORDER BY id ASC";
                    $result = $db->select($query);
                    if ($result) {
                            while ($qrresult = $result->fetch_assoc()) {

                    ?>
                    <div class="table">
                        <h2><?php echo $qrresult['tableName']; ?></h2>
                        <div class="qr">
                            <img src="<?php echo $qrresult['qrImg']; ?>" alt="">
                        </div>
                        <div class="sub-head">
                            <p>Scan Me</p>
                        </div>
                    </div>
                <?}}?>

            </div>
        </div>
</section>

<?php include 'inc/footer.php';?>
