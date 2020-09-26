<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("location: index.php");
}

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
    <script src="https://kit.fontawesome.com/4cbe464fbe.js" crossorigin="anonymous"></script>
    <title>Online Note App</title>
</head>
<style>
    .noteDiv {
        font-family: 'Arvo', sans-serif ;
        cursor: pointer;
        border: #FC4D1C solid 1px;
        border-radius: 15px;
        box-shadow: 0 0 4px black;
    }
</style>
<body>
<!-- Navigation bar-->
<nav class="navbar navbar-expand-lg fixed-top navbar-dark navbar-custom" role="navigation">
    <div class="container-fluid ">
        <a href="" class="navbar-brand">
            Online Note App
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="nav navbar-nav">
                <li class="nav-item ">
                    <a href="profile.php" class="nav-link">Profile</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">Help</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">Contact Us</a>
                </li>
                <li class="nav-item active">
                    <a href="" class="nav-link">My Notes</a>
                </li>
            </ul>
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item mr-2">
                    <a href="#" class="nav-link">logged in as <b><?php echo $_SESSION['username'] ?></b></a>
                </li>
                <li class="nav-item">
                    <a href="index.php?logout=1" class="nav-link">Log Out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!--Page Container  -->
<div class="container" style="margin-top: 120px">
    <!--  Alert Message  -->
    <div id="alert" role="alert" class="alert alert-warning alert-dismissible collapse mx-auto" style="max-width: 700px;border-radius: 15px">
        <a href="#" class="close" data-dismiss="alert">
            &times;
        </a>
        <p id="alertMessage" ></p>
    </div>
    <div class="row">
        <!--Buttons-->
        <div class="offset-md-2 col-md-8 mb-3">
            <div>
            <button type="button" name="addNote" value="addNote" id="addNote"
                    class="btn btn-lg btn-warning float-left text-capitalize">Add Note</button>

            <button type="button" name="allnote" value="allNote" id="allnote"
                    class="btn btn-lg btn-warning float-left  text-capitalize">All Note</button>

            <button type="button" name="edit" value="Edit" id="edit"
                    class="btn btn-lg btn-warning float-right text-capitalize">Edit</button>

            <button type="button" name="done" value="done" id="done"
                    class="btn btn-lg btn-outline-warning float-right text-capitalize">Done</button>
            </div>
        </div>
        <!--Text area for Adding/writing/Editing Note-->
        <div class="offset-md-2 col-md-8" id="notePad">
            <textarea name="textarea" id="textarea" cols="30" rows="10"></textarea>
        </div>
        <div id="notes" class="offset-md-2 col-md-8 notes" >
        <!--Ajax Call to-->
        </div>
    </div>
</div>

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
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.15.0/basic/ckeditor.js"></script>
<script src="myNotes.js"></script>
<script>
    // $(document).ready(function (){
    //     CKEDITOR.replace('textarea').focus();
    // })

</script>

</body>
</html>