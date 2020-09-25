<?php
session_start();
include ('connection.php');

//get user_id
$user_id = $_SESSION['user_id'];

//get the current time
$time = time();

//run a query to create new notes
$sql = "INSERT INTO notes (user_id, note, time ) VALUES ('$user_id', '' ,'$time')";
$result = mysqli_query($link, $sql);
if(!$result){
    echo 'error';
}else{
    // mysqli_insert_id will return the auto generated is used in the last query
    echo mysqli_insert_id($link);
}

?>