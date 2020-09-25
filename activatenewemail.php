<?php
session_start();
include ("connection.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="styling.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/1.0.0/mdb.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Arvo&display=swap" rel="stylesheet">
    <title>Activation New Email</title>
</head>
<body>

<?php
//User redirect to this page when click on activation link received by email
//Signup link contains three get parameters: email , NewEmail and activation key


//If email or activation ket is missing (show and error)
if (!isset($_GET['newEmail']) || !isset($_GET['email']) || !isset($_GET['key'])){
    echo "<div class='container alert alert-danger card card-body' style='margin-top: 150px;border:#FC4D1C 2px solid;border-radius: 15px'>There was an error, please click on Activation you received by email</div>";
    exit;

}
//if there wasn't any error store them
$email = $_GET['email'];
$newEmail = $_GET['newEmail'];
$key = $_GET['key'];

//Preparing variables for query
$email = mysqli_real_escape_string($link, $email);
$newEmail = mysqli_real_escape_string($link, $newEmail);
$key = mysqli_real_escape_string($link, $key);


//run query to check if this combination of key / email exist
// if true we change activation field to activated and email address to new one
$sql = "UPDATE users SET activation2='0', email='$newEmail' WHERE (email='$email' AND activation2='$key') LIMIT 1";
$result = mysqli_query($link,$sql);
//If successful, show success message and invite user to Login
if (mysqli_affected_rows($link)){
    session_destroy();
    setcookie("rememberMe", "", time() - 36000);

    echo "<div class='container alert alert-success card card-body' style='margin-top: 150px;max-width: 600px;border:#FC4D1C 2px solid;border-radius: 15px'>Your new Email has been confirmed, <br/> <a href='index.php' type='button' class='btn btn-outline-success btn-lg mx-auto'>Login</a></div>";
}else{
    //show error message
    echo "<div class='container alert alert-danger card card-body' style='margin-top: 150px;border:#FC4D1C 2px solid;border-radius: 15px'>Your new email Cannot be Confirmed, please try again later <br/> Error: ". mysqli_error($link) ." </div>";

}
?>
<!-- JavaScript and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/1.0.0/mdb.min.js" ></script>
<script type="text/javascript" src="home.js"></script>


</body>
</html>