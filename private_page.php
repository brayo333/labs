<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location:login.php");
    }

    include_once 'DBConnector.php';
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
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
        
        return true;
    }

    function generateResponse($api_key){
        if(saveApiKey()){
            $res = ['success' => 1, 'message' => $api_key];
        }else{
            $res = ['success' => 0, 'message' => 'Something went wrong. Please regenerate the API key'];
        }
        return json_encode($res);
    }

    function fetchUserApiKey(){}

?>

<html>
    <head>
        <title>PrivatePage</title>
        <script src="jquery-3.1.1.min.js"></script>
        <script type ="text/javascript" src="validate.js"></script>
        <script type ="text/javascript" src="apikey.js"></script>
        <link rel="stylesheet" type="text/css" href="validate.css">

        <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootsrap.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootsrap.css.map">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootsrap.min.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootsrap.min.css.map">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootsrap-theme.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootsrap-theme.css.map">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootsrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootsrap-theme.min.css.map">
    </head>
    <body>
        <p>This is a private page</p>
        <p>We want to protect it</p>
        <p align='right'><a href="logout.php">Logout</a></p>
        <hr>
        <h3>Here, we will create an API that will allow Users/Developer to order items from external systems</h3>
        <hr>
        <h4>We now put this feature of allowing users to generate an API key. Click the button to generate the API key</h4>

        <button class="btn btn-primary" id="api-key-btn">Generate API Key</button><br><br>

        <strong>Your API Key:</strong>(Note that if your API Key is already in use by already running applications, 
        generating a new key will stop the application from functioning)<br>
        <textarea cols="100" row="2" id="api_key" name="api_key" readonly><?php echo fetchUserApiKey();?></textarea>

        <h3>Service description:</h3>
        We have a service/API that allows external applications to order food and also pull all 
        order status by using order id. Let's do it.
        
        <hr>
    </body>
</html>