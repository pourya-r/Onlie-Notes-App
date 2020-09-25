<?php
session_start();
include ('connection.php');

//get id the notes that sent by ajax
$id = $_POST['id'];

//get the Content of the note
$note = $_POST['note'];
//get the time
$time = time();
//run a query to update note
$sql = "UPDATE notes SET note='$note', time='$time' WHERE id='$id'";
$result = mysqli_query($link, $sql);
if (!$result){
    echo 'error';
}
?>