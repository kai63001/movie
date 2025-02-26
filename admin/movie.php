<?php

    require('../condb.php');
    session_start();
    error_reporting(0);
    if(!$_SESSION['a_id']){
        header('location:login.php');
        exit();
    }
    
    $ai = mysqli_real_escape_string($condb,$_GET['ai']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie2D - ADMIN</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- <link href="https://fonts.googleapis.com/css?family=Kanit&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Concert+One&display=swap" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kanit&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <style>
        html,body{
            width:100%;
            height:100%;
            font-family: 'Fredoka One','Kanit', cursive;
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
                <h1>MOVIE</h1>
                <br>
                <?php

                    if($ai == 'TMD_ID'){
                        $id = mysqli_real_escape_string($condb,$_GET['id']);
                        $stack_url = 'https://api.themoviedb.org/3/movie/'.$id.'?api_key=88fbbabf16279d44af3e9ede3f07b357&language=TH-th';

                        $string  = curl_init($stack_url);

                        curl_setopt($string, CURLOPT_ENCODING, 'gzip');  
                        curl_setopt($string, CURLOPT_RETURNTRANSFER, 1 );

                        $result   = curl_exec($string );
                        
                        curl_close($string );

                        $response = json_decode($result, true);

                        $urk = 'http://www.omdbapi.com/?i='.$response['imdb_id'].'&apikey=fe30fffa';

                        $cur  = curl_init($urk);

                        curl_setopt($cur, CURLOPT_ENCODING, 'gzip');  
                        curl_setopt($cur, CURLOPT_RETURNTRANSFER, 1 );

                        $rs   = curl_exec($cur );
                        
                        curl_close($cur );

                        $dump = json_decode($rs, true);
                        // search YT
                        $title = $response['original_title'].' '.$response['title']. ' '.'Official Trailer';
                        
                        $title = str_replace(' ','+',$title);
                        $title = str_replace('&','+',$title);

                        $youtube = file_get_contents('https://www.youtube.com/results?search_query='.$title);

                        $start = strpos($youtube,'data-context-item-id="');
                        $youtube = substr($youtube,$start);
                        $youtube = str_replace('data-context-item-id="','',$youtube);
                        $stop = strpos($youtube,'"');
                        $youtube = substr($youtube,0,$stop);
                        // 

                        $addmovie = mysqli_real_escape_string($condb,$_POST['addmovie']);
                        $v_name = mysqli_real_escape_string($condb,$_POST['v_name']);
                        $v_detail = mysqli_real_escape_string($condb,$_POST['v_detail']);
                        $v_img = mysqli_real_escape_string($condb,$_POST['v_img']);
                        $v_imdb = mysqli_real_escape_string($condb,$_POST['v_imdb']);
                        $v_tags = mysqli_real_escape_string($condb,$_POST['v_tags']);
                        $v_trailer = mysqli_real_escape_string($condb,$_POST['v_trailer']);
                        $v_runtime = mysqli_real_escape_string($condb,$_POST['v_runtime']);
                        $v_type = mysqli_real_escape_string($condb,$_POST['v_type']);
                        $v_background = mysqli_real_escape_string($condb,$_POST['v_background']);
                        $oname = $response['original_title'];
                        if($addmovie){
                            $insert_movie = "INSERT INTO video (
                                v_name,
                                v_oname,
                                v_detail,
                                v_img,
                                v_movie,
                                v_imdb,
                                v_tags,
                                v_view,
                                v_trailer,
                                v_runtime,
                                v_type,
                                v_date
                            ) VALUES (
                                '$v_name',
                                '$oname',
                                '$v_detail',
                                '$v_img',
                                '1',
                                '$v_imdb',
                                '$v_tags',
                                '0',
                                '$v_trailer',
                                '$v_runtime',
                                '$v_type',
                                NOW()
                            )";
                            $quert_movie = mysqli_query($condb,$insert_movie);
                            $last_id = mysqli_insert_id($condb);
                            if($quert_movie){
                                header('location:movie.php?ai=addmovie&id='.$last_id);
                            }else{
                                echo "error";
                                echo mysqli_error($condb);

                            }

                        }
                        ?>
                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-md-8">
                                        ชื่อเรื่อง :
                                        <input type="text" name="v_name" class="form-control" value="<?=$response['original_title'];?> (<?=$dump['Year'];?>) <?=$response['title'];?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        ประเภท :
                                        <select name="v_type" id="" class="form-control">
                                            <option value="พากย์ไทย">พากย์ไทย</option>
                                            <option value="ซับไทย">ซับไทย</option>
                                            <option value="เสียงโรง">เสียงโรง</option>
                                        </select>
                                    </div>
                                </div>
                                เรื่องย่อ :
                                <textarea name="v_detail" id="" name="v_detail" cols="10" rows="5" class="form-control"><?=$response['overview'];?></textarea>
                                <div class="row">
                                    <div class="col-md-4">
                                        รูปปก :
                                        <input type="text" name="v_img" class="form-control" value="https://image.tmdb.org/t/p/w600_and_h900_bestv2<?=$response['poster_path'];?>">
                                    </div>
                                    <div class="col-md-4">
                                        คะแนน IMDb :
                                        <input type="text" name="v_imdb" class="form-control" value="<?=$dump['imdbRating'];?>">
                                    </div>
                                    <div class="col-md-4">
                                        แท็ก :
                                        <input type="text" name="v_tags" class="form-control" value="<?php
                                                $count = count($response['genres']);
                                                $count -= 1;
                                                for($i=0;$i<=$count;$i++){
                                                    $ttg .= $response['genres'][$i]['name'].",";
                                                    
                                                }
                                                $countttg = strlen($ttg)-1;
                                                $ttg = substr($ttg,0,$countttg);
                                                echo $ttg;
                                            ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="https://www.youtube.com/watch?v=<?= $youtube;?>" target="_blank">ตัวอย่าง</a> หนัง : 
                                        <input type="text" name="v_trailer" class="form-control" value="<?= $youtube;?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        ความยาวของหนัง (นาที) :
                                        <input type="text" name="v_runtime" class="form-control" value="<?=$response['runtime'];?>">
                                    </div>
                                </div>
                                พื้นหลัง :
                                <input type="text" class="form-control" name="v_background" value="https://image.tmdb.org/t/p/w1280<?=$response['backdrop_path'];?>">
                                <br>
                                <input type="submit" name="addmovie" class="btn btn-success" value="ADD MOVIE..">
                            </form>
                        <?php
                    }elseif($ai == 'addmovie'){
                        $id = mysqli_real_escape_string($condb,$_GET['id']);
                        $movie = mysqli_fetch_array(mysqli_query($condb,"SELECT * FROM video WHERE v_id = '$id'"));
                        $movie_iframe = mysqli_real_escape_string($condb,$_POST['movie_iframe']);
                        if($movie_iframe){
                            $insert_moviedb = "INSERT INTO movie (
                                movie_iframe,
                                movie_vid
                            ) VALUES (
                                '$movie_iframe',
                                '$id'
                            )";
                            $quert_db = mysqli_query($condb,$insert_moviedb);
                            if($quert_db){
                                header('location:movie.php?ai=successaddmovie&v_id='.$id.'');
                            }else{
                                echo "not";
                                echo mysqli_error($condb);
                            }
                        }
                        $name_convert = str_replace(' ','+',$movie['v_name']);
                        $name_convert = str_replace('&','',$name_convert);
                        ?>
                            เพิ่มหนั้ง เรื่อง : <?= $movie['v_name'];?>
                            <br>
                            <form action="" method="POST">
                                Iframe :
                                <br>
                                <textarea name="movie_iframe" id="" cols="10" rows="5" class="form-control"></textarea>
                                <br>
                                <input type="submit" class="btn btn-success" value="ADD MOVIE..">
                                
                            </form>
                            <br>
                            <button class="btn btn-danger" id="searchmovie"> Search file movie..[BETA] </button>
                            <span id="dumpsearch" style="color:black;"></span>
                            <script>
                                $('#searchmovie').click(function(){
                                    $('#searchmovie').text('กำลังค้นหา..');
                                    var SearchXML = new XMLHttpRequest();
                                    SearchXML.open('POST','system/search.php?name=<?=$name_convert;?>');
                                    SearchXML.send();
                                    SearchXML.onreadystatechange = function(){
                                        if(SearchXML.readyState == 4){
                                            $('#dumpsearch').html(this.responseText);
                                            $('#searchmovie').text('Search file movie..[BETA]');

                                        }
                                    };
                                });
                            </script>
                        <?php
                    }elseif($ai == 'successaddmovie'){
                        $v_id = mysqli_real_escape_string($condb,$_GET['v_id']);

                        $movie = mysqli_fetch_array(mysqli_query($condb,"SELECT * FROM video WHERE v_id = '$v_id'"));
                        ?>
                            <div class="box" style="padding:15px;background:#e0e0e0;color:#363636;border-radius:3px;">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img src="<?= $movie['v_img'];?>" width="100%" alt="">
                                    </div>
                                    <div class="col-md-9">
                                        <h4><?= $movie['v_name'];?></h4>
                                        <?= substr($movie['v_detail'],0,800);?>
                                        <br>
                                        <br>
                                        <a href="movie.php" class="btn btn-info">เพิ่มหนังใหม่</a>
                                        <a href="movie.php?ai=addbackup&v_id=<?= $v_id;?>" class="btn btn-primary">เพิ่มตอนสำรอง</a>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }elseif($ai == 'addbackup'){
                        $v_id = mysqli_real_escape_string($condb,$_GET['v_id']);

                        $movie = mysqli_fetch_array(mysqli_query($condb,"SELECT * FROM video WHERE v_id = '$v_id'"));

                        $name_convert = str_replace(' ','+',$movie['v_name']);
                        $name_convert = str_replace('&','',$name_convert);
                        
                        $mb_name = mysqli_real_escape_string($condb,$_POST['mb_name']);
                        $mb_iframe = mysqli_real_escape_string($condb,$_POST['mb_iframe']);

                        if($mb_iframe){
                            if($mb_name == ""){
                                $mb_name = "สำรอง";
                            }
                            $insert_backup = "INSERT INTO movie_backup (
                                mb_name,
                                mb_iframe,
                                mb_vid
                            ) VALUES (
                                '$mb_name',
                                '$mb_iframe',
                                '$v_id'
                            )";
                            $query_backup = mysqli_query($condb,$insert_backup);
                            if($insert_backup){
                                header('location:movie.php?ai=successaddmovie&v_id='.$v_id);
                            }else{
                                echo "error";
                            }
                        }

                        ?>
                            <div class="box" style="padding:15px;background:#e0e0e0;color:#363636;border-radius:3px;">
                                BACKUP : <?= $movie['v_name'];?>
                                <br>
                                <form action="" method="POST">
                                    ชื่อ ไฟล์ :
                                    <input type="text" name="mb_name" class="form-control" placeholder="สำรอง">
                                    Iframe :
                                    <textarea name="mb_iframe" id="" cols="10" rows="5" class="form-control" required></textarea>
                                    <br>
                                    <input type="submit" class="btn btn-success" value="ADD BACKUP">
                                    <br>
                                </form>
                                <br>
                                <button class="btn btn-danger" id="searchmovie"> Search file movie..[BETA] </button>
                                <span id="dumpsearch" style="color:black;"></span>
                                <script>
                                    $('#searchmovie').click(function(){
                                        $('#searchmovie').text('กำลังค้นหา..');
                                        var SearchXML = new XMLHttpRequest();
                                        SearchXML.open('POST','system/search.php?name=<?=$name_convert;?>');
                                        SearchXML.send();
                                        SearchXML.onreadystatechange = function(){
                                            if(SearchXML.readyState == 4){
                                                $('#dumpsearch').html(this.responseText);
                                                $('#searchmovie').text('Search file movie..[BETA]');

                                            }
                                        };
                                    });
                                </script>
                            </div>
                        <?php

                    }elseif($ai == "addbyname"){
                        $name = mysqli_real_escape_string($condb,$_GET['name']);
                        $bracket = $name;
                        $bracket_start = strpos($name,'(');
                        $bracket = substr($bracket,$bracket_start);
                        $bracket_stop = strpos($name,')');
                        $bracket = substr($bracket,0,$bracket_stop);

                        $name = str_replace($bracket,'',$name);

                        $find_name = str_replace(' ','+',$name);
                        $find_movie = file_get_contents('https://www.themoviedb.org/search?query='.$find_name.'&language=th-TH');

                        $start = strpos($find_movie,'class="title result" href="/movie/');
                        $find_movie = substr($find_movie,$start);
                        $find_movie = str_replace('class="title result" href="/movie/','',$find_movie);
                        $stop = strpos($find_movie,'?');
                        $find_movie = substr($find_movie,0,$stop);

                        $stack_url = 'https://api.themoviedb.org/3/movie/'.$find_movie.'?api_key=88fbbabf16279d44af3e9ede3f07b357&language=TH-th';

                        $string  = curl_init($stack_url);

                        curl_setopt($string, CURLOPT_ENCODING, 'gzip');  
                        curl_setopt($string, CURLOPT_RETURNTRANSFER, 1 );

                        $result   = curl_exec($string );
                        
                        curl_close($string );

                        $response = json_decode($result, true);

                        $urk = 'http://www.omdbapi.com/?i='.$response['imdb_id'].'&apikey=fe30fffa';

                        $cur  = curl_init($urk);

                        curl_setopt($cur, CURLOPT_ENCODING, 'gzip');  
                        curl_setopt($cur, CURLOPT_RETURNTRANSFER, 1 );

                        $rs   = curl_exec($cur );
                        
                        curl_close($cur );

                        $dump = json_decode($rs, true);
                        // search YT
                        $title = $response['original_title'].' '.$response['title']. ' '.'Official Trailer';
                        
                        $title = str_replace(' ','+',$title);
                        $title = str_replace('&','+',$title);

                        $youtube = file_get_contents('https://www.youtube.com/results?search_query='.$title);

                        $start = strpos($youtube,'data-context-item-id="');
                        $youtube = substr($youtube,$start);
                        $youtube = str_replace('data-context-item-id="','',$youtube);
                        $stop = strpos($youtube,'"');
                        $youtube = substr($youtube,0,$stop);

                        //
                        $addmovie = mysqli_real_escape_string($condb,$_POST['addmovie']);
                        $v_name = mysqli_real_escape_string($condb,$_POST['v_name']);
                        $v_detail = mysqli_real_escape_string($condb,$_POST['v_detail']);
                        $v_img = mysqli_real_escape_string($condb,$_POST['v_img']);
                        $v_imdb = mysqli_real_escape_string($condb,$_POST['v_imdb']);
                        $v_tags = mysqli_real_escape_string($condb,$_POST['v_tags']);
                        $v_trailer = mysqli_real_escape_string($condb,$_POST['v_trailer']);
                        $v_runtime = mysqli_real_escape_string($condb,$_POST['v_runtime']);
                        $v_type = mysqli_real_escape_string($condb,$_POST['v_type']);
                        $v_background = mysqli_real_escape_string($condb,$_POST['v_background']);
                        $oname = $response['original_title'];
                        if($addmovie){
                            $insert_movie = "INSERT INTO video (
                                v_name,
                                v_oname,
                                v_detail,
                                v_img,
                                v_background,
                                v_movie,
                                v_imdb,
                                v_tags,
                                v_view,
                                v_trailer,
                                v_runtime,
                                v_type,
                                v_date
                            ) VALUES (
                                '$v_name',
                                '$oname',
                                '$v_detail',
                                '$v_img',
                                '$v_background',
                                '1',
                                '$v_imdb',
                                '$v_tags',
                                '1',
                                '$v_trailer',
                                '$v_runtime',
                                '$v_type',
                                NOW()
                            )";
                            $quert_movie = mysqli_query($condb,$insert_movie);
                            $last_id = mysqli_insert_id($condb);
                            if($quert_movie){
                                header('location:movie.php?ai=addmovie&id='.$last_id);
                            }else{
                                echo "error";
                                echo mysqli_error($condb);

                            }
                        }
                        ?>
                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-md-8">
                                        ชื่อเรื่อง :
                                        <input type="text" name="v_name" class="form-control" value="<?=$response['original_title'];?> (<?=$dump['Year'];?>) <?=$response['title'];?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        ประเภท :
                                        <select name="v_type" id="" class="form-control">
                                            <option value="พากย์ไทย">พากย์ไทย</option>
                                            <option value="ซับไทย">ซับไทย</option>
                                            <option value="เสียงโรง">เสียงโรง</option>
                                        </select>
                                    </div>
                                </div>
                                เรื่องย่อ :
                                <textarea name="v_detail" id="" name="v_detail" cols="10" rows="5" class="form-control"><?=$response['overview'];?></textarea>
                                <div class="row">
                                    <div class="col-md-4">
                                        รูปปก :
                                        <input type="text" name="v_img" class="form-control" value="https://image.tmdb.org/t/p/w600_and_h900_bestv2<?=$response['poster_path'];?>">
                                    </div>
                                    <div class="col-md-4">
                                        คะแนน IMDb :
                                        <input type="text" name="v_imdb" class="form-control" value="<?=$dump['imdbRating'];?>">
                                    </div>
                                    <div class="col-md-4">
                                        แท็ก :
                                        <input type="text" name="v_tags" class="form-control" value="<?php
                                                $count = count($response['genres']);
                                                $count -= 1;
                                                for($i=0;$i<=$count;$i++){
                                                    $ttg .= $response['genres'][$i]['name'].",";
                                                    
                                                }
                                                $countttg = strlen($ttg)-1;
                                                $ttg = substr($ttg,0,$countttg);
                                                echo $ttg;
                                            ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="https://www.youtube.com/watch?v=<?= $youtube;?>" target="_blank">ตัวอย่าง</a> หนัง : 
                                        <input type="text" name="v_trailer" class="form-control" value="<?= $youtube;?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        ความยาวของหนัง (นาที) :
                                        <input type="text" name="v_runtime" class="form-control" value="<?=$response['runtime'];?>">
                                    </div>
                                </div>
                                พื้นหลัง :
                                <input type="text" class="form-control" name="v_background" value="https://image.tmdb.org/t/p/w1280<?=$response['backdrop_path'];?>">
                                <br>
                                <input type="submit" name="addmovie" class="btn btn-success" value="ADD MOVIE..">
                            </form>
                        <?php
                        
                    }elseif($ai == 'edit'){
                        $v_id = mysqli_real_escape_string($condb,$_GET['v_id']);

                        $row_video = mysqli_fetch_array(mysqli_query($condb,"SELECT * FROM video WHERE v_id = '$v_id'"));

                        $editmovie = mysqli_real_escape_string($condb,$_POST['editmovie']);
                        $v_name = mysqli_real_escape_string($condb,$_POST['v_name']);
                        $v_detail = mysqli_real_escape_string($condb,$_POST['v_detail']);
                        $v_img = mysqli_real_escape_string($condb,$_POST['v_img']);
                        $v_imdb = mysqli_real_escape_string($condb,$_POST['v_imdb']);
                        $v_tags = mysqli_real_escape_string($condb,$_POST['v_tags']);
                        $v_trailer = mysqli_real_escape_string($condb,$_POST['v_trailer']);
                        $v_runtime = mysqli_real_escape_string($condb,$_POST['v_runtime']);
                        $v_type = mysqli_real_escape_string($condb,$_POST['v_type']);

                        if($editmovie){
                            $update_video = mysqli_query($condb,"UPDATE video SET 
                                v_name = '$v_name',
                                v_detail = '$v_detail',
                                v_img = '$v_img',
                                v_imdb = '$v_imdb',
                                v_tags = '$v_tags',
                                v_trailer = '$v_trailer',
                                v_runtime = '$v_runtime',
                                v_type = '$v_type',
                                v_date = NOW() WHERE v_id = '$v_id'
                            ");
                            $_SESSION['success'] = 'success';
                            header('location:movie.php');
                        }
                        ?>
                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-md-8">
                                        ชื่อเรื่อง :
                                        <input type="text" name="v_name" class="form-control" value="<?=$row_video['v_name'];?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        ประเภท :
                                        <select name="v_type" id="" class="form-control">
                                            <option value="พากย์ไทย">พากย์ไทย</option>
                                            <option value="ซับไทย">ซับไทย</option>
                                            <option value="เสียงโรง">เสียงโรง</option>
                                        </select>
                                    </div>
                                </div>
                                เรื่องย่อ :
                                <textarea name="v_detail" id="" name="v_detail" cols="10" rows="5" class="form-control"><?=$row_video['v_detail'];?></textarea>
                                <div class="row">
                                    <div class="col-md-4">
                                        รูปปก :
                                        <input type="text" name="v_img" class="form-control" value="<?=$row_video['v_img'];?>">
                                    </div>
                                    <div class="col-md-4">
                                        คะแนน IMDb :
                                        <input type="text" name="v_imdb" class="form-control" value="<?=$row_video['v_imdb'];?>">
                                    </div>
                                    <div class="col-md-4">
                                        แท็ก :
                                        <input type="text" name="v_tags" class="form-control" value="<?php
                                               echo $row_video['v_tags'];
                                            ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="https://www.youtube.com/watch?v=<?= $row_video['v_trailer'];?>" target="_blank">ตัวอย่าง</a> หนัง : 
                                        <input type="text" name="v_trailer" class="form-control" value="<?= $row_video['v_trailer'];?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        ความยาวของหนัง (นาที) :
                                        <input type="text" name="v_runtime" class="form-control" value="<?=$row_video['v_runtime'];?>">
                                    </div>
                                </div>
                                <br>
                                <input type="submit" name="editmovie" class="btn btn-success" value="EDIT MOVIE..">
                                <a href="movie.php?ai=editiframe&v_id=<?=$row_video['v_id'];?>" style="float:right;" class="btn btn-danger"> EDIT IFRAME.. </a>
                            </form>
                        <?php
                        
                    }elseif($ai == 'editiframe'){
                        $v_id = mysqli_real_escape_string($condb,$_GET['v_id']);

                        $row_iframe1 = mysqli_fetch_array(mysqli_query($condb,"SELECT * FROM movie WHERE movie_vid = '$v_id'"));
                        $movie_iframe = mysqli_real_escape_string($condb,$_POST['movie_iframe']);

                        if($movie_iframe){
                            $update_iframe1 = mysqli_query($condb,"UPDATE movie SET movie_iframe = '$movie_iframe' WHERE movie_vid = '$v_id'");
                            $delete_report = mysqli_query($condb,"DELETE FROM report WHERE r_vid = '$v_id'");
                            $_SESSION['success'] = 'success';
                            header('location:movie.php');
                        }
                        ?>
                            <form action="" method="POST">
                                Iframe 1 :
                                <br/>
                                <textarea name="movie_iframe" id="" cols="30" rows="5" class="form-control"><?=$row_iframe1['movie_iframe'];?></textarea>
                                <br/>
                                <input type="submit" class="btn btn-success" value="Edit..">
                            </form><br/>
                            <button id="showbackup" class="btn btn-primary"> Show Backup Movie </button>
                            <br>
                            <div id="backup">
                            <br>
                                <div class="row">
                                    <?php
                                        $backupmovie = mysqli_query($condb,"SELECT * FROM movie_backup WHERE mb_vid = '$v_id'");
                                        while($row_backupmovie = mysqli_fetch_array($backupmovie)){
                                            ?> 

                                                <div class="col-md-3">
                                                    <a href="movie.php?ai=editiframebackup&mb_id=<?=$row_backupmovie['mb_id'];?>" style="text-decoration:none;color:white;">
                                                        <div style="background:#0c053b;border-radius:3px;padding:25px;"><center><?= $row_backupmovie['mb_name'];?></center></div>
                                                    </a>
                                                </div>
                                                
                                            <?php
                                        }

                                    ?>
                                </div>
                            </div>
                            <script>
                                $('#backup').hide();
                                $('#showbackup').click(function(){
                                    $('#backup').toggle('slow');
                                });
                            </script>
                        <?php
                        
                    }elseif($ai == 'editiframebackup'){
                        $mb_id = mysqli_real_escape_string($condb,$_GET['mb_id']);
                        $movie_backup = mysqli_fetch_array(mysqli_query($condb,"SELECT * FROM movie_backup WHERE mb_id = '$mb_id'"));
                    
                        $mb_name = mysqli_real_escape_string($condb,$_POST['mb_name']);
                        $mb_iframe = mysqli_real_escape_string($condb,$_POST['mb_iframe']);

                        if($mb_iframe){
                            $edit_backup = mysqli_query($condb,"UPDATE movie_backup SET mb_name = '$mb_name', mb_iframe = '$mb_iframe' WHERE mb_id = '$mb_id'");
                            $_SESSION['success'] = 'success';
                            header('location:movie.php');
                        }
                        ?>
                            <form action="" method="POST">
                                Name : 
                                <input type="text" name="mb_name" class="form-control" id="" value="<?= $movie_backup['mb_name'];?>">
                                Iframe :
                                <textarea name="mb_iframe" id="" cols="30" rows="5" class="form-control"><?= $movie_backup['mb_iframe'];?></textarea>
                                <br>
                                <input type="submit" class="btn btn-success" value="Edit..">
                            </form>
                        <?php
                    }else{
                        if($_SESSION['success']){
                            ?>
                                <script>
                                    Swal.fire(
                                        'Success',
                                        'Update Success',
                                        'success'
                                    )
                                </script>
                            <?php
                        }unset($_SESSION['success']);
                        ?>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="box" style="padding:15px;background:white;color:#363636;border-radius:3px;">
                                        Name Movie :
                                        <br><br>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Ex. ROBIN HOOD (2018) พยัคฆ์ร้ายโรบินฮู้ด">
                                        <br>
                                        <button id="namemovie" class="btn btn-primary"> Start.. </button>
                                        <script>
                                            $('#namemovie').click(function(){
                                                namemovie = $('#name').val();
                                                window.location.assign('movie.php?ai=addbyname&name='+namemovie);
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box" style="padding:15px;background:white;color:#363636;border-radius:3px;">
                                        <a href="https://www.themoviedb.org/movie" target="_blank">> TMD_ID :</a>
                                        <br><br>
                                        <input type="text" name="TMD_ID" id="TMD_ID" class="form-control" placeholder="Ex. 447404" required>
                                        <br>
                                        <button id="start" class="btn btn-danger"> Start.. </button>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="box" style="padding:15px;background:white;color:#363636;border-radius:3px;">
                                <h1>New Movie</h1>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control namemovie" name="namemovie" id="namemovie" placeholder="ชื่อหนัง...">
                                    </div>
                                </div>
                                <hr>
                                    <span id="listmovie"></span>
                                    <span id="listmovie2"></span>

                                    <script>
                                    $(document).ready(function(){
                                        $("input.namemovie").keyup(function(){
                                                var that = this,
                                                value = $(this).val();
                                                $('#listmovie2').hide();
                                                var XMLListMoive = new XMLHttpRequest();
                                                XMLListMoive.open('POST','ajax/_list_movie.php?namemovie='+value,true);
                                                XMLListMoive.send();
                                                XMLListMoive.onreadystatechange = function(){
                                                    if(XMLListMoive.readyState == 4){
                                                        $('#listmovie').html(this.responseText);
                                                    }
                                                };
                                        });
                                    });
                                    var XMLMovie = new XMLHttpRequest();
                                    XMLMovie.open('POST','ajax/_list_movie.php',true);
                                    XMLMovie.send();
                                    XMLMovie.onreadystatechange = function(){
                                        if(XMLMovie.readyState == 4){
                                            $('#listmovie2').html(this.responseText);
                                        }
                                    };
                                     
                                        
                                    </script>
                            </div>   
                            <br>                         
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
    
    <script src="https://kit.fontawesome.com/138bb41885.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        $('#start').click(function(){
            tmd_id = $('#TMD_ID').val();
            window.location.assign('movie.php?ai=TMD_ID&id='+tmd_id);
        });
    </script>
</body>
</html>