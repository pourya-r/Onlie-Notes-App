<?php
session_start();
//include "connection.php";
//if the user is not logged in & remember me cookies exist
if (!isset($_SESSION['user_id']) && !empty($_COOKIE['rememberMe'])){
    //extract $authenticator1&2 from the cookie
    //to remind: COOKIE(f1):  $a . "," . bin2hex($b)  &  F2: hash('sha256', $a)
    list($authenticator1, $authenticator2) = explode("," , $_COOKIE['rememberMe']);
    $authenticator2 = hex2bin($authenticator2);
    $f2authenticator2 = hash('sha256', $authenticator2);

    //Look for authenticator 1 in remember me table
    $sql = "SELECT * FROM rememberme WHERE authenticator1='$authenticator1'";
    $result = mysqli_query($link, $sql);
    //Check for errors
    if (!$result) {
        echo "there was an error to run an query";
        exit;
    }
    $count = mysqli_num_rows($result);
    if ($count !== 1){
        echo "remember me process failed....";
        exit;
    }

    //if no error we extract user from remember me table
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if (!hash_equals($row['f2authenticator2'],$f2authenticator2)){
        echo 'hash_equals returns false';
    }else{
        //Regenerate new Authenticators and store them in the cookie and remember table

        $authenticator1 = bin2hex(openssl_random_pseudo_bytes(10));
        $authenticator2 = openssl_random_pseudo_bytes(20);

        //Store variables into Cookies
        function f1($a,$b){
            return $a . "," . bin2hex($b);
        }
        $cookieValue = f1($authenticator1, $authenticator2);


         //Set COOKIE
        setcookie("rememberMe", $cookieValue, time() + 1296000);

        //run query to store them in remember me table
        function f2($a){
            $b = hash('sha256', $a);
            return $b;
        }
        $f2authenticator2 = f2($authenticator2);
        $user_id = $_SESSION['user_id'];
        $expiration = date('Y-m-d H:i:s', time() + 1296000);

        $sql = "INSERT INTO rememberme (`authenticator1`, `f2authenticator2`, `user_id`, `expires`) 
                VALUES ('$authenticator1', '$f2authenticator2', '$user_id' ,'$expiration')";

        $result = mysqli_query($link, $sql);
        if(!$result){
            echo "cannot run query line 51";
        }

        //Log user in and redirect him into Main Notes page
        $_SESSION['user_id'] = $row['user_id'];
        header("location:mainpageloggedin.php");
    }
}
?>