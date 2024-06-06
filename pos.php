<?php include "inc/header.php";?>
<?php include "inc/sidenav.php";?>

<div class="container">

    <h2>POS</h2>
    <div class="grid-item ">
        <div class="grid-templete-head">
           <div class="category-list">

                <a href="" class="cate-list-card">
                    <img src="" alt="">
                    <h4>All items</h4>
                </a>

            </div>
        </div>
        <div class="grid-templete-cateList">
            <div class="table-wrapper item-list">
            <?php
                // Fetch product data and loop through each row to display it
                $products = $pro->proList();

                if ($products) {
                    while ($result = $products->fetch_assoc()) {
                        // echo '<pre>';
                        // print_r( $result );
                        // echo '</pre>';
            ?>
                <div class="item-list-card">
                    <div class="image-box">
                        <img src="<?php echo $result['itemImg']; ?>" alt="">
                    </div>
                    <div class="content-box">
                        <p class="itemName"><?php echo $result['itemName']; ?></p>
                        <div class="price-wrap">
                            <span>$<?php echo $result['itemPrice']; ?></span>
                            <a href="cart.php"><span>Add To Cart</span></a>
                        </div>

                    </div>
                </div>
            <?}}?>
            </div>
        </div>
    </div>
</div>

    </div>
</div>


<?php include "inc/footer.php";?>
<style>
    .item-list-card {
    display: block;
    width: 250px;
    max-width: 100%;
    border-radius: 15px !important;
    border: 2px solid;
    background: #fff;
}

.item-list-card .content-box {
    background: #fff;
    padding: 10px;
}

.price-wrap {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
}
</style>