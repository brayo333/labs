<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location:login.php");
    }
?>

<html>
    <head>
        <title>privatePage</title>
        <script type ="text/javascript" src="validate.js"></script>
        <link rel="stylsheet" type="text/css" href="validate.css">
    </head>
    <body>
        <p>This is a private page</p>
        <p>We want to protect it</p>
        <p><a href="logout.php">Logout</p>
    </body>
</html>