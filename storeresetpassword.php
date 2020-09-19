
<?php

session_start();
include('connection.php');


//define errors
$errors = array();
$wrongInputs = "<div class='alert alert-danger' style='border:#FC4D1C 2px solid;border-radius: 15px'>There was an error, please try again and click on Link that you received by email</div>";
$queryError = "<div class='alert alert-danger' style='border:#FC4D1C 2px solid;border-radius: 15px'>Query ERROR, Please try again later</div>";
$notExist = "<div class='alert alert-danger' style='border:#FC4D1C 2px solid;border-radius: 15px'>Please try again!</div>";
$missingPassword='Please enter a password!';
$invalidPassword= 'Should be: More than 6 characters includes Capital letter and Number';
$differentPassword='Passwords don\'t match!';
$missingPassword2='Please confirm your password!';


//If user_id or key is missing
if(!isset($_POST['user_id']) || !isset($_POST['key'])){
    $errors += ["message"=>$wrongInputs];
}

//else we store them into variables
$user_id = $_POST['user_id'];
$key = $_POST['key'];
$time = time() - 86400;

//prepare variables for the query
$user_id = mysqli_real_escape_string($link, $user_id);
$key = mysqli_real_escape_string($link, $key);

//run query to check combination of user_id and key
$sql = "SELECT user_id FROM forgotpassword WHERE user_id='$user_id' AND rkey='$key' AND time > '$time' AND status='pending'";
$result = mysqli_query($link, $sql);
if (!$result){
    $errors += ["message" => $queryError];
}

//Else, Check if combination dose exist
//if not shows return error
$count = mysqli_num_rows($result);
if ($count !==1){
    $errors += ["message" => $notExist];
}
//else we update user password
//Get password from input and check them

if (!$errors){
    if (empty($_POST["password"])){
        $errors += ["missingPassword" => $missingPassword];
    }elseif(!(strlen($_POST["password"]) > 6
        and preg_match('/[A-Z]/' ,$_POST["password"])
        and preg_match('/[0-9]/' ,$_POST["password"]))){
        $errors += ["invalidPassword" => $invalidPassword];
    }else{
        $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
        if (empty($_POST["password2"])) {
            $errors += ["missingPassword2" => $missingPassword2];
        }else{
            $password2 = filter_var($_POST["password2"], FILTER_SANITIZE_STRING);
            if ($password !== $password2){
                $errors += ["differentPass" => $differentPassword];
            }
        }
    }
}
if (!$errors){
    //If no errors
//Prepare variables for query ( Clean version of inputs)
    $password = mysqli_real_escape_string($link, $password);
//hashing email for security (32 char)
//$password = md5($password);

//hashing email for security (64 char)
    $password = hash("sha256", $password);

//Create and run query
    $sql = "UPDATE users SET password='$password' WHERE user_id='$user_id'";
    $result = mysqli_query($link, $sql);
    if(!$result){
        $errors += ["message" => "<p class='alert alert-danger'>There was problem storing your password</p>"];
    }else{
        //update status of forget password from pending to used
        $sql = "UPDATE forgotpassword SET status='used' WHERE user_id='$user_id' AND rkey='$key'";
        $result = mysqli_query($link, $sql);
        if(!$result) {
            $errors += ["message" => "<p class='alert alert-danger'>There was with setting password status</p>"];
        }else{
            $errors += ["message" => "<p class='alert alert-success'>Your password updated successfully. <a href='index.php'>Log in?</a></p>"];

        }
    }

}

if ($errors){
    echo json_encode($errors);
}
?>