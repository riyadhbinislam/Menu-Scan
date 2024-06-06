<?php
include "inc/header.php";
include_once "lib/Session.php";
include_once "classes/adminlogin.php";
Session::init();



// Check if the user is already logged in
// if (Session::get("adminLogin")) {
//     header("Location: admin.php"); // Redirect to admin.php if already logged in
//     exit;
//}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminUserName  = $_POST['adminUserName'];
    $adminPass      = $_POST['adminPass'];

    $al = new Adminlogin();
    $loginData = $al->adminLogin($adminUserName, $adminPass);

    if (is_array($loginData)) {
        Session::set("adminLogin", true);
        Session::set("adminId", $loginData['adminId']);
        Session::set("adminUserName", $loginData['adminUserName']);
        Session::set("adminName", $loginData['adminName']);
        header("Location: admin.php");
        exit;
    } else {
        echo "Wrong Details";
    }
}

?>

<style>
    .login-wrapper .container{
        min-height: 100vh;
    }
</style>
<section class="main-content login-wrapper">
    <div class="container">
        <div class="screen">
            <div class="screen__content">
                <form action="" method="post" class="login">
                    <div class="login__field">
                        <i class="login__icon fas fa-user"></i>
                        <input type="text" class="login__input" placeholder="UserName" name="adminUserName">
                    </div>
                    <div class="login__field">
                        <i class="login__icon fas fa-lock"></i>
                        <input type="password" class="login__input" placeholder="Password" name="adminPass">
                    </div>
                    <input type="submit" value="Log In" class="button login__submit" />
                </form>
                <div class="social-login">
                    <h3>Visit Our Social Media</h3>
                    <div class="social-icons">
                        <a href="#" class="social-login__icon fab fa-instagram"></a>
                        <a href="#" class="social-login__icon fab fa-facebook"></a>
                        <a href="#" class="social-login__icon fab fa-twitter"></a>
                    </div>
                </div>
            </div>
            <div class="screen__background">
                <span class="screen__background__shape screen__background__shape4"></span>
                <span class="screen__background__shape screen__background__shape3"></span>
                <span class="screen__background__shape screen__background__shape2"></span>
                <span class="screen__background__shape screen__background__shape1"></span>
            </div>
        </div>
    </div>
</section>

<?php include 'inc/footer.php';?>
