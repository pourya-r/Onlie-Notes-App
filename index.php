<?php
session_start();
include ("connection.php");

//logout
include ("logout.php");

//Remember Me
include ("remember.php");
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
    <title>Online Note App</title>
</head>
<body>
<!-- Navigation bar-->
    <nav class="navbar navbar-expand-md fixed-top navbar-dark navbar-custom" role="navigation">
        <div class="container-fluid ">
            <a href="/" class="navbar-brand">
                Online Note App
            </a>
            <button class="navbar-toggler" data-toggle ="collapse" data-target="#navbarNav">
                <span class="sr-only">toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="nav navbar-nav">
                    <li class="nav-item active">
                        <a href="" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">Help</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">Contact Us</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="#loginModal" data-toggle="modal" class="nav-link">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<!--Jumbotron-->
    <div class="py-5 px-3 mx-auto" id="jumbotron">
        <h2 class="display-3">Online Notes App</h2>
        <p>You Notes with you wherever you go</p>
        <p>easy to use, protect all your notes!</p>
        <button class="btn btn-lg btn-warning mt-5" type="button"
                data-toggle="modal" data-target="#signupModal">Sign up it´s Free!</button>
    </div>

<!------------Modals------------>
<!--signUp modal-->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" id="signupForm">
    <div class="modal" id="signupModal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Sign up today and Start using out Online Notes App for Free!</h4>
                    <button class="close" data-dismiss="modal" data-target="#signupModal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <!-- Signup message-->
                    <div id="signupMessage"></div>
                        <div class="form-outline mb-4 ">
                            <input type="text" id="signupName" name="signupName"
                                   class="form-control form-control-lg" maxlength="30"/>
                            <small class="invalid-feedback font-weight-bold" id="signupNameError"> </small>
                            <label class="form-label" for="signupName">Username</label>

                        </div>
                        <div class="form-outline mb-4">
                            <input type="email" id="signupEmail" name="signupEmail"
                                   class="form-control form-control-lg" maxlength="50"/>
                            <small class="invalid-feedback font-weight-bold" id="signupEmailError"> </small>
                            <label class="form-label" for="signupEmail">Email address</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="password" id="signupPass" name="signupPass"
                                   class="form-control form-control-lg" maxlength="30"/>
                            <small class="invalid-feedback font-weight-bold" id="signupPassError"> </small>
                            <label class="form-label" for="signupPass">Password</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="password" id="signupPassRepeat" name="signupPassRepeat"
                                   class="form-control form-control-lg" maxlength="30"/>
                            <small class="invalid-feedback font-weight-bold" id="signupPass2Error"> </small>
                            <label class="form-label" for="signupPassRepeat">Repeat Password</label>
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-lg btn-warning" type="submit" value="submit" name="signup">Sign up</button>
                    <button class="btn btn-lg btn-outline-info" data-dismiss="modal" type="submit" name="cancel">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!--Login modal-->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" id="loginForm">
    <div class="modal" id="loginModal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!--Form Header-->
                <div class="modal-header">
                    <h4 class="modal-title">Login</h4>
                    <button class="close" data-dismiss="modal" data-target="#loginModal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Login message-->
                    <div id="loginMessage"></div>

                    <!-- Form body-->

                    <div class="form-outline mb-4">
                        <input type="email" id="loginEmail" name="loginEmail"
                               class="form-control form-control-lg" maxlength="50"/>
                        <small class="invalid-feedback font-weight-bold" id="loginEmailError"></small>
                        <label class="form-label" for="loginEmail">Email</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="password" id="loginPass" name="loginPass"
                               class="form-control form-control-lg" maxlength="30"/>
                        <small class="invalid-feedback font-weight-bold" id="loginPassError"></small>
                        <label class="form-label" for="loginPass">Password</label>
                    </div>

                </div>
                <!--Footer of login form-->
                <div class="row mb-4">
                    <!--remember me checkbox-->
                    <div class="col d-flex justify-content-center">
                    <!--checkbox-->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe" checked>
                            <label for="rememberMe" class="form-check-label">Remember me</label>
                        </div>
                    </div>
                    <!--Forgot password-->
                    <div class="col">
                        <a href="#forgotPassModal"  data-dismiss="modal" data-toggle="modal">Forgot password?</a>
                    </div>
                </div>
                <!--submit button-->
                <div class="container mb-4">
                    <button type="submit" name="submit"  class="btn btn-block btn-warning btn-lg">SIGN IN</button>
                </div>
                <!--if not registered link!-->
                <div class="text-center">
                    <p>Not a member?
                        <a href="#signupModal"  data-dismiss="modal" data-toggle="modal">Register</a></p>
                </div>
            </div>
        </div>
    </div>
</form>


<!--forgot password form modal-->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" id="forgotPassForm">
    <div class="modal" id="forgotPassModal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Forgot Password?</h4>
                    <button class="close" data-dismiss="modal" data-taret="#forgotPassModal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Login message-->
                    <div id="forgotPassMessage"></div>

                    <!-- Form body-->
                    <h6 class="text-warning">Please enter your email</h6>
                    <div class="form-outline mb-4">
                        <input type="email" id="forgotPassEmail" name="forgotPassEmail"
                               class="form-control form-control-lg" maxlength="50"/>
                        <small class="invalid-feedback" id="forgotPassEmailError"></small>
                        <label class="form-label" for="forgotPassEmail">Email</label>
                    </div>

                <!--submit button-->
                    <div class="container mb-4">
                        <button type="submit" name="submit"  class="btn btn-block btn-warning btn-lg">RESET PASSWORD</button>
                    </div>
            </div>
        </div>
    </div>
</form>

<!--Footer-->
<footer class="fixed-bottom">
    <div class="container pt-3">
        <p class="text-muted text-light text-center">
            by <a href="https://bestsitecreators.com" class="text-decoration-none text-dark" target="_blank">Best Site Creators</a>
            Copyright &copy; 2020<?php if (date('Y') != 2020)echo '-' .date('y');?>
        </p>
    </div>
</footer>

<!-- JavaScript and dependencies -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/1.0.0/mdb.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>-->
<script type="text/javascript" src="home.js"></script>
</body>
</html>