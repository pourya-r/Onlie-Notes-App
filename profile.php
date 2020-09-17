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
    <title>Profile</title>
</head>
<body>
<!-- Navigation bar-->
<nav class="navbar navbar-expand-lg fixed-top navbar-dark navbar-custom" role="navigation">
    <div class="container-fluid ">
        <a href="/" class="navbar-brand">
            Online Note App
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="nav navbar-nav">
                <li class="nav-item active">
                    <a href="" class="nav-link">Profile</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">Help</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a href="mainpageloggedin.php" class="nav-link">My Notes</a>
                </li>
            </ul>
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item mr-2">
                    <a href="#" class="nav-link">logged in as <b>username</b></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Log Out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!--Page Container  -->
<div class="container py-5 px-md-5 mx-md-5" id="jumbotron">
    <h1 class="display-4">General Account setting</h1>
    <table class="profileTable table table-responsive table-hover table-bordered table-sm text-left mx-auto">
        <tr data-target="#updateUsername" data-toggle="modal">
            <th>Username</th>
            <td>Value</td>
        </tr>
        <tr data-target="#updateEmail" data-toggle="modal">
            <th>Email</th>
            <td>value</td>
        </tr>
        <tr data-target="#updatePassword" data-toggle="modal">
            <th>Password</th>
            <td>Hidden</td>
        </tr>
    </table>

</div>


<!------------Modals------------>
<!--update Email-->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" id="updateEmailForm">
    <div class="modal" id="updateEmail" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Email</h4>
                    <button class="close" data-dismiss="#updateEmail">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Login message-->
                    <div id="updateEmailMessage"></div>

                    <!-- Form body-->
                    <h5>Email:</h5>
                    <div class="form-outline mb-4">
                        <input type="email" id="email" name="email"
                               class="form-control form-control-lg" maxlength="50" value=""/>
                        <small class="invalid-feedback"></small>
                        <label class="form-label" for="email" id="emailLabel">Email</label>
                    </div>


                </div>
                <!--Footer of login form-->
                <!--submit button-->
                <div class="container mb-4">
                    <button type="submit" name="login"  value="submit" class="btn btn-block btn-warning btn-lg">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>


<!--update username modal-->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" id="updateUsernameForm">
    <div class="modal" id="updateUsername" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Username</h4>
                    <button class="close" data-dismiss="#updateUsername">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Login message-->
                    <div id="updateUsernameMessage"></div>

                    <!-- Form body-->
                    <h5>Username:</h5>
                    <div class="form-outline mb-4">
                        <input type="text" id="username" name="username"
                               class="form-control form-control-lg" maxlength="30" value=""/>
                        <small class="invalid-feedback"></small>
                        <label class="form-label" for="loginEmail" id="usernameLabel">Username</label>
                    </div>


                </div>
                <!--Footer of login form-->
                <!--submit button-->
                <div class="container mb-4">
                    <button type="submit" name="login"  value="submit" class="btn btn-block btn-warning btn-lg">Sumbit</button>
                </div>
            </div>
        </div>
    </div>
</form>


<!--update Password-->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" id="updatePassForm">
    <div class="modal" id="updatePassword" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Password</h4>
                    <button class="close" data-dismiss="#updatePassword">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Login message-->
                    <div id="updateEmailMessage"></div>

                    <!-- Form body-->

                    <div class="form-outline mb-4">
                        <input type="password" id="password" name="password"
                               class="form-control form-control-lg" maxlength="30" value=""/>
                        <small class="invalid-feedback"></small>
                        <label class="form-label" for="password" id="passLabel">Current Password</label>
                    </div>
                    <hr>

                    <div class="form-outline mb-4">
                        <input type="password" id="newPassword" name="newPassword"
                               class="form-control form-control-lg" maxlength="30" value=""/>
                        <small class="invalid-feedback"></small>
                        <label class="form-label" for="newPassword" id="newPasswordLabel">New Password</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="password" id="repeatPassword" name="repeatPassword"
                               class="form-control form-control-lg" maxlength="30" value=""/>
                        <small class="invalid-feedback"></small>
                        <label class="form-label" for="repeatPassword" id="repeatPasswordLabel">Repeat Password</label>
                    </div>




                </div>
                <!--Footer of login form-->
                <!--submit button-->
                <div class="container mb-4">
                    <button type="submit" name="login"  value="submit" class="btn btn-block btn-warning btn-lg">Submit</button>
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
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/1.0.0/mdb.min.js" ></script>

</body>
</html>