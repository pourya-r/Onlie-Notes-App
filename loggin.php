<?php
//Start Session to use data later
session_start();
//Connect to Database
include ("connection.php");

//Define errors
$errors = array();

$missingEmail = "Please enter your email address";
$missingPass = "Please enter your password";
$wrongUsernameOrPass = "<div class='alert alert-danger' style='border: #FC4D1C 1px solid;border-radius: 15px'><p>Wrong Username or Password!</p><p class='text-muted'>Note: make sure that you activated your account already, via link inside your email</p></div>";
$rememberMeError = "<div class='alert alert-danger' style='border: #FC4D1C 1px solid;border-radius: 15px'><p>There was an error to remember you next time!</div>";

//User Inputs
//Get user Email
if (empty($_POST["loginEmail"])){
    $errors += ["missingEmail" => $missingEmail];
}else{
    $email = filter_var($_POST["loginEmail"], FILTER_SANITIZE_EMAIL);
}

//get user password
if (empty($_POST["loginPass"])){
    $errors += ["missingPass" => $missingPass];
}else{
    $pass = filter_var($_POST["loginPass"], FILTER_SANITIZE_STRING);
}

if (!$errors){
    //Prepare variable for query
    $email = mysqli_real_escape_string($link, $email);
    $pass = mysqli_real_escape_string($link, $pass);
    //64 char encrypted
    $pass = hash("sha256", $pass);

    //Query to search for combination of email and password
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$pass' AND activation='activated'";
    //run query
    $result = mysqli_query($link, $sql);
    //if error on running query
    if(!$result){
        $errors += ["error" =>"<div class='alert alert-danger' style='border: #FC4D1C 1px solid;border-radius: 15px'>Error running the query , Please try again later!</div>"];
    }
    $cont = mysqli_num_rows($result);
    //If there was only 1 user with same details
    if ($cont !== 1){
        $errors += ["error" => $wrongUsernameOrPass];
    }else{
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $_SESSION['user_id']=$row['user_id'];
        $_SESSION['username']=$row['username'];
        $_SESSION['email']=$row['email'];

        // if user selected Remember me!
        if (empty($_POST['rememberMe'])){
            echo "success"; //if user didnt check rememberME
        }else{
            //if user checked remember me checkbox
            //Generate two variable $authenticator1 $authenticator2
            $authenticator1 = bin2hex(openssl_random_pseudo_bytes(10));
            $authenticator2 = openssl_random_pseudo_bytes(20);

            //Store variables into Cookies
            function f1($a,$b){
                $c = $a . "," . bin2hex($b);
                return $c;
            }
            $cookieValue = f1($authenticator1, $authenticator2);
            //Set COOKIE
            setcookie("rememberMe", $cookieValue, time()+ 1296000);

            //run query to store them in remember me table
            function f2($a){
                $b =  hash('sha256', $a);
                return $b;
            }
            $f2authenticator2 = f2($authenticator2);
            $user_id = $_SESSION['user_id'];
            $expiration = date('Y-m-d H:i:s',time()+1296000);
            $sql = "INSERT INTO rememberme (`authenticator1`, `f2authenticator2`, `user_id`, `expires`)
                    VALUES ('$authenticator1', '$f2authenticator2', '$user_id', '$expiration')";
            $result = mysqli_query($link, $sql);
            if(!$result){
                $errors += ["error" => $rememberMeError . mysqli_error($link)];
            }else{
                echo "success";
            }

        }
    }
}

//If there are any error Sending them to ajax at index.js
if ($errors){
    //encode array into string object for JS
    echo json_encode($errors);
}

?>