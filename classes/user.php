

<?php
class User
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function userAdd($data) {
        $userFullName = $this->fm->validation($data['userFullName']);
        $userFirstName = $this->fm->validation($data['userFirstName']);
        $userLastName = $this->fm->validation($data['userLastName']);
        $userCompanyName = $this->fm->validation($data['userCompanyName']);
        $userCountry = $this->fm->validation($data['userCountry']);
        $userAddress = $this->fm->validation($data['userAddress']);
        $userCity = $this->fm->validation($data['userCity']);
        $userState = $this->fm->validation($data['userState']);
        $userZipCode = $this->fm->validation($data['userZipCode']);
        $userPhoneNumber = $this->fm->validation($data['userPhoneNumber']);
        $userEmail = $this->fm->validation($data['userEmail']);
        $UserPassword = $this->fm->validation($data['UserPassword']);

        $userFullName = mysqli_real_escape_string($this->db->link, $userFullName);
        $userFirstName = mysqli_real_escape_string($this->db->link, $userFirstName);
        $userLastName = mysqli_real_escape_string($this->db->link, $userLastName);
        $userCompanyName = mysqli_real_escape_string($this->db->link, $userCompanyName);
        $userCountry = mysqli_real_escape_string($this->db->link, $userCountry);
        $userAddress = mysqli_real_escape_string($this->db->link, $userAddress);
        $userCity = mysqli_real_escape_string($this->db->link, $userCity);
        $userState = mysqli_real_escape_string($this->db->link, $userState);
        $userZipCode = mysqli_real_escape_string($this->db->link, $userZipCode);
        $userPhoneNumber = mysqli_real_escape_string($this->db->link, $userPhoneNumber);
        $userEmail = mysqli_real_escape_string($this->db->link, $userEmail);
        $UserPassword = mysqli_real_escape_string($this->db->link, $UserPassword);

        if ($userFullName == "" ||$userFirstName == "" ||$userLastName == "" ||$userCompanyName == "" ||$userCountry == "" ||$userAddress == "" ||$userCity == "" ||$userState == "" ||$userZipCode == "" ||$userPhoneNumber == "" ||$userEmail == "" || $UserPassword == "" ){
        $msg = "Fields must not be empty !!<br>";
        return $msg;
        } else{
            $mailquery = "SELECT * FROM  tbl_user WHERE userEmail='$userEmail' LIMIT 1";
            $mailchk = $this->db->select( $mailquery );
            if ($mailchk != false) {
                $msg = "User already exists !!" ;
                return $msg ;
        }else{
            $query = "INSERT INTO tbl_user(userFullName, userFirstName, userLastName, userCompanyName, userCountry, userAddress, userCity,  userState, userZipCode, userPhoneNumber, userEmail, UserPassword) VALUES ('$userFullName', '$userFirstName', '$userLastName', '$userCompanyName', '$userCountry', '$userAddress', '$userCity', '$userState', '$userZipCode', '$userPhoneNumber', '$userEmail', '$UserPassword')";
            $result = $this->db->insert($query);

            if ($result) {
                $msg = "<span class='success'>SignUp Successfully</span><br>";
                echo '<meta http-equiv="refresh" content="0.00;url=login">';
                return $msg;
            } else {
                $msg = "<span class='error'>Not SignUp</span><br>";
                return $msg;
            }
        }
    }
}

    public function userList(){
        $query = "SELECT * FROM tbl_user ORDER BY  userId ASC";
        $result = $this->db->select($query);
        return $result;
    }

    // Catedit Function
    public function getUserById($userId){
        $userId = $this->fm->validation($userId);
        $userId = mysqli_real_escape_string($this->db->link, $userId);

        $query = "SELECT * FROM tbl_user WHERE  userId ='$userId'";
        $result = $this->db->select($query);
        return $result;
    }

    public function updateUser($postData){
        // Assuming $this->fm->validation() sanitizes the input data
        $userFullName = $this->fm->validation($_POST['userFullName']);
        $userFirstName = $this->fm->validation($_POST['userFirstName']);
        $userLastName = $this->fm->validation($_POST['userLastName']);
        $userCompanyName = $this->fm->validation($_POST['userCompanyName']);
        $userCountry = $this->fm->validation($_POST['userCountry']);
        $userAddress = $this->fm->validation($_POST['userAddress']);
        $userCity = $this->fm->validation($_POST['userCity']);
        $userState = $this->fm->validation($_POST['userState']);
        $userZipCode = $this->fm->validation($_POST['userZipCode']);
        $userPhoneNumber = $this->fm->validation($_POST['userPhoneNumber']);
        $userEmail = $this->fm->validation($_POST['userEmail']);

        // Assuming $this->db->link is your database connection
        $userFullName = mysqli_real_escape_string($this->db->link, $userFullName);
        $userFirstName = mysqli_real_escape_string($this->db->link, $userFirstName);
        $userLastName = mysqli_real_escape_string($this->db->link, $userLastName);
        $userCompanyName = mysqli_real_escape_string($this->db->link, $userCompanyName);
        $userCountry = mysqli_real_escape_string($this->db->link, $userCountry);
        $userAddress = mysqli_real_escape_string($this->db->link, $userAddress);
        $userCity = mysqli_real_escape_string($this->db->link, $userCity);
        $userState = mysqli_real_escape_string($this->db->link, $userState);
        $userZipCode = mysqli_real_escape_string($this->db->link, $userZipCode);
        $userPhoneNumber = mysqli_real_escape_string($this->db->link, $userPhoneNumber);
        $userEmail = mysqli_real_escape_string($this->db->link, $userEmail);

        // Checking if any field is empty
        if ($userFullName == "" || $userFirstName == "" || $userLastName == "" || $userCompanyName == "" || $userCountry == "" || $userAddress == "" || $userCity == "" || $userState == "" || $userZipCode == "" || $userPhoneNumber == "" || $userEmail == "") {
            $msg = "Fields must not be empty !!<br>";
            return $msg;
        }else {
                $query =
                    "UPDATE tbl_user SET
                        userFullName        = '$userFullName',
                        userFirstName       = '$userFirstName',
                        userLastName        = '$userLastName',
                        userCompanyName     = '$userCompanyName',
                        userCountry         = '$userCountry',
                        userAddress         = '$userAddress',
                        userCity            = '$userCity',
                        userState           = '$userState',
                        userZipCode         = '$userZipCode',
                        userPhoneNumber     = '$userPhoneNumber',
                        userEmail           = '$userEmail'
                    WHERE userId            = '".$_POST['userId']."' ";

                $result = $this->db->update($query);
                if (!$result) {
                    die("Error: " . mysqli_error($this->db->link));
                }
                echo '<meta http-equiv="refresh" content="0.00;url=checkout">';
                echo 'Data Updated Successfully';
                exit;

            }
        }


    public function DeleteUser($userId){
        //validation
        $userId = $this->fm->validation($userId);
        $userId = mysqli_real_escape_string($this->db->link, $userId);
        // Prepare and execute the delete query
        $query = "DELETE FROM tbl_user WHERE  userId = '$userId'";
        $result = $this->db->delete($query);
        // Return the result of the deletion
        return $result;
    }


    public function loginUser($data){
        $userEmail = $this->fm->validation($data['userEmail']);
        $UserPassword = $this->fm->validation($data['UserPassword']);

        $userEmail = mysqli_real_escape_string($this->db->link, $userEmail);
        $UserPassword = mysqli_real_escape_string($this->db->link, $UserPassword);

        if (empty($userEmail) || empty($UserPassword)) {
            $msg = "Fild Must Not be Empty";
            return $msg;
            // // Redirect to usersignup.php after 2 seconds
            // echo '<meta http-equiv="refresh" content="2;url=usersignup.php">';
            // exit;
        } else {
            $query = "SELECT * FROM tbl_user WHERE userEmail= '$userEmail' AND UserPassword= '$UserPassword'";
            $result = $this->db->select($query);
            if (!$result) {
                // Handle query errors
                echo "Query error: " . mysqli_error($this->db->link);
            } else {
                if ($result->num_rows > 0) {
                    $value = $result->fetch_assoc();
                    Session::set("loginUser", true);
                    Session::set("userId", $value['userId']);
                    Session::set("userEmail", $value['userEmail']);
                    Session::set("userFullName", $value['userFullName']);
                    Session::set("userPhoneNumber", $value['userPhoneNumber']);
                    echo '<meta http-equiv="refresh" content="0;url=home">';
                    exit;
                } else {
                    $loginmsg = "Email or Password is Incorrect!";
                    return $loginmsg;
                }
            }

        }
    }
}