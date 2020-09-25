<?php
session_start();
include ('connection.php');

//get the ID of the note (and userid)
$id= $_POST['id'];
$user_id = $_SESSION['user_id'];
//run a query to Delete note From notes table
$sql = "DELETE FROM notes WHERE id='$id' AND user_id='$user_id'";
$result = mysqli_query($link, $sql);
if (!$result){
    echo "error";
}

?>