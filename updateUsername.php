<?php

//get session and connect to database
session_start();
include "connection.php";

//get user_id
$user_id = $_SESSION['user_id'];

//Get new username sent by ajax call
if (empty($_POST["username"])){
    echo "<div class='container alert alert-danger' style='border: #FC4D1C solid 1px; box-shadow:  0 0 5px 0 black; border-radius: 15px; max-width: 500px;margin: auto'>Please enter your new username</div>";
}else {
    $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
}
//Check if username already exist
$sql = "SELECT * FROM `users` WHERE username='$username'";

//run Query
$result = mysqli_query($link, $sql);
if(!$result){
    echo "<div class='container alert alert-danger' style='border: #FC4D1C solid 1px; box-shadow:  0 0 5px 0 black; border-radius: 15px; max-width: 500px;margin: auto'>ERROR: running query please try again later</div>";

}
if ($results = mysqli_num_rows($result)){
    echo "<div class='container alert alert-danger' style='border: #FC4D1C solid 1px; box-shadow:  0 0 5px 0 black; border-radius: 15px; max-width: 500px;margin: auto'>this username already exist please choose another one</div>";
    exit;
}

//Run query to update username
$sql = "UPDATE users SET username='$username' WHERE user_id = '$user_id'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo "<div class='container alert alert-danger' style='border: #FC4D1C solid 1px; box-shadow:  0 0 5px 0 black; border-radius: 15px; max-width: 500px;margin: auto'>There is problem with saving your new username, please try again later</div>";
}
?>