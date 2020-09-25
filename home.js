//Ajax call for the Signup Form
//once form submitted
$("#signupForm").on("submit", function (event){
    event.preventDefault();
    //collect user inputs
    let dataToPost = $(this).serializeArray();
    console.log(dataToPost);

    //send them to signup.php using AJAX
    $.ajax({
        url: "signup.php",
        type: "POST",
        data: dataToPost,
        success: data => {
            //printing errors
            signupErrorHandler(data);
        }, // fin the Success
        error: () => {
            $("#signupMessage").html("<div class='alert alert-danger' style='border: #FC4D1C 1px solid;border-radius: 15px'>There was an Error please try again later!</div>");
        }
    });
});

//Ajax call for Login Form
//Once user press Login button
$("#loginForm").on("submit", function (event){
    event.preventDefault();
    // Collect user input
    let dataToPost = $(this).serializeArray();

    // send input via jax to loggin.php
    $.ajax({
        url: "loggin.php",
        type: "POST",
        data: dataToPost,
        success: data => {
            if (data =="success"){
                window.location = "mainpageloggedin.php";
            }else{
                logginErrorHandler(data);
            }
        },
        error: () => {
          $("#loginMessage").html("<div class='alert alert-danger' style='border: #FC4D1C 1px solid;border-radius: 15px'>" +
              "There was an error with ajax call please try again later</div>");
        }
    });
});

//ajax call for forgot password
$("#forgotPassForm").on("submit", function (event){
    event.preventDefault();
    // Collect user input
    let dataToPost = $(this).serializeArray();

    // send input via jax to loggin.php
    $.ajax({
        url: "forgot-password.php",
        type: "POST",
        data: dataToPost,
        success: data => {
           forgotPassErrorHandler(data);
        },
        error: () => {
            $("#forgotPassMessage").html("<div class='alert alert-danger' style='border: #FC4D1C 1px solid;border-radius: 15px'>" +
                "There was an error with ajax call please try again later</div>");
        }
    });
});






//Functions
//Error handler for signUp form
function signupErrorHandler(data){
    //Clear validation and errors
    $('input').removeClass("is-invalid");
    $("#signupMessage").html("<div></div>");
    let dataArray = {};

    if (data){
        //getting data array(object) from data to show error under inputs
        dataArray = JSON.parse(data);
        //if username error
        if (dataArray["missingUsername"]){
            $("#signupNameError").html(dataArray["missingUsername"]);
            $('input[name="signupName"]').addClass("is-invalid");
        }else { $('input[name="signupName"]').addClass("is-valid")}

        //if email error
        if (dataArray["missingEmail"]){
            $("#signupEmailError").html(dataArray["missingEmail"]);
            $('input[name="signupEmail"]').addClass("is-invalid");
        }else {$('input[name="signupEmail"]').addClass("is-valid")}

        //if invalid Email
        if (dataArray["invalidEmail"]){
            $("#signupEmailError").html(dataArray["invalidEmail"]);
            $('input[name="signupEmail"]').addClass("is-invalid");
        }else{$('input[name="signupEmail"]').addClass("is-valid");}

        //if password error (Missing)
        if (dataArray["missingPassword"]){
            $("#signupPassError").html(dataArray["missingPassword"]);
            $('input[name="signupPass"]').addClass("is-invalid");
        }else{$('input[name="signupPass"]').addClass("is-valid");}

        //if invalid Password
        if (dataArray["invalidPassword"]){
            $("#signupPassError").html(dataArray["invalidPassword"]);
            $('input[name="signupPass"]').addClass("is-invalid");
        }else{$('input[name="signupPass"]').addClass("is-valid");}

        //if password repeat Missing error (password 2)
        if (dataArray["missingPassword2"]){
            $("#signupPass2Error").html(dataArray["missingPassword2"]);
            $('input[name="signupPassRepeat"]').addClass("is-invalid");
        }

        //if passwords Do  not match
        if (dataArray["differentPass"]){
            $("#signupPassError").html(dataArray["differentPass"]);
            $("#signupPass2Error").html(dataArray["differentPass"]);
            $('input[name="signupPass"]').addClass("is-invalid");
            $('input[name="signupPassRepeat"]').addClass("is-invalid");
        }
        if (dataArray["queryError"]) {
            $("#signupMessage").html(dataArray["queryError"]);
        }
        if (dataArray["userExist"]) {
            $("#signupMessage").html(dataArray["userExist"]);
        }
    }
}

// Error handler for login form
function logginErrorHandler(data){
    //Clear validation and errors
    $('input').removeClass("is-invalid");
    $("#loginMessage").html("<div></div>");
    let dataArray = {};

    if (data){
        //getting data array(object) from data to show error under inputs
        dataArray = JSON.parse(data);

        //if email error
        if (dataArray["missingEmail"]){
            $("#loginEmailError").html(dataArray["missingEmail"]);
            $('input[name="loginEmail"]').addClass("is-invalid");
        }else {$('input[name="loginEmail"]').addClass("is-valid")}


        //if password error (Missing)
        if (dataArray["missingPass"]){
            $("#loginPassError").html(dataArray["missingPass"]);
            $('input[name="loginPass"]').addClass("is-invalid");
        }else{$('input[name="loginPass"]').addClass("is-valid");}

        //Other errors
        if (dataArray["error"]) {
            $("#loginMessage").html(dataArray["error"]);
            $('small').html("<p></p>");
            $('input[name="loginEmail"]').addClass("is-invalid");
            $('input[name="loginPass"]').addClass("is-invalid");
        }

    }
}

// Error handler for Resset password
function forgotPassErrorHandler(data){
    //Clear validation and errors
    $('input').removeClass("is-invalid");
    $("#forgotPassMessage").html("<div></div>");
    let dataArray = {};

    if (data){
        //getting data array(object) from data to show error under inputs
        dataArray = JSON.parse(data);

        //if email error
        if (dataArray["missingEmail"]){
            $("#forgotPassEmailError").html(dataArray["missingEmail"]);
            $('input[name="forgotPassEmail"]').addClass("is-invalid");
        }else {$('input[name="forgotPassEmail"]').addClass("is-valid")}

        //if invalid email
        if (dataArray["invalidEmail"]){
            $("#forgotPassEmailError").html(dataArray["invalidEmail"]);
            $('input[name="forgotPassEmail"]').addClass("is-invalid");
        }else{$('input[name="forgotPassEmail"]').addClass("is-valid");}


        //Other errors
        if (dataArray["message"]) {
            $("#forgotPassMessage").html(dataArray["message"]);
            $('input[name="forgotPassEmail"]').addClass("is-invalid");

        }

    }
}