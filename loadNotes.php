<?php
session_start();
include ('connection.php');

//get user_id
$user_id = $_SESSION['user_id'];


//Run query to delete empty notes
$sql = "DELETE FROM notes WHERE user_id='$user_id' AND note=''";
$result = mysqli_query($link, $sql);
if (!$result){
    echo "<div class='alert alert-warning' style='border-radius: 15px'>An error accrued</div>";
    exit;
}

//run query to look for notes corresponding to user_id
$sql = "SELECT * FROM notes WHERE user_id='$user_id' ORDER BY time DESC";

//Show notes or alert message
if($result = mysqli_query($link, $sql)){
    if (mysqli_num_rows($result)){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $note_id = $row['id'];
            $note = $row['note'];
            $time = date("M d, Y - h:i:s A",$row['time']);

            echo "
<div class='d-flex bg-light noteDiv overflow-hidden mb-2 '>
<button class='btn btn-danger  fas fa-trash-alt deleteBTN' name='deleteBTN'  style='font-size: 20px;display:none '></button>
<div  class='m-2 p-2 overflow-hidden' id='$note_id'>
    <div class='text-nowrap font-weight-bold noteText text-decoration-none overflow-hidden' style='text-overflow:ellipsis!important;max-height: 30px'>$note</div>
    <div class='text-muted pl-2' style='font-size: small'>$time</div>
</div>
<button class='btn btn-success col-xs-3 far fa-clock ml-auto remindBTN' name='remindBTN' style='font-size: 20px;display:none;min-width: 40px;padding: 10px'></button>
</div>
";
        }
    }else{
        echo "<div class='alert alert-warning text-center' style='border-radius: 15px'>You have not created any notes yet</div>";
    }
}else{
    echo "<div class='alert alert-warning' style='border-radius: 15px'>An error accrued</div>";
    exit;
}


?>
