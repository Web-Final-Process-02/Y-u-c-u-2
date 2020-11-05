<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register Page!</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<?php
require_once("connectdb.php");
session_start();
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
 
function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
 
    return $random_string;
} 
if (isset($_POST["SUBMIT"])) {
    $classname = $_POST["classname"];
    $description = $_POST["description"];
    $room = $_POST["room"];
    $instructor = $_SESSION['fullname'];
    $image = $_FILES['fileToUpload']['name'];
    $target = "images/".basename($image);

    $own = $_SESSION['username'];
    $code = generate_string($permitted_chars,10);
    //Kiểm tra điều kiện bắt buộc đối với các field không được bỏ trống
    if ($classname == "" || $description == "" || $instructor == "" || $code == "" || $image == "" || $room == "") {
        echo "bạn vui lòng nhập đầy đủ thông tin";
    }else{
        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target)) {
            $msg = "Image uploaded successfully";
        }else{
            $msg = "Failed to upload image";
        }
        $sql = "insert into class(
										code,
										classname,
										description,
										room,
										instructor,
										own,
										image_class
									) VALUES (
										'$code',
										'$classname',
										'$description',
										'$room',
										'$instructor',
										'$own',
										'$image'
									)";
        // thực thi câu $sql với biến conn lấy từ file connection.php
        mysqli_query($conn,$sql);

        echo "<div class='container mt-3'>
            <table class='table table-bordered '>
            <tr>
                    <td colspan='4'><h4><center>Create New Class</center></h4></td>
                </tr>
            </div>";
    }
}

?>
<body>
<center>
    <div class="jumbotron text-center p-3 my-3 bg-dark text-white">
        <h2>Create New Class</h2>
</center>
<form action="" method="post" enctype= "multipart/form-data">
    <div class="form-group">
        <label for="classname" style="margin-left: 25px;">Class Name:</label>
        <input type="text" class="form-control" id="classname" placeholder="Enter Class Name" name="classname" style="width: 75%; margin-left: 25px;" required>
    </div>
    <div class="form-group">
        <label for="description" style="margin-left: 25px;">Description:</label>
        <input type="text" class="form-control" id="description" placeholder="Enter Description" name="description" style="width: 75%; margin-left: 25px;" required>
    </div>
    <div class="form-group">
        <label for="room" style="margin-left: 25px;">Room:</label>
        <input type="text" class="form-control" id="room" placeholder="Enter Room" name="room" style="width: 75%; margin-left: 25px;" required>
    </div>
    <div class="form-group">
        <label for="fileToUpload" style="margin-left: 25px;">Image:</label>
        <input type="file" id="fileToUpload" name="fileToUpload">
    </div>
    <center>
        <input type="submit" name="SUBMIT" value="Submit" class="btn btn-primary">
        <button type="reset" class="btn btn-primary">Reset</button>
        <td colspan="2"><center><p><a href='Login.php'>Turn Back!</a></p></center></td>
    </center>
</form>

</div>

</body>
</html>