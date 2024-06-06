<?php
include_once 'config/config.php';
include_once 'lib/Database.php';
include_once 'helpers/format.php';

class Adminlogin
{
    private $db;
    private $fm;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function adminLogin($adminUserName, $adminPass)
    {
        $adminUserName = $this->fm->validation($adminUserName);
        $adminPass = $this->fm->validation($adminPass);

        $adminUserName = mysqli_real_escape_string($this->db->link, $adminUserName);
        $adminPass = mysqli_real_escape_string($this->db->link, $adminPass);

        if (empty($adminUserName) || empty($adminPass)) {
            $loginmsg = "Fields must not be empty";
            return $loginmsg;
        } else {
            $query = "SELECT * FROM tbl_admin WHERE adminUserName = '$adminUserName'";
            $result = $this->db->select($query);

            if ($result) {
                $row = $result->fetch_assoc();
                $hashedPasswordFromDB = $row['adminPass'];
                if (password_verify($adminPass, $hashedPasswordFromDB)) {
                    return $row; // Return user data on successful login
                } else {
                    $loginmsg = "Username or Password is incorrect!";
                    return $loginmsg;
                }
            } else {
                $loginmsg = "User not found";
                return $loginmsg;
            }
        }
    }
}
