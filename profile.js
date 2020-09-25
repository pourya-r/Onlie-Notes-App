
//Ajax call to updateUsername.php
//once form submitted
$("#updateUsernameForm").on('submit', function (event){
    event.preventDefault();
    //collect user inputs
    let dataToPost = $(this).serializeArray();

    //Send them to updateusername.php using Ajax
    $.ajax({
        url: "updateUsername.php",
        type: "POST",
        data: dataToPost,
        success: data => {
            //printing errors
            if (data){
                $("#updateUsernameMessage").html(data);
            }else{
                console.log("reload")
                location.reload();
            }
        }, // fin the Success
        error: () => {
            $("#updateUsernameMessage").html("<div class='alert alert-danger' style='border: #FC4D1C 1px solid;border-radius: 15px'>There was an Error please try again later!</div>");
        }
    })
});



//Ajax call to updatePassword.php
    $("#updatePassForm").on('submit', function (event){
    event.preventDefault();
    //collect user inputs
    let dataToPost = $(this).serializeArray();

    //Send them to updateusername.php using Ajax
    $.ajax({
        url: "updatePassword.php",
        type: "POST",
        data: dataToPost,
        success: data => {
            //printing errors
            if (data) {
                console.log(data);
                passwordErrorHandler(data);
            }

        }, // fin the Success
        error: () => {
            $("#updatePassMessage").html("<div class='alert alert-danger' style='border: #FC4D1C 1px solid;border-radius: 15px'>There was an Error please try again later!</div>");
        }
    })
})



//Ajax call to updateEmail.php
$("#updateEmailForm").on('submit', function (event){
    event.preventDefault();
    //collect user inputs
    let dataToPost = $(this).serializeArray();

    //Send them to updateEmail.php using Ajax
    $.ajax({
        url: "updateEmail.php",
        type: "POST",
        data: dataToPost,
        success: data => {
            //printing errors
            if (data) {
                emailErrorHandler(data);
            }

        }, // fin the Success
        error: () => {
            $("#updateEmailMessage").html("<div class='alert alert-danger' style='border: #FC4D1C 1px solid;border-radius: 15px'>There was an Error please try again later!</div>");
        }
    })
})









// Functions
//handling error for  password
function passwordErrorHandler(data){
    //Clear validation and errors
    $('input').removeClass("is-invalid");
    $("#updatePassMessage").html("<div></div>");
    let dataArray = {};

    if (data){
        //getting data array(object) from data to show error under inputs
        dataArray = JSON.parse(data);

        //if password error (Missing)
        if (dataArray["missingPassword"]){
            $("#passwordError").html(dataArray["missingPassword"]);
            $('input[name="password"]').addClass("is-invalid");
        }else{$('input[name="password"]').addClass("is-valid");}

        //if invalid Password
        if (dataArray["invalidPassword"]){
            $("#newPasswordError").html(dataArray["invalidPassword"]);
            $('input[name="newPassword"]').addClass("is-invalid");
        }else{$('input[name="newPassword"]').addClass("is-valid2");}

        //if New password  Missing error (password 1)
        if (dataArray["missingNewPassword"]){
            $("#newPasswordError").html(dataArray["missingNewPassword"]);
            $('input[name="newPassword"]').addClass("is-invalid");
        }
        //if New password repeat Missing error (password 2)
        if (dataArray["missingPassword2"]){
            $("#repeatPasswordError").html(dataArray["missingPassword2"]);
            $('input[name="repeatPassword"]').addClass("is-invalid");
        }

        //if passwords Do  not match
        if (dataArray["differentPass"]){
            $("#newPasswordError").html(dataArray["differentPass"]);
            $("#repeatPasswordError").html(dataArray["differentPass"]);
            $('input[name="newPassword"]').addClass("is-invalid");
            $('input[name="repeatPassword"]').addClass("is-invalid");
        }
        //query errors
        if (dataArray["message"]) {
            $("#updatePassMessage").html(dataArray["message"]);
        }

        //if old password is not correct
        if (dataArray["wrongPassword"]){
            $("#passwordError").html(dataArray["wrongPassword"]);
            $('input[name="password"]').addClass("is-invalid");

        }else{$('input[name="password"]').addClass("is-valid");}

        //If successfully password changed
        if (dataArray["success"]) {
            $("#updatePassMessage").html(dataArray["success"]);
            setTimeout(function (){
                window.location.href = "index.php?logout=1";
            },2000)
        }
    }
}

//Handling errors for change email
function emailErrorHandler(data) {
    //Clear validation and errors
    $('input').removeClass("is-invalid");
    let dataArray = {};

    if (data) {
        //getting data array(object) from data to show error under inputs
        dataArray = JSON.parse(data);
        console.log(dataArray);

        //if email error
        if (dataArray["missingEmail"]) {
            $("#updateEmailErrorMSG").html(dataArray["missingEmail"]);
            $('input[name="email"]').addClass("is-invalid");
        } else {
            $('input[name="email"]').addClass("is-valid")
        }

        //if invalid Email
        if (dataArray["invalidEmail"]) {
            $("#updateEmailErrorMSG").html(dataArray["invalidEmail"]);
            $('input[name="email"]').addClass("is-invalid");
        }

        //if already exist
        if (dataArray["alreadyExist"]) {
            $("#updateEmailErrorMSG").html(dataArray["alreadyExist"]);
            $('input[name="email"]').addClass("is-invalid");
        }

        //Other errors
        if (dataArray["message"]) {
            $("#updateEmailMessage").html(dataArray["message"]);
        }else{
            $("#updateEmailMessage").html("<div></div>");
        }

    }
}