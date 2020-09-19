<?php

//start session
session_start();

//Connect to database
include ('connection.php');

//Define error messages
$errors = array();

$missingEmail = "Please enter your email address";
$invalidEmail='Please enter a valid email address';
$emailNotFound = "<div class='alert alert-danger' style='border: #FC4D1C 1px solid;border-radius: 15px'><p>We cant find your email in our Database!</div>";

//Check input
if(empty($_POST["forgotPassEmail"])){
    $errors += ["missingEmail" => $missingEmail];
}else{
    $email = filter_var($_POST["forgotPassEmail"], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors += ["invalidEmail" => $invalidEmail];
    }
}

//if there wasnt any error --> process inputs
if (!$errors){
    //prepare variable for query
    $email = mysqli_real_escape_string($link, $email);

    //run query to check if user ixist in user table
    $sql = "SELECT * FROM users WHERE email = '$email'";

    $result = mysqli_query($link, $sql);
    if (!$result){
        $errors += ["message" => "<div class='alert alert-danger'>there was an error on running query 1</div>"];
    }
    //Check if email exist in database
    $count = mysqli_num_rows($result);
    //if not return error message
    if ($count != 1){
        $errors += ["message" => $emailNotFound];
    }
    //if email exist in database -->
    //Get user ID
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $user_id = $row['user_id'];

    //Create unique activation code
    $key= bin2hex(openssl_random_pseudo_bytes(16));

    //putting user details on table
    $time = time();
    $status = "pending";

    $sql = "INSERT INTO forgotpassword (`user_id`, `rkey`, `time`, `status`) VALUES ('$user_id', '$key', '$time', '$status')";

    $result = mysqli_query($link, $sql);
    if (!$result){
        $errors += ["message" => "<div class='alert alert-danger'>there was an error on running query 2</div>"];
    }
    //Sending email to user
    $message = "<h3>Reset Password</h3> 
            <p>Please click on this link below to Reset your password: </p>
            <p>http://juststarted.host20.uk/resetpassword.php?user_id=$user_id&key=$key</p>
            <p>If you didnt ask for Resetting password,  just ignore this mail</p>";
    $headers= 'From: p_rajabi@hotmail.com' . "\r\n" .
        'MIME-Version: 1.0'."\r\n".
        'Content-Type: text/html; charset=UTF-8' . "\r\n".
        'X-Priority: 3'."\r\n".
        'X-Mailer: PHP'. phpversion();
    if (!$errors){
        if (mail($email, 'Reset Password', $message, $headers)){
            $errors += ["message" => "<p class='alert alert-success' style='border: #FC4D1C solid 1px;border-radius: 15px'> Reset Password link has been sent to $email. Please click on link inisde your email to Reset your password</p>"];
        }
    }
}




if($errors){
    echo json_encode($errors);
}
?>