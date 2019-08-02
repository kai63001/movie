<?php

    require('condb.php');

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie2D</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
            position: absolute;
            top: 5px;
            left: 25px;
            background: #4a4a4a;
            padding-left:5px;
            padding-right:5px;
            font-size:10px;
            border-radius:5px;
            color:#FFD700;
        }
        .type {
            position: absolute;
            top: 25px;
            left: 25px;
            background: #4a4a4a;
            padding-left:5px;
            padding-right:5px;
            font-size:10px;
            border-radius:5px;
            color:#ff7817;
        }
    </style>
</head>
<body>
    <div class="content">
        <h1 style="font-family: 'Concert One', cursive;"><b>MOVIE<font color="#ff3838">2D</font></b></h1>
    </div>
    <?php include('include/navbar.php');?>

    <br>
    <div class="content">
        <div class="row" id="realmovie">
            <!--inside movie -->
        </div>
        <br/>
        <?php
            $count_video = mysqli_num_rows(mysqli_query($condb,"SELECT * FROM video"));
            if($count_video > 24){
                ?>
                    <button class="btn btn-outline-danger btn-block" id="loadmore"> Load More.. </button>
                <?php
            }
        ?>
    </div>
    <!-- ปิด list movie -->
        
    <script>
        num = 1;
       
        setInterval("movie()",2000);
        
        function movie(){
            $('#loadmore').click(function(){
                num += 1;
            });
            var XMLMovie = new XMLHttpRequest();
            XMLMovie.open('POST','realtime/movie_index.php?num='+num,true);
            XMLMovie.send();
            XMLMovie.onreadystatechange = function(){
                if(XMLMovie.readyState ==  3){
                    $('#realmovie').html(this.responseText);
                }
                if(XMLMovie.readyState ==  4){
                    $('#realmovie').html(this.responseText);
                }
            }
        }
    </script>
    <?php include('include/footer.php');?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>