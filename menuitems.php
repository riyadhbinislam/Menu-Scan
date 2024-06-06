<?php include "inc/header.php";?>
<style>
#cartMessage {
    display: block;
    position: fixed;
    right: -300px;
    top: 10%;
    transform: translateY(-50%);
    width: 300px;
    padding: 20px;
    background-color: #f8f8f8;
    color: var(--heading-color);
    border: 1px solid var(--heading-color);
    border-radius: 15px;
    text-align: center;
    border-radius: 5px;
    z-index: 1000;
    transition: right 0.5s ease-in-out;
}

#cartMessage.show {
    display: block;
    right: 20px;
}
</style>
<?php
// Start session to store table ID
Session::init();

// Check if table ID is set in the query string
if (isset($_GET['tableid'])) {
    // Store table ID in session
    $_SESSION['tableid'] = $_GET['tableid'];
    $qrtable = Session::get("tableid");
} else {
    echo "Table ID not provided.";
    header("Location: index.php");
    exit;
}

$cateId = isset($_GET['cateId']) ? $_GET['cateId'] : null;
$typeId = isset($_GET['typeId']) ? $_GET['typeId'] : null;
?>
<section>
    <div class="container">
        <div class="table-info">
            <h2>Table Information</h2>
            <h3>
                <?php
                echo "Table ID: " . $qrtable . "<br>";
                ?>
            </h3>
            <div id="cartMessage"></div>

        </div>
    </div>
</section>

<section>
    <div class="container">
        <h2>All Category</h2>
        <div class="cate-wrapper">
            <?php
            $query = "SELECT * FROM tbl_category";
            $result = $db->select($query);
            // Check if the table details are retrieved successfully
            if ($result) {
                while ($cateresult = $result->fetch_assoc()) {
                    $cateIdLink = $cateresult['cateId'];
                    $cateName = $cateresult['cateName'];
                    ?>
                    <a href="?tableid=<?php echo urlencode($tableid); ?>&cateId=<?php echo $cateIdLink; ?>"><?php echo $cateName; ?></a>
                <?php
                }
            }
            ?>
        </div>
        <h2>All Type</h2>
        <div class="type-wrapper">
            <?php
            $query = "SELECT * FROM tbl_type";
            $result = $db->select($query);
            // Check if the table details are retrieved successfully
            if ($result) {
                while ($typeresult = $result->fetch_assoc()) {
                    $typeIdLink = $typeresult['typeId'];
                    $typeName = $typeresult['typeName'];
                    //$itemId = $itemresult['itemId'];
                    ?>
                    <a href="?tableid=<?php echo urlencode($tableid); ?>&typeId=<?php echo $typeIdLink; ?>"><?php echo $typeName; ?></a>
                <?php
                }
            }
            ?>
        </div>

        <div class="item-wrapper">
            <h2>All Items</h2>
            <div class="grid-menu">
                <?php
                // Modify the query based on selected category or type
                $query = "SELECT * FROM tbl_items";
                if ($cateId) {
                    $query .= " WHERE itemCategory = $cateId";
                } elseif ($typeId) {
                    $query .= " WHERE itemType = $typeId";
                }
                $result = $db->select($query);
                // Check if the table details are retrieved successfully
                if ($result) {
                    while ($itemresult      = $result->fetch_assoc()) {
                        $itemId             = $itemresult['itemId'];
                        $itemName           = $itemresult['itemName'];
                        $itemCategory       = $itemresult['itemCategory'];
                        $itemType           = $itemresult['itemType'];
                        $itemDescription    = $itemresult['itemDescription'];
                        $itemPrice          = $itemresult['itemPrice'];
                        $itemImg            = $itemresult['itemImg'];
                        ?>

                        <div class="item-solo">
                            <form class="add-to-cart-form" method="post">
                                <div class="menu-img">
                                    <img src="<?php echo $itemImg; ?>" alt="">
                                </div>
                                <div class="menu-text">
                                    <input type="hidden" name="itemId" value="<?php echo $itemId; ?>">
                                    <input type="hidden" name="tableid" value="<?php echo $qrtable; ?>">
                                    <span class="menu-item-title"><?php echo $itemName; ?></span>
                                    <br><span class="menu-item-price"><?php echo $itemPrice; ?>tk</span>
                                    <div class="cart-btn-wrap">
                                    <input type="number" class="qty" value="1" name="itemQuantity"/>
                                    <input type="button" class="buysubmit" name="submit" value="Add To Cart">
                                    </div>




        </form>
                                </div>
                            </form>
                        </div>
                    <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>

<?php include "inc/footer.php";?>

