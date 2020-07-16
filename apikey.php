<?php
    include 'DBConnector.php';

    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        header('HTTP/1.0 403 Forbidden');
        echo 'You are forbidden';
    }else{
        $api_key = null;
        $api_key = generateApiKey(64);
        header('Content-type: application/json');

        echo generateResponse($api_key);
    }

    function generateApiKey($str_length){
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $bytes = openssl_random_pseudo_bytes(3*$str_length/4+1);

        $repl = unpack('C2', $bytes);

        $first = $chars[$repl[1]%62];
        $second = $chars[$repl[2]%62];
        return strtr(substr(base64_encode($bytes), 0, $str_length), '+/', "$first$second");
    }

    function saveApiKey(){
        $con = new DBConnector();
        $user = $_SESSION['username'];
        $saved = false;

        $res = mysqli_query($con->conn, "SELECT * FROM user WHERE username= '".$user."'") or die("Error: " .mysql_error());
        // if(mysqli_num_rows($res)>0){
        //     $row = mysqli_fetch_array($res);
        //     $userid = $row['id'];

        //     $api_query = mysqli_query($con->conn, "SELECT api_key FROM api_keys WHERE userid = '".$userid."'") or die("Error: " .mysql_error());
            
        //     if($api_query == null){
        //         mysqli_query($con->conn, "INSERT INTO api_keys(userid, api_key) VALUES('$userid', '$api_key')") or die("Error: " .mysql_error());
        //         $this->saved = true;
        //     }
        // }
        // while($row = mysqli_fetch_array($res)){
        //     if($row['username'] == $user){
        //         $userid = $row['id'];
        //     }
        // }

        // $api_query = mysqli_query($con->conn, "SELECT api_key FROM api_keys WHERE userid = '".$userid."'") or die("Error: " .mysql_error());
        // if($api_query == null){
        //     mysqli_query($con->conn, "INSERT INTO api_keys(userid, api_key) VALUES('$userid', '$api_key')") or die("Error: " .mysql_error());
        //     $this->saved = true;
        // }
        
        // return $saved;
        
        $user_array = $res->fetch_assoc();
        $uid = $user_array['id'];
        
        $result = mysqli_query($con->conn, "INSERT INTO api_keys(userid, api_key) VALUES('$uid','$api_key')") or die(mysqli_error($con->conn));

        if ($result === true) {
            return true;
        }
        return false;
        
    }

    function generateResponse($api_key){
        if(saveApiKey()){
            $res = ['success' => 1, 'message' => $api_key];
        }else{
            $res = ['success' => 0, 'message' => 'Something went wrong. Please regenerate the API key'];
        }
        return json_encode($res);
    }

    function fetchUserApiKey(){
        $con = new DBConnector;
        $user = $_SESSION['username'];

        $res = mysqli_query($con->conn, "SELECT id FROM user WHERE username = '".$user."'") or die("Error: " .mysql_error());
        if(mysqli_num_rows($res)>0){
            $row = mysqli_fetch_array($res);
            $userid = $row['id'];

            $api_query = mysqli_query($con->conn, "SELECT api_key FROM api_keys WHERE userid = '".$userid."'") or die("Error: " .mysql_error());
            if(mysqli_num_rows($api_query)>0){
                $api_row = mysqli_fetch_array($api_query);
                $api = $api_row['api_key'];
                return $api;
            }
        }else {
            // return "User does not have an api key saved";
        }
    }

?>
