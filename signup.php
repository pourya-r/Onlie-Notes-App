<?php
//Start session to use data later
session_start();
//Connect to Database
include "connection.php";

//Check user inputs
//Define error messages
$error = array();
$missingUsername='Please enter a username!';
$missingEmail='Please enter your email address!';
$invalidEmail='Please enter a valid email address';
$missingPassword='Please enter a password!';
$invalidPassword= '<p>Should be: More than 6 characters(includes Capital letter and Number)';
$differentPassword='Passwords don\'t match!';
$missingPassword2='Please confirm your password!';

//Get user inputs
//get username
if (empty($_POST["signupName"])){
    $error += ["missingUsername" => $missingUsername];
}else{
    $username = filter_var($_POST["signupName"], FILTER_SANITIZE_STRING);
};
//Get Email
if (empty($_POST["signupEmail"])){
    $error += ["missingEmail" => $missingEmail];
}else{
    $email = filter_var($_POST["signupEmail"], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error += ["invalidEmail" => $invalidEmail];
    };
};
//get password
if (empty($_POST["signupPass"])){
    $error += ["missingPassword" => $missingPassword];
}elseif(!(strlen($_POST["signupPass"]) > 6
    and preg_match('/[A-Z]/' ,$_POST["signupPass"])
    and preg_match('/[0-9]/' ,$_POST["signupPass"]))){
    $error += ["invalidPassword" => $invalidPassword];
}else{
    $password = filter_var($_POST["signupPass"], FILTER_SANITIZE_STRING);
    if (empty($_POST["signupPassRepeat"])) {
        $error += ["missingPassword2" => $missingPassword2];
    }else{
        $password2 = filter_var($_POST["signupPassRepeat"], FILTER_SANITIZE_STRING);
        if ($password !== $password2){
            $error += ["differentPass" => $differentPassword];
        }
    }
}



//If no errors
//Prepare variables for query ( Clean version of inputs)
$username = mysqli_real_escape_string($link, $username);
$email = mysqli_real_escape_string($link, $email);
$password = mysqli_real_escape_string($link, $password);
//hashing email for security (32 char)
//$password = md5($password);

//hashing email for security (64 char)
$password = hash("sha256", $password);

//Check if user already exist
//if username already exist in users table
$sql = "SELECT * FROM `users` WHERE username='$username'";

//run Query
$result = mysqli_query($link, $sql);
if(!$result){
    $error += ["queryError" => "<p class='alert alert-danger'>Error running the query</p>"];

}
if ($results = mysqli_num_rows($result)){
    $error += ["userExist" => "<p class='alert alert-warning'>That Username already registered! Do you want to <a href='#loginModal' data-dismiss='modal' data-toggle='modal'>Log in?</a></p>"];
}
//if email already exist in users table
$sql = "SELECT * FROM users WHERE email='$email'";

//run Query
$result = mysqli_query($link, $sql);
if(!$result){
    $error += ["queryError" => "<p class='alert alert-danger'>Error running the query</p>"];

}
if ($results = mysqli_num_rows($result)){
    $error += ["userExist" => "<p class='alert alert-warning'>That Email address already exist! Do you want to <a href='#loginModal' data-dismiss='modal' data-toggle='modal'>Log in?</a></p>"];
}



//if no error -> Create a unique activation Code
//16 byte * 2 * 2 * 2 (bit ) = 32 char
$activationKey = bin2hex(openssl_random_pseudo_bytes(16));

$sql = "INSERT INTO users (username, email, password, activation) VALUES ('$username', '$email', '$password', '$activationKey')";
if (!$error){
    $result = mysqli_query($link, $sql);
}
if (!$result){
    $error += ["queryError" => "<p class='alert alert-danger'>Something is wrong, Please try later!". mysqli_error($link). "</p>"];
}

//sending Email with activation code to user
$message = "<h4>Registration Confirm</h4> 
            <p>Please click on this link to activate your account: </p>
            <p>http://juststarted.host20.uk/activate.php?email=" . urlencode($email) . "&key=$activationKey" . "</p>
            <p>If you didnt registered on Online Notes App , simply just ignore this mail</p>";
$headers= 'From: p_rajabi@hotmail.com' . "\r\n" .
            'MIME-Version: 1.0'."\r\n".
            'Content-Type: text/html; charset=UTF-8' . "\r\n".
            'X-Priority: 3'."\r\n".
            'X-Mailer: PHP'. phpversion();
if (!$error){
    if (mail($email, 'Confirm your Registration', $message, $headers)){
        $error += ["queryError" => "<p class='alert alert-success'>Thank for your registration, confirmation email has been sent to $email. Please click on activation link inisde your email to activate your account </p>"];
    }else{
        mysqli_close($link);
    }
}


//If there are any error Sending them to ajax at index.js
if ($error){
    //encode array into string object for JS
    echo json_encode($error);
}