<?php 

?>

<html>
    <head>
    <title>PrivatePage</title>
        <script src="jquery-3.1.1.min.js"></script>
        <script type ="text/javascript" src="placeorder.js"></script>
        

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
        <h3>It is time to communicate with the exposed API, all we need is the API key to be passed in the header</h3>
        <hr>
        <h4>1. Feature 1 - Placing an order</h4>
        <hr>
        <form name="order_form" id="order_form">
            <fieldset>
            <legend>Place Order</legend>
            <input type="text" name="name_of_food" id="name_of_food" required placeholder="Name of food"/><br>
            <input type="number" name="number_of_units" id="number_of_units" required placeholder="Number of units"/><br>
            <input type="number" name="unit_price" id="unit_price" required placeholder="Unit price"/><br><br>
            <input type="hidden" name="status" id="status" required value="Order placed"/><br><br>

            <button class="btn btn-primary" type="submit">Place order >></button>
            </fieldset>
        </form>

        <hr>
        <h4>2. Feature 2 - Checking order status</h4>
        <hr>
        <form name="order_status_form" id="order_status_form" method="post" action="<?=$_SERVER['PHP_SELF']?>">
            <fieldset>
            <legend>Check order status</legend>
            <input type="number" name="order_id" id="order_id" required placeholder="Order ID"/><br><br>
            
            <button class="btn btn-warning" type="submit">Check order status</button>
            </fieldset>
        </form>
    </body>
</html>