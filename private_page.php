<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location:login.php");
    }
?>

<html>
    <head>
        <title>PrivatePage</title>
        <script src="jquery-3.5.1.min.js"></script>
        <script type ="text/javascript" src="apikey.js"></script>
        <script type ="text/javascript" src="validate.js"></script>
        <link rel="stylesheet" type="text/css" href="validate.css">

        <!-- <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script> -->

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

        <!-- <link rel="stylesheet" type="text/css" href="bootstrap/css/bootsrap.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootsrap.css.map">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootsrap.min.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootsrap.min.css.map">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootsrap-theme.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootsrap-theme.css.map">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootsrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootsrap-theme.min.css.map"> -->
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
        <textarea cols="100" row="2" id="api_key" name="api_key" readonly><?php include "apikey.php"; echo fetchUserApiKey();?></textarea>

        <h3>Service description:</h3>
        We have a service/API that allows external applications to order food and also pull all 
        order status by using order id. Let's do it.
        
        <hr>
    </body>
</html>