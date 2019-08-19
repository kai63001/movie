<?php

    require('../condb.php');
    session_start();

    if(!$_SESSION['a_id']){
        header('location:login.php');
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie2D - ADMIN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        <div class="col-md-3">
            <div class="container">
                <br>
                <center><h1>ADMIN</h1></center>
                <br>
                <?php include('include/nav.php'); ?>
            </div>
        </div>
        <div class="col-md-9" style="background:#3d3d3d;color:white;">
            <div class="container">
                <br>
                <h1>Report</h1>
                <div class="box" style="padding:15px;background:white;color:#363636;border-radius:3px;">
                    All Report
                    <br>
                    <hr>
                    <div class="row">
                        <?php
                            $report = mysqli_query($condb,"SELECT * FROM report");

                            while($row_report = mysqli_fetch_array($report)){
                                $r_vid = $row_report['r_vid'];
                                $video_report = mysqli_fetch_array(mysqli_query($condb,"SELECT * FROM video WHERE v_id = '$r_vid'"));
                                
                                ?>
                                    <div class="col-md-2">
                                        <img src="<?=$video_report['v_img'];?>" width="100%" loading="lazy" alt="">
                                    </div>
                                    <div class="col-md-8">
                                        <?= $video_report['v_name'];?>
                                        <br>
                                        <?= substr($video_report['v_detail'],0,800);?>

                                    </div>
                                    <div class="col-md-2">
                                        <a href="movie.php?ai=edit&v_id=<?= $video_report['v_id'];?>" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                    </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://kit.fontawesome.com/138bb41885.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>