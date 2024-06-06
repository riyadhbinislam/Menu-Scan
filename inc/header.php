<?php include_once "router.php";?>
<?php
  //set headers to NOT cache a page
  header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
  header("Pragma: no-cache"); //HTTP 1.0
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
  header("Cache-Control: max-age=2592000");
?>

<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
	include_once "config/config.php";
	include_once "lib/Database.php";
	include_once "lib/Session.php";
	Session::init();
	include_once "helpers/format.php";
	include_once "classes/product.php";
	include_once "classes/category.php";
	include_once "classes/type.php";
	include_once "classes/brand.php";
	include_once "classes/tag.php";
	include_once "classes/cart.php";
	include_once "classes/user.php";
	include_once "classes/order.php";
	include_once "classes/adminlogin.php";

	$db     	= new Database();
	$fm     	= new Format();
	$pro 		= new Product();
	$ct 		= new category();
	$protyp 	= new Type();
	$brand 		= new Brand();
	$tag 		= new Tag();
	$cart 		= new Cart();
	$ul 		= new User();
	$al 		= new Adminlogin();
	$or 		= new Order();

// Check if the user clicked logout
if (isset($_GET['action']) && $_GET['action'] == "logout") {
    Session::destroy(); // Destroy the session
    header("Location: index.php"); // Redirect to index.php after logout
    exit;
}

?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
		<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
		<meta property="og:title" content="Home | QR SCAN">
		<meta property="og:locale" content="en_US">
		<script src="js/modernizr-2.6.2.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

		<title>Home | QR SCAN </title>

		<?php
			$filename = 'css/style.css';
			$fileModified = substr(md5(filemtime($filename)), 0, 6);
		?>
		<link rel="stylesheet" type="text/css" href="<?php echo $filename;?>?v=<?php echo $fileModified ; ?>">

	</head>
<body>

<!-- Modal HTML For Popup-->
<div id="confirmationModal" class="modal">
  <div class="modal-content">
    <p>Are You sure to Delete?</p>
    <button class="btn btn-primary" id="confirmBtn">Confirm</button>
    <span class="close">&times;</span>
  </div>
</div>


<header class="qr-header">
	<div class="container">
		<div class="flex-wrapper">
			<div class="logo-wrapper">
				<a href="index.php"><img src="/image/logo/theme-logo.png" alt="Logo"/></a>
			</div>
			<div class="top-nav-wrapper">
				<ul>
					<?php
						// Start session to store table ID
						 Session::init();
						// // Check if 'tableid' is set in the session
						$tableid = isset($_SESSION['tableid']) ? $_SESSION['tableid'] : null;
						if (isset($_GET['tableid']) == false) {

					?>


					<li class="nav-item">
					<?php
						$login = Session::get("adminLogin");
						$tableid = isset($_SESSION['tableid']) ? $_SESSION['tableid'] : null;

						if ($login == false && !$tableid) {
							// Show admin login link only if the user is logged out and no table ID session is set
							?>
							<a href="adminlogin.php">Admin</a>
						<?php } else if ($login == true) { ?>
							<span>Hello <?php echo Session::get('adminName'); ?> <span class="color-bar">|</span> <a href="?action=logout">Logout</a></span>
						<?php } ?>

					</li>
					<?php } ?>
					<?php
						// Ensure session is started only if it's not already active
						if (session_status() == PHP_SESSION_NONE) {
							session_start();
						}?>
						<span id="cartButton" class="cart-qtt"><i class="fas fa-shopping-cart"></i><?php
							$getData = $cart->checkCartTable();
							if($getData){
								$itemQuantity = Session::get("itemQuantity");
								echo "<strong style='color: red'>$itemQuantity</strong>";
							}?>
						</span>

						<?php
						// Check if 'tableid' is set in the session
						$tableid = isset($_SESSION['tableid']) ? $_SESSION['tableid'] : null;

						if ($tableid !== null) {
							$chkOrder = $cart->chkOrder($tableid);
							if (!empty($chkOrder)) {  ?>
								<a href="orders.php" id="order_details">
									<span><i class="fas fa-shopping-bag"></i>Orders</span>
								</a>
								<a href="menuitems.php?tableid=<?php echo urlencode($tableid); ?>" id="order_details">
									<span><i class="fas fa-utensils"></i>Menu</span>
								</a>
						<?php }}?>
					</div>
				</ul>
			</div>
		</div>
	</div>
</header>
<style>
	#sideNav {
    position: fixed;
    top: 0;
    right: -350px; /* Start off-screen */
    width: 350px;
    height: 100%;
    background-color: #f8f8f8;
    padding-top: 60px; /* Adjust to match header height */
    transition: right 0.3s ease;
	z-index: 999;
}

</style>


