<?php
// include 'lib/Session.php';
include_once 'config/config.php';
include_once 'lib/Database.php';
include_once 'helpers/format.php';

class Userlogin
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function loginUser($data){
    $userEmail = $this->fm->validation($data['userEmail']);
    $userPass = $this->fm->validation($data['userPass']);

    $userEmail = mysqli_real_escape_string($this->db->link, $userEmail);
    $userPass = mysqli_real_escape_string($this->db->link, $userPass);

    if (empty($userEmail) || empty($userPass)) {
        $msg = "Nothing Found";
        return $msg;
        // // Redirect to usersignup.php after 2 seconds
        // echo '<meta http-equiv="refresh" content="2;url=usersignup.php">';
        // exit;
    } else {
        $query = "SELECT * FROM tbl_user WHERE userEmail= '$userEmail' AND userPass= '$userPass'";
        $result = $this->db->select($query);

        if ($result != false) {
            $value = $result->fetch_assoc();
                Session::set("loginUser", true);
                Session::set("userId", $value['userId']);
                Session::set("userEmail", $value['userEmail']);
                Session::set("userFullName", $value['userFullName']);
                Session::set("userPhone", $value['userPhone']);
                echo '<meta http-equiv="refresh" content="0;url=index">';
                exit;
            } else {
                $loginmsg = "UserEmail or Password is incorrect!";
                return $loginmsg;
        }

    }
}

    public function getUserData($id){
        $query = "SELECT * FROM tbl_user WHERE userID= '$id' ";
        $result = $this->db->select($query);
        return $result;
    }

    // public function updateUser($data, $id){
    //     if ($data !== null) {
    //     $userFullName = $this->fm->validation($data['userFullName']);
    //     $userEmail = $this->fm->validation($data['userEmail']);
    //     $userPhone = $this->fm->validation($data['userPhone']);
    //     $userAddress = $this->fm->validation($data['userAddress']);
    //     $userName = $this->fm->validation($data['userName']);

    //     $userFullName = mysqli_real_escape_string($this->db->link, $userFullName);
    //     $userEmail = mysqli_real_escape_string($this->db->link, $userEmail);
    //     $userPhone = mysqli_real_escape_string($this->db->link, $userPhone);
    //     $userAddress = mysqli_real_escape_string($this->db->link, $userAddress);
    //     $userName = mysqli_real_escape_string($this->db->link, $userName);


    //     if ($userFullName == "" ||$userEmail == "" || $userPhone == "" || $userAddress == "" || $userName == ""  ){
    //     $msg = "Fields must not be empty !!<br>";
    //     return $msg;
    //     } else{
    //         $query = "UPDATE tbl_user
    //                   SET
    //                   userFullName = '$userFullName',
    //                   userEmail = '$userEmail',
    //                   userPhone = '$userPhone',
    //                   userAddress = '$userAddress',
    //                   userName = '$userName'
    //                   WHERE userId = '$id'";
    //         $result = $this->db->update($query);

    //         if ($result) {
    //             $msg = "<span class='success'>Profile Updated Successfully</span><br>";
    //             echo '<meta http-equiv="refresh" content="2;url=userprofile.php">';
    //             return $msg;
    //         } else {
    //             $msg = "<span class='error'>Profile Not Updated Successfully</span><br>";
    //             return $msg;
    //         }
    //     }
    // }}

    public function updateUser($data, $id){
        $userFullName   = isset($data['userFullName']) ? $this->fm->validation($data['userFullName']) : '';
        $userEmail      = isset($data['userEmail']) ? $this->fm->validation($data['userEmail']) : '';
        $userPhone      = isset($data['userPhone']) ? $this->fm->validation($data['userPhone']) : '';
        $userAddress    = isset($data['userAddress']) ? $this->fm->validation($data['userAddress']) : '';
        $userName       = isset($data['userName']) ? $this->fm->validation($data['userName']) : '';

        if ($userFullName === null || $userEmail === null || $userPhone === null || $userAddress === null || $userName === null){
            $msg = "Fields must not be empty !!<br>";
            return $msg;
        } else {
            $userFullName   = mysqli_real_escape_string($this->db->link, $userFullName);
            $userEmail      = mysqli_real_escape_string($this->db->link, $userEmail);
            $userPhone      = mysqli_real_escape_string($this->db->link, $userPhone);
            $userAddress    = mysqli_real_escape_string($this->db->link, $userAddress);
            $userName       = mysqli_real_escape_string($this->db->link, $userName);

            $query = "UPDATE tbl_user
                      SET
                      userFullName      = '$userFullName',
                      userEmail         = '$userEmail',
                      userPhone         = '$userPhone',
                      userAddress       = '$userAddress',
                      userName          = '$userName'
                      WHERE userId      = '$id'";
            $result = $this->db->update($query);

            if ($result) {
                $msg = "<span class='success'>Profile Updated Successfully</span><br>";
                echo '<meta http-equiv="refresh" content="2;url=userprofile">';
                return $msg;
            } else {
                $msg = "<span class='error'>Profile Not Updated Successfully</span><br>";
                return $msg;
            }
        }
    }

}


