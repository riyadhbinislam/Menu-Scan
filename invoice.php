<?php
$pageTitle = "Invoice | F";
?>
<style>
    .invoice-title h2,
    .invoice-title h3 {
        display: inline-block;
    }

    tr,th {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
    }

    .table>tbody>tr>.no-line {
        border-top: none;
    }

    .table>thead>tr>.no-line {
        border-bottom: none;
    }

    .table>tbody>tr>.thick-line {
        border-top: 2px solid;
    }
    .grand-total,
    .sub > span {
    display: grid;
    grid-template-columns: 1fr 1fr;
    }
    #styled-button {
            background-color: #4CAF50; /* Green background */
            border: none; /* Remove borders */
            color: white; /* White text */
            padding: 15px 32px; /* Some padding */
            text-align: center; /* Centered text */
            text-decoration: none; /* Remove underline */
            display: inline-block; /* Get it to line up with other elements */
            font-size: 16px; /* Increase font size */
            margin: 4px 2px; /* Some margin */
            cursor: pointer; /* Pointer/hand icon */
            border-radius: 12px; /* Rounded corners */
            transition: background-color 0.3s ease; /* Smooth background color change */
        }

        #styled-button:hover {
            background-color: #45a049; /* Darker green on hover */
        }
    .payable-amount {
        max-width: 400px;
        width: 100%;
        float: right;
        text-align: right;
        padding: 0;
    }

    .grand-total {
        margin-top: 15px;
        padding-top: 10px;
        border-top: 2px solid #d8d8d8;
    }

    @media print{
        button.btn.btn-primary,
        aside#colorlib-hero,
        div#colorlib-subscribe,
        footer#colorlib-footer,
        nav.colorlib-nav,
        form {
            display: none;
        }
        .invoice-title h2,
        .invoice-title h3 {
            font-size: 18px;
        }
    }
    .dflex {display: flex;justify-content: center;gap: 3.5rem;transition: all 0.3s;}
    .dflex input[type="button"]:hover {opacity: 0.8;}
    .dflex input[type="button"] {border: none;background: transparent;color: var(--heading-color);font-size: 18px;cursor: pointer;}
</style>

<?php
include 'inc/header.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$or = new Order();
$orderGroupId = $_GET["ordergrpid"];
$getOrder = $or->getInvoice($orderGroupId);

?>

<div class="container" style="padding-bottom: 50px;">
    <div id="printableArea">
        <div class="row">
            <div class="col-xs-12">
                <div class="invoice-title">
                    <h2>Invoice</h2>
                    <h3 class="pull-right">Order ID #<?php echo $orderGroupId; ?></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Order summary</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                    <tr >
                                        <th>Order Date</th>
                                        <th>Items</th>
                                        <th>Unit Price</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sum = 0;
                                    if ($getOrder) {
                                        while ($invoiceresult = $getOrder->fetch_assoc()) {
                                            $sum += $invoiceresult['itemPrice'] * $invoiceresult['itemQuantity'];
                                    ?>
                                    <tr>
                                        <td><?php echo $fm->formatDate($invoiceresult['date']); ?></td>
                                        <td><?php echo $invoiceresult['itemName']; ?></td>
                                        <td class="text-center"><?php echo $invoiceresult['itemPrice']; ?></td>
                                        <td class="text-center"><?php echo $invoiceresult['itemQuantity']; ?></td>
                                        <td class="text-right">$<?php echo number_format((float)($invoiceresult['itemPrice'] * $invoiceresult['itemQuantity']), 2); ?></td>
                                    </tr>
                                    <?php } } ?>
                                </tbody>
                            </table>
                            <div class="payable-amount col-md-5">
                                <div class="sub">
                                    <span>
                                        <span class="amount-heading">Sub Total :</span>
                                        <span class="final-amount">$<?php echo number_format((float)$sum, 2, '.', ''); ?></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-center dflex">
            <form action="invoicepdf.php" method="post">
                <input type="hidden" name="ordergrpid" value="<?php echo $orderGroupId; ?>">
                <button style="display:none" type="submit" class="btn btn-primary">Download Invoice as PDF</button>
            </form>
            <input id="styled-button" type="button" onclick="printDiv('printableArea')" value="Print Invoice" />
        </div>
    </div>
</div>

<script>
function printDiv(printableArea) {
    var printContents = document.getElementById(printableArea).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}
</script>
