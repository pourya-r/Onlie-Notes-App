<?php

//get session and connect to database
session_start();
include "connection.php";

//define errors
$errors = array();

$missingEmail = "Please enter your email address";
$invalidEmail = "please enter valid email address";
$alreadyExist = "this Email Address already exist in database";
$queryError = "<div class='alert alert-danger p-1 m-auto' style='border: #FC4D1C solid 1px;border-radius: 15px;box-shadow:0 0 4px 0 black;max-width: 400px' >There is problem with retrieving data from Database, Please try again later</div>";


//get user_id
$user_id = $_SESSION['user_id'];

//Get new email from ajaX
//Check new email for errors
if (empty($_POST['email'])){
    $errors +=["missingEmail" => $missingEmail];
}else{
    $newEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)){
        $errors += ["invalidEmail" => $invalidEmail];
    }
}
//Check if email already exist
    //prepare new email (clean version)
$newEmail = mysqli_real_escape_string($link, $newEmail);

    //run a query
$sql = "SELECT * FROM users WHERE email='$newEmail'";
$result = mysqli_query($link, $sql);
if (!$result){
    $errors += ["message" => $queryError];
}else{
    $count = mysqli_num_rows($result);
    if ($count !== 0){
        $errors += ["alreadyExist" => $alreadyExist];

    }
}

//if no errors
if (!$errors){
    //Get the current email address
    $sql = "SELECT * FROM users WHERE user_id='$user_id'";
    $result = mysqli_query($link, $sql);
    if (!$result){
        $errors += ["message" => $queryError];
    }else {
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $currentEmail = $row['email'];
        } else {
            $errors += ["message" => $queryError];
        }
    }

}

//Create activation code and insert it to users table
$activationKey = bin2hex(openssl_random_pseudo_bytes(16));
$sql = "UPDATE users SET activation2='$activationKey' WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);
if (!$result){
    $errors += ["message" => $queryError];
}

//send email with link of activation code to new email address
$message = "<h4>Activate new Email</h4> 
            <p>Please click on this link to activate your New Email address: </p>
            <p>http://juststarted.host20.uk/activatenewemail.php?newEmail=" . urlencode($newEmail) ."&email=". urlencode($currentEmail) . "&key=$activationKey" . "</p>
            <p>If you didnt ask to change email address from Online Notes , simply just ignore this mail</p>";
$headers= 'From: p_rajabi@hotmail.com' . "\r\n" .
    'MIME-Version: 1.0'."\r\n".
    'Content-Type: text/html; charset=UTF-8' . "\r\n".
    'X-Priority: 3'."\r\n".
    'X-Mailer: PHP'. phpversion();
if (!$errors){
    if (mail($newEmail, 'Confirm new email address', $message, $headers)){
        $errors += ["message" => "<p class='alert alert-success'>New email registered successfully, confirmation email has been sent to $newEmail. Please click on activation link inside your email to confirm new email address </p>"];
    }else{
        mysqli_close($link);
    }
}


//If there are any error Sending them to ajax at index.js
if ($errors){
    //encode array into string object for JS
    echo json_encode($errors);
}
?>