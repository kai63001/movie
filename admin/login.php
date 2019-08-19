<?php

    require('../condb.php');
    error_reporting(0);
    session_start();

    if($_SESSION['a_id']){
        header('location:index.php');
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie2D - ADMIN</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- <link href="https://fonts.googleapis.com/css?family=Kanit&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Concert+One&display=swap" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One&display=swap" rel="stylesheet">

    <style>
        html,body{
            width:100%;
            height:100%;
            font-family: 'Fredoka One', cursive;
        }
    </style>
</head>
<body>
   
    <div class="row" style="height:100%;">
        <div class="col-md-9" style="background:black;">
            <!-- <img src="https://picserio.com/data/out/273/mr-robot-wallpaper_4841833.jpg" width="100%" height="100%" alt=""> -->
        </div>
        <div class="col-md-3">
            <div class="container">
                <br>
                <center><h1>..LOGIN..</h1></center>
                <br><span id="msg"></span><br>
                Username :
                <input type="text" id="a_username" class="form-control">
                Password :
                <input type="password" id="a_password" class="form-control">
                <br>
                <button class="btn btn-success" id="login"> SignIn </button>
            </div>
        </div>
    </div>
    
    <script src="https://kit.fontawesome.com/138bb41885.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        $('#login').click(function(){
            var a_username = $('#a_username').val();
            var a_password = $('#a_password').val();
            
            var XMLLogin = new XMLHttpRequest();
            var pmeters = 'a_username='+a_username+'&a_password='+a_password;
            XMLLogin.open('POST','ajax/_login.php',true);
            XMLLogin.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            XMLLogin.send(pmeters);
            XMLLogin.onreadystatechange = function(){
                if(XMLLogin.readyState == 3){
                    $('#msg').html('กำลังตรวจสอบ');
                }
                if(XMLLogin.readyState == 4){
                    $('#msg').html(XMLLogin.responseText);
                    console.log('asda');

                }
            }
        });
    </script>
</body>
</html>