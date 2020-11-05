<?php
$conn = mysqli_connect('localhost', 'root', '', 'classroomdb');

if(mysqli_connect_errno()){
    die('can not connect database: ' . $mysqli_connect_errno($conn));
}
?>