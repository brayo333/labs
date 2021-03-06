<?php
    include "crud.php";
    include "authenticator.php";
    include_once "DBConnector.php";

    class User implements Crud{
        private $user_id;
        private $first_name;
        private $last_name;
        private $city_name;
        private $username;
        private $password;
        private $image;
        private $utc_timestamp;
        private $offset;

        function __construct($first_name, $last_name, $city_name, $username, $password, $image, $utc_timestamp, $offset){
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->city_name = $city_name;
            $this->username = $username;
            $this->password = $password;
            $this->image = $image;
            $this->utc_timestamp = $utc_timestamp;
            $this->offset = $offset;
        }

        public static function create(){
            $instance = new self($first_name, $last_name, $city_name, $username, $password, $image, $utc_timestamp, $offset);
            return $instance;
        }

        public function setUsername($username){
            $this->username = $username;
        }

        public function getUsername(){
            return $this->username;
        }

        public function setPassword($password){
            $this->password = $password;
        }

        public function getPassword(){
            return $this->password;
        }

        public function setUserId ($user_id){
            $this->user_id = $user_id;
        }

        public function getUserId (){
            return $this->user_id;
        }

        public function isUserExist(){
            $username = $this->username;
            $con = new DBConnector;
            $found = false;
            $res = mysqli_query($con->conn, "SELECT * FROM user") or die("Error: " .mysqli_error());

            while($row = mysqli_fetch_array($res)){
                if($row['username'] == $username){
                    $found = true;
                }
            }

            $con->closeDatabase();
            return $found;
        }

        public function hashPassword(){
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }

        public function isPasswordCorrect(){
            $con = new DBConnector;
            $found = false;
            $res = mysqli_query($con->conn, "SELECT * FROM user") or die("Error: " .mysqli_error());

            while($row = mysqli_fetch_array($res)){
                if(password_verify($this->getPassword(), $row['user_pass']) && $this->getUsername() == $row['username']){
                    $found = true;
                }
            }

            $con->closeDatabase();
            return $found;
        }

        public function login(){
            if($this->isPasswordCorrect()){
                header("Location:private_page.php");
            }
        }

        public function createUserSession(){
            session_start();
            $_SESSION['username'] = $this->getUsername();
        }

        public function logout(){
            session_start();
            unset($_SESSION['username']);
            session_destroy();
            header("Location:lab1.php");
        }

        public function save(){
            $fn = $this->first_name;
            $ln = $this->last_name;
            $city = $this->city_name;
            $uname = $this->username;
            $this->hashpassword();
            $pass = $this->password;
            $image = $this->image;
            $utc_timestamp = $this->utc_timestamp;
            $offset = $this->offset;

            $con = new DBConnector;

            $res = mysqli_query($con->conn, "INSERT INTO user(first_name, last_name, user_city, username, user_pass, image_path, time_stamp, offset) 
                VALUES('$fn', '$ln', '$city', '$uname', '$pass', '$image', '$utc_timestamp', '$offset')") or die("Error: " .mysql_error());
            return $res;
        }

        public function readAll(){
            $con = new DBConnector;

            $res = mysqli_query($con->conn, "SELECT * FROM user") or die("Error: " .mysql_error());
            return $res;
        }

        public function readUnique(){
            return null;
        }

        public function search(){
            return null;
        }

        public function update(){
            return null;
        }

        public function removeOne(){
            return null;
        }

        public function removeAll(){
            return null;
        }

        public function validateForm(){
            $fn = $this->first_name;
            $ln = $this->last_name;
            $city = $this->city_name;

            if($fn =="" || $ln=="" || $city==""){
                return false;
            }
            return true;
        }

        public function createFormErrorSessions(){
            session_start();
            $_SESSION['form_errors'] = "All fields are required";
        }
    }
?>