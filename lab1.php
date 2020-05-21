<?php
    include_once 'DBConnector.php';
    include_once 'user.php';
    include_once 'fileUploader.php';
    $con = new DBConnector;

    if(isset($_POST['btn-save'])){
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $city = $_POST['city_name'];
        $uname = $_POST['username'];
        $pass = $_POST['password'];
        $utc_timestamp = $_POST['utc_timestamp'];
        $offset = $_POST['time_zone_offset'];

        $uploader = new FileUploader();

        // if(isset($_FILES['fileToUpload'])){
            // $target_directory = "uploads/";
            // $file_original_name = $target_directory.basename($_FILES['fileToUpload']["name"]);
            // $file_type = strtolower(pathinfo($file_original_name, PATHINFO_EXTENSION));
            // $file_size = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

            // $uploader = new FileUploader($file_original_name, $file_type, $file_size);
            // $file_upload_response = $uploader->uploadFile();
            // if($file_upload_response){
            //     echo "Save operation was successful";
            // }else{
            //     echo "An error occured!";
            // }
        
        $file = $_FILES['fileToUpload'];

        $file_name = $file['name'];
        $file_tmpName = $file['tmp_name'];
        $file_size = $file['size'];

        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));

        $file_finalName = uniqid('', true). '.' .$file_ext;

        $uploader->setOriginalName($file_name);
        $uploader->setFileTmpName($file_tmpName);
        $uploader->setFinalFileName($file_finalName);
        $uploader->setFileSize($file_size);
        $uploader->setFileType($file_ext);
    
        $file_upload_response = $uploader->uploadFile();
        $img_path = "uploads/".basename($file_name);
        
        $user = new User($first_name, $last_name, $city, $uname, $pass, $img_path, $utc_timestamp, $offset);

        if(!$user->validateForm()){
            $user->createFormErrorSessions();
            header("Refresh:0");
            die();
        }

        if(!$user->isUserExist()){
            if($file_upload_response == true){
                $res = $user->save();
                
                if($res){
                    echo "Save operation was successful";
                }else{
                    echo "An error occured when trying to save";
                }
            }
        }else{
            echo "Username already exists";
        }
    }

    if(isset($_GET['hello'])) { 
        $first_name=0;
        $last_name=0;
        $city=0;
        $uname=0;
        $pass=0;

        $user = new User($first_name, $last_name, $city, $uname, $pass, $img_path, $utc_timestamp, $offset);
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
                                    <th>Username</th>
                                    <th>Image Path</th>
                                    <th>Timestamp</th>
                                    <th>Offset</th>
                                </tr>

                                <tr>";		
                                        
                                        while ($row = $res->fetch_assoc()){
                                            $user_id = $row['id'];
                                            $first_name = $row['first_name'];
                                            $last_name = $row['last_name'];
                                            $city = $row['user_city'];
                                            $uname = $row['username'];
                                            $pass = $row['user_pass'];
                                            $img_path = $row['image_path'];
                                            $utc_timestamp = $row['time_stamp'];
                                            $offset = $row['offset'];

                                        echo "<tr>
                                        <td>".$user_id."</td>
                                        <td>".$first_name."</td>
                                        <td>".$last_name."</td>
                                        <td>".$city."</td>
                                        <td>".$uname."</td>
                                        <td>".$img_path."</td>
                                        <td>".$utc_timestamp."</td>
                                        <td>".$offset."</td>
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
        <script type="text/javascript" src="validate.js"></script>
        <link rel="stylesheet" type="text/css" href="validate.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script type="text/javascript" src="timezone.js"></script>
	</head>
	
	<body>
		<form enctype="multipart/form-data" method="post" name="user_details" id="user_details" onsubmit="return validateForm()" action="<?=$_SERVER['PHP_SELF']?>">
			<table align="center">
                <tr>
                    <td>
                        <div id="form-errors">
                            <?php
                                session_start();
                                if(!empty($_SESSION['form_errors'])){
                                    echo " " . $_SESSION['form_errors'];
                                    unset($_SESSION['form_errors']);
                                }
                            ?>
                        </div>
                    </td>
                </tr>

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
                    <td><input type='text' name='username' placeholder='Username'/></td>
                </tr>
                <tr>
                    <td><input type='password' name='password' placeholder='Password'/></td>
                </tr>
                <tr>
                    <td>Profile image:<input type='file' name='fileToUpload' placeholder='fileToUpload'/></td>
                </tr>
                <tr>
                    <td><button type='submit' name='btn-save'>SAVE</button></td>
                </tr>
                <tr>
                    <input type='hidden' name='utc_timestamp' id='utc_timestamp' value=""/>
                    <input type='hidden' name='time_zone_offset' id='time_zone_offset' value=""/>
                </tr>
                <tr>
                    <td><a href='login.php'>Login</a></td>
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