<?php

    require('condb.php');

    session_start();


    $v_id = mysqli_real_escape_string($condb,$_GET['v_id']);
    $row_detail = mysqli_fetch_array(mysqli_query($condb,"SELECT * FROM video WHERE v_id = '$v_id'"));

    $view = $row_detail['v_view'];
    $view += 1;

    $updateview = mysqli_query($condb,"UPDATE video SET v_view = '$view' WHERE v_id = '$v_id'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie2D - <?= $row_detail['v_name'];?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Kanit&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Concert+One&display=swap" rel="stylesheet">
    <style>
        .content {
            padding: 15px;
        }
        html, body {
            margin: auto;
            padding:0px;
            background: #4a4a4a;
            color:white;
            font-family: 'Kanit', sans-serif;
        }
        .movie:hover p {

        }
        .movie p {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .imdb {
            background: #4a4a4a;
            padding-left:5px;
            padding-right:5px;
            font-size:10px;
            border-radius:5px;
            color:#FFD700;
        }
        .nav-link{
            color: white;
        }
        .nav-link:hover{
            color: white;
        }
        .nav-tabs .nav-link.active {
            background: #383838;
            border:0px;
            color:white;
        }
        .nav-tabs{
            border:0px;
        }
    </style>
</head>
<body>
    <div class="content">
        <a href="../index.php" style="text-decoration:none;color:white;"><h1 style="font-family: 'Concert One', cursive;"><b>MOVIE<font color="#ff3838">2D</font></b></h1></a>
    </div>
    <?php include('include/navbar.php');?>

    <br>
    <div class="content">
        <div class="row">
            <div class="col-md-9">
                <nav aria-label="breadcrumb" style="background:#383838;border-radius:3px;">
                    <ol class="breadcrumb" style="background:#383838;border-radius:3px;">
                        <li class="breadcrumb-item"><a href="#" style="text-decoration:none;color:white;">หน้าแรก</a></li>
                        <li class="breadcrumb-item"><a href="#" style="text-decoration:none;color:white;">หนัง</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $row_detail['v_name'];?></li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-md-4">
                        <img src="<?= $row_detail['v_img'];?>" width="100%" height="415"  loading="lazy" alt="">
                    </div>
                    <div class="col-md-8">
                        
                        <iframe width="100%" height="415" src="https://www.youtube.com/embed/<?= $row_detail['v_trailer'];?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                <br>
                <div class="card" style="border:0px;">
                    <div class="card-header" style="background:#3d3d3d;color:white;border:0px;"> <i class="fas fa-info-circle"></i> เรื่องย่อ</div>
                    <div class="card-body" style="background:#545454;">
                        <?= $row_detail['v_detail'];?>
                    </div>
                </div>
                <br>
                <!-- open iframe -->
                <?php
                    $row_movie = mysqli_fetch_array(mysqli_query($condb,"SELECT * FROM movie WHERE movie_vid = '$v_id'"));

                ?>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">วิดีโอหลัก</a>
                        <?php

                            $backup = mysqli_query($condb,"SELECT * FROM movie_backup WHERE mb_vid = '$v_id'");

                            while($row_backup = mysqli_fetch_array($backup)){
                                ?>
                                    <a class="nav-item nav-link" id="nav-<?= $row_backup['mb_id'];?>-tab" data-toggle="tab" href="#nav-<?= $row_backup['mb_id'];?>" role="tab" aria-controls="nav-<?= $row_backup['mb_id'];?>" aria-selected="false"><?= $row_backup['mb_name'];?></a>
                                <?php
                            }
                        ?>
                        
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"><?= $row_movie['movie_iframe'];?></div>
                    <?php

                            $backup = mysqli_query($condb,"SELECT * FROM movie_backup WHERE mb_vid = '$v_id'");
                            

                            while($row2_backup = mysqli_fetch_array($backup)){
                                ?>
                                    <div class="tab-pane fade" id="nav-<?= $row2_backup['mb_id'];?>" role="tabpanel" aria-labelledby="nav-<?= $row2_backup['mb_id'];?>-tab"><?= $row2_backup['mb_iframe'];?></div>
                                <?php
                            }
                        ?>
                    
                </div>
                <!-- close iframe -->
                <br>
                <!-- open comment -->
                <div class="card" style="border:0px;">
                    <div class="card-header" style="background:#3d3d3d;color:white;border:0px;"> <i class="fas fa-comment"></i> ความคิดเห็น</div>
                    <div class="card-body" style="background:#545454;">
                        <div class="fb-comments" data-href="<?=$_SERVER['SERVER_NAME'];?><?=$_SERVER['REQUEST_URI'];?>" data-width="100%" data-numposts="10"></div>
                    </div>
                </div>
                    
                <!-- close comment -->
            </div>
            
            <div class="col-md-3">
                <div class="card" style="border:0px;">
                    <div class="card-header" style="background:#3d3d3d;color:white;border:0px;"> <i class="fas fa-info"></i> ข้อมูล</div>
                    <div class="card-body" style="background:#545454;">
                        คะแนน : <span class="imdb"> <i class="fa fa-star" ></i> <?= $row_detail['v_imdb'];?> </span>
                        <br>
                        เสียง :  <span class="badge badge-primary"> <?= $row_detail['v_type'];?> </span>
                        <br>
                        จำนวนวิว : <span class="badge badge-danger"> <?= number_format($row_detail['v_view']);?> </span>
                        <br>
                        ระยะเวลา : <span class="badge badge-dark"> <?= $row_detail['v_runtime'];?> นาที </span>
                        <br>
                        แท็ก :
                        <br>
                        <?php
                            $tags = explode(',',$row_detail['v_tags']);
                            $countleng = count($tags) - 1;
                            for($i=0;$i<=$countleng;$i++){
                                ?>
                                    <span class="badge badge-danger"> <?= $tags[$i];?> </span>
                                <?php
                            }
                        ?>
                    </div>
                </div>
                <br>
                <div class="card" style="border:0px;">
                    <div class="card-header" style="background:#3d3d3d;color:white;border:0px;"> <i class="fab fa-facebook-f"></i> แฟนเพจ</div>
                    <div class="card-body" style="background:#545454;padding:0px;">
                        <div id="fb-root"></div>
                        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v3.3&appId=153313228407799&autoLogAppEvents=1"></script>
                        <div class="fb-page" data-href="https://www.facebook.com/AnimeHQ05/" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/AnimeHQ05/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/AnimeHQ05/">Anime-HQ</a></blockquote></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ปิด  movie -->

    

    <script src="https://kit.fontawesome.com/138bb41885.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>