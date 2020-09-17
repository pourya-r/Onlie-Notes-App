<?php
//connect to Database
$link = mysqli_connect("localhost", "juststar_onlineNotes", "mysql123", "juststar_onlineNotes");
//Check if connection is successful
if (mysqli_connect_error()){
    die("Error: Unable to Connect");
}

?>