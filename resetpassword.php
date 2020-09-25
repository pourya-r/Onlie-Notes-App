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
    <title>Reset password</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class='offset-md-3 col-md-6 alert ' style='margin-top: 150px;border:#FC4D1C 2px solid;border-radius: 15px;background-color: rgba(0,0,0,0.2)'>
            <h1>Reset Password: </h1>
            <div id="resultMessage" class="container mb-5"></div>

<?php
//User redirect to this page when click on reset link
//Signup link contains two get parameters: user_id and key


//If email or activation ket is missing (show and error)
if (!isset($_GET['user_id']) || !isset($_GET['key'])){
    echo "<div class='container alert alert-danger' style='border:#FC4D1C 2px solid;border-radius: 15px'>There was an error, please click on Link that you received by email</div>";
}
//if there wasn't any error store them
$user_id = $_GET['user_id'];
$key = $_GET['key'];
$time = time() - 86400;

//Preparing variables for query
$user_id = mysqli_real_escape_string($link, $user_id);
$key = mysqli_real_escape_string($link, $key);

//check if key and use_id combination is valid and time didnt pass by 24 hour
$sql = "SELECT user_id FROM forgotpassword WHERE rkey='$key' AND user_id='$user_id' AND time >'$time'";
$result = mysqli_query($link,$sql);
//Check for error
if (!$result) {
    echo "<p class='text-danger p-2' style='border: #FC4D1C solid 1px;border-radius: 10px' >There is error on query please try again later</p>";
    exit;
}
//Check if combination dose not exist
$count = mysqli_num_rows($result);
if ($count !==1){
    echo "<div class='text-danger p2' style='border: #FC4D1C solid 1px;border-radius: 10px'><p>please try again later</p><p class='text-muted'>Note: maybe your link has been expire, every link has only 24 hour life!</p></div>";
    exit;
}
//print reset password form with hidden user_id and key field

echo "
<div class='row'>
<div class='offset-md-1 col-md-10'>
<form action='resetpassword.php' method='post' id='resetPassForm'>
<input type='hidden' name=key value='$key'>
<input type='hidden' name=user_id value='$user_id'>
<div class='form-group form-outline mb-4'>
<input class='form-control form-control-lg' type='password' name='password' id='password'>
                <small class='invalid-feedback font-weight-bold' id='passError'></small>
                <label for='password' class='form-label'>Enter password:</label>
            </div>
            <div class='form-group form-outline mb-4'>
                <input class='form-control form-control-lg' type='password' name='password2' id='password2'>
                <small class='invalid-feedback font-weight-bold' id='pass2Error'></small>
                <label for='password2' class='form-label'>Re-Enter password:</label>
            </div>
            <input type='submit' name='resetPassword' class='btn btn-lg btn-block btn-warning' value='Reset Password'>
        </form>
    </div>
</div>
";
?>
        </div>
    </div>
</div>
<!-- JavaScript and dependencies -->

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/1.0.0/mdb.min.js" ></script>
<script src="home.js"></script>
<script>
    $("#resetPassForm").on("submit", function(event){
        event.preventDefault();
        //get user data
        let dataToPost = $(this).serializeArray();
        //send data by ajax
        $.ajax({
            url: "storeresetpassword.php",
            type: "POST",
            data: dataToPost,
            success: (data) => {
                errorHandler(data);
            },
            error: () => {
                $("#resultMessage").html(`<div class='alert alert-danger' style='border: #FC4D1C 1px solid;border-radius: 15px'>There was an error with ajax call please try again later</div>`);
            }
        })
    });

    //Error handling
    function errorHandler(data){
        //Clear validation and errors
        $('input').removeClass("is-invalid");
        $('input').removeClass("is-valid");
        $("#resultMessage").html("<div></div>");
        let dataArray = {};

        if (data){
            //getting data array(object) from data to show error under inputs
            // console.log(data);
            dataArray = JSON.parse(data);
            console.log(dataArray);
            //if password error (Missing)
            if (dataArray["missingPassword"]){
                $("#passError").html(dataArray["missingPassword"]);
                $('input[name="password"]').addClass("is-invalid");
            }else{$('input[name="password"]').addClass("is-valid");}

            //if invalid Password
            if (dataArray["invalidPassword"]){
                $("#passError").html(dataArray["invalidPassword"]);
                $('input[name="password"]').addClass("is-invalid");
            }else{$('input[name="password"]').addClass("is-valid");}

            //if password repeat Missing error (password 2)
            if (dataArray["missingPassword2"]){
                $("#pass2Error").html(dataArray["missingPassword2"]);
                $('input[name="password2"]').addClass("is-invalid");
            }

            //if passwords Do  not match
            if (dataArray["differentPass"]){
                $("#passError").html(dataArray["differentPass"]);
                $("#pass2Error").html(dataArray["differentPass"]);
                $('input[name="password"]').addClass("is-invalid");
                $('input[name="password2"]').addClass("is-invalid");
            }
            if (dataArray["message"]) {
                $("#resultMessage").html(dataArray["message"]);
            }
        }
    }

</script>


</body>
</html>