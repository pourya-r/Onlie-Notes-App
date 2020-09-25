<?php

//get session and connect to database
session_start();
include "connection.php";

//get user_id
$user_id = $_SESSION['user_id'];

//Define errors
$errors = array();
$missingPassword = "please Enter your password";
$wrongPassword = "your password is not correct";
$missingNewPassword = "please Enter your new password";
$missingRepeatPassword = "please repeat new password";
$invalidPassword= 'Should be: More than 6 characters includes Capital letter and Number';
$passwordMatch = "your password Don't match";
$success = "<div class='alert alert-success' style='border: #FC4D1C 1px solid;border-radius: 15px'><p>Password has been changed successfully!</p><p class='font-weight-bold'>You have to login again</p></div>";
$queryError = "<div class='alert alert-danger p-1 m-auto' style='border: #FC4D1C solid 1px;border-radius: 15px;box-shadow:0 0 4px 0 black;max-width: 400px' >There is problem with retrieving data from Database</div>";


//Get old password from ajax and check if it correct
if (empty($_POST['password'])){
    $errors += ["missingPassword" => $missingPassword];
}else{
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
}

//Get new password sent by ajax call
if (empty($_POST["newPassword"])){
    $errors += ["missingNewPassword" => $missingPassword];
}elseif(!(strlen($_POST["newPassword"]) > 6
    and preg_match('/[A-Z]/' ,$_POST["newPassword"])
    and preg_match('/[0-9]/' ,$_POST["newPassword"]))){
    $errors += ["invalidPassword" => $invalidPassword];

}else{
    $newPass1 = filter_var($_POST["newPassword"], FILTER_SANITIZE_STRING);
    if (empty($_POST["repeatPassword"])) {
        $errors += ["missingPassword2" => $missingRepeatPassword];

    }else{
        $newPass2 = filter_var($_POST["repeatPassword"], FILTER_SANITIZE_STRING);
        if ($newPass1 !== $newPass2){
            $errors += ["differentPass" => $passwordMatch];

        }else{
            $newPassword = $newPass1;
        }
    }
}


//if there was no error
if (!$errors){
    //prepare passwords for query
    //Clear version  and convert to hashed password (64 byte)
    $password = mysqli_real_escape_string($link, $password);
    $password = hash('sha256', $password);

    $newPassword = mysqli_real_escape_string($link, $newPass1);
    $newPassword = hash('sha256', $newPassword);


    //Check if old password is correct
    $sql = "SELECT * FROM users WHERE user_id='$user_id' AND password='$password'";
    $result = mysqli_query($link, $sql);
    if (!$result){
        $errors += ["message" => $queryError];
    }else{
        if (mysqli_num_rows($result) === 1){

            //run a query to update new password
            $sql = "UPDATE users SET password='$newPassword' WHERE user_id=$user_id";
            $result = mysqli_query($link, $sql);
            if (!$result) {
                $errors += ["message" => $queryError];
            }else{
                $errors += ["success" => $success];

            }

        }else{
            $errors += ["wrongPassword" => $wrongPassword];
        }
    }
}

if ($errors){
    echo json_encode($errors);
}

?>