<?php
    include_once 'DBConnector.php';
    include_once 'user.php';
    $con = new DBConnector;

    if(isset($_POST['btn-save'])){
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $city = $_POST['city_name'];

        $user = new User($first_name, $last_name, $city);
        $res = $user->save();

        if($res){
            echo "Save operation was successful";
        }else{
            echo "An error occured!";
        }
    }

    if(isset($_GET['hello'])) { 
        $first_name=0;
        $last_name=0;
        $city=0;

        $user = new User($first_name, $last_name, $city);
        $res = $user->readAll();
        
        echo "<!DOCTYPE html>
                    <html>
                        <head>
                            <title>ReadAll</title>
                        </head>
                        <body>
                            <div>
                            <table align ='left'; border='1'>
        
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>City</th>
                                </tr>

                                <tr>";		
                                        
                                        while ($row = $res->fetch_assoc()){
                                            $user_id = $row['id'];
                                            $first_name = $row['first_name'];
                                            $last_name = $row['last_name'];
                                            $city = $row['user_city'];

                                        echo "<tr>
                                        <td>".$user_id."</td>
                                        <td>".$first_name."</td>
                                        <td>".$last_name."</td>
                                        <td>".$city."</td>
                                        </tr>";
                                        }
                                        
                        
                                echo "</tr>
                            </table>
                            </div>
                            <div>
                                <a href='lab1.php'>Back</a>
                            </div>
                        </body>
                    </html>";
    }

    
?>

<html>
	<head>
		<title>Lab 1</title>
	</head>
	
	<body>
		<form method="post">
			<table>
                <tr>
                    <td><input type='text' name='first_name' required placeholder='First Name'/></td>
                </tr>
                <tr>
                    <td><input type='text' name='last_name' placeholder='Last Name'/></td>
                </tr>
                <tr>
                    <td><input type='text' name='city_name' placeholder='City'/></td>
                </tr>
                <tr>
                    <td><button type='submit' name='btn-save'>SAVE</button></td>
                </tr>
                <tr>
                    <td><a href='lab1.php?hello=true'>Run readAll function</a></td>
                </tr>
            </table>
            <!-- <div>
                <a href='lab1.php?hello=true'>Run readAll function</a>
            </div> -->
		</form>
	</body>

</html>