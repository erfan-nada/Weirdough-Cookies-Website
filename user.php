<?php

class User
{
    private $User_id;
    private $name;
    private $email;
    private $password;
    private $phoneNumber;

    function register() {
        echo "Registering using username {$this->User_id} using password {$this->password}";
    }

    function login() {
        echo "Logging in using username {$this->User_id} using password {$this->password}";
    }

    function logout() {
        echo "Logging out from {$this->User_id}";
    }

    function setname($name) {
        if (strlen($name) >= 2)
            $this->name = $name;
        else
            echo "Invalid name";
    }

    function setuserid($User_id) {
        if (strlen($User_id) >= 3)
            $this->User_id = $User_id;
        else
            echo "Invalid User ID";
    }

    function setemail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
            $this->email = $email;
        else
            echo "Invalid email";
    }

    function setpassword($password) {
        if (strlen($password) >= 6)
            $this->password = $password;
        else
            echo "Invalid password";
    }

    function setphonenumber($phoneNumber) {
        if (preg_match('/^\d{10}$/', $phoneNumber))
            $this->phoneNumber = $phoneNumber;
        else
            echo "Invalid phone number";
    }

    function getname() {
        return $this->name;
    }

    function getuserid() {
        return $this->User_id;
    }

    function getemail() {
        return $this->email;
    }

    function getpassword() {
        return $this->password;
    }

    function getphonenumber() {
        return $this->phoneNumber;
    }
}

?>
