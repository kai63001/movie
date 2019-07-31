<?php
    require('../../condb.php');
    error_reporting(0);
    $name = mysqli_real_escape_string($condb,$_GET['name']);
    $name = str_replace(' ','+',$name);
    $name = str_replace('!','',$name);
    
   
    
    $search = file_get_contents('https://xn--72czp7a9bc4b9c4e6b.com/?s='.$name.'&post_type=post');

    $check = strpos($search,'Nothing Found');

    if($check != ""){
        $name1 = explode(':',$name);
       
        $numword = strpos($name1[1],'(');
        $name1[1] = substr($name1[1],0,$numword);
        if($name1[1] == ""){
          $name_1 = explode('(',$name);
          $name1[1] = $name_1[0];
        }
        $search = file_get_contents('https://xn--72czp7a9bc4b9c4e6b.com/?s='.$name1[1].'&post_type=post');
        $check = strpos($search,'Nothing Found');
        if($check != ""){
            echo "Nothing Found";
        }else{
            $start = strpos($search,'class="col-lg-4 col-md-6 col-xs-12">');
            $search = substr($search,$start);
            $search = str_replace('class="col-lg-4 col-md-6 col-xs-12">','',$search);
            $search = str_replace('<a href="','',$search);
        
            $stop = strpos($search,'">');
            $search = substr($search,0,$stop);
            $search = trim($search);
            
        }
        

    }else{
        $start = strpos($search,'class="col-lg-4 col-md-6 col-xs-12">');
        $search = substr($search,$start);
        $search = str_replace('class="col-lg-4 col-md-6 col-xs-12">','',$search);
        $search = str_replace('<a href="','',$search);
    
        $stop = strpos($search,'">');
        $search = substr($search,0,$stop);
        $search = trim($search);

    }
    //DUMP_MOVIE
    $movie = file_get_contents($search);
    $start_cut = strpos($movie,'<iframe class="embed-responsive-item" src="https://ดูหนังใหม่.com/embed.php?url=https://xn--72czp7a9bc4b9c4e6b.com/embed%202.php?url=https://ดูหนังใหม่.com/embed3.php?url=');
    $movie = substr($movie,$start_cut);
    $movie = str_replace('<iframe class="embed-responsive-item" src="https://ดูหนังใหม่.com/embed.php?url=https://xn--72czp7a9bc4b9c4e6b.com/embed%202.php?url=https://ดูหนังใหม่.com/embed3.php?url=','',$movie);
    $stop_cut = strpos($movie,'" allowfullscreen');
    $movie = substr($movie,0,$stop_cut);
    $movie = trim($movie);
    $movie = base64_encode($movie);
    $movie = str_rot13($movie);
    $player = '<iframe height="550px" sandboxscrolling="no" frameborder="0"allowfullscreen="true" webkitallowfullscreen="true"  mozallowfullscreen="true" class="embed-responsive-item" width="100%" src="../playerone.php?url='.$movie.'" allowfullscreen></iframe>';

    // ปิด การค้นหา iframe 1

    
    $searchimovie = file_get_contents('https://www.imovie-hd.com/?s='.$name);
    $check2 = strpos($searchimovie,'Nothing Found');

    if($check2 != ""){
        $name2 = explode(':',$name);
        $numword2 = strpos($name2[1],'(');
        $name2[1] = substr($name2[1],0,$numword2);

        if($name2[1] == ""){
          $name_2 = explode('(',$name);
          $name2[1] = $name_2[0];
        }
        $searchimovie = file_get_contents('https://www.imovie-hd.com/?s='.$name2[1]);
        
        $check = strpos($search,'Nothing Found');
        if($check != ""){
            echo "Nothing Found";

        }else{

            $start = strpos($searchimovie,'class="entry-title"><a href="');
            $searchimovie = substr($searchimovie,$start);
            $searchimovie = str_replace('class="entry-title"><a href="','',$searchimovie);
            $stop = strpos($searchimovie,'"');
            $searchimovie = substr($searchimovie,0,$stop);
        }
        
    }else{
        $start = strpos($searchimovie,'class="entry-title"><a href="');
        $searchimovie = substr($searchimovie,$start);
        $searchimovie = str_replace('class="entry-title"><a href="','',$searchimovie);
        $stop = strpos($searchimovie,'"');
        $searchimovie = substr($searchimovie,0,$stop);
        $x = $name;
    }

    $movie_doo4k = file_get_contents($searchimovie);

    $start = strpos($movie_doo4k,'$.getJSON( "');
    $movie_doo4k = substr($movie_doo4k,$start);
    $movie_doo4k = str_replace('$.getJSON( "','',$movie_doo4k);
    $stop = strpos($movie_doo4k,'&bg');
    $movie_doo4k = substr($movie_doo4k,0,$stop);
    $movie_doo4k = 'https://www.imovie-hd.com'.$movie_doo4k;
    $getfilemovie = file_get_contents($movie_doo4k);
    $getfilemovie = trim($getfilemovie);

    $getfilemovie = json_decode(json_encode($getfilemovie),True);
    $getfilemovie = json_decode($getfilemovie,True);

    $encode_iframe2 = base64_encode($getfilemovie['ตัวเล่นหลัก']);
    $encode_iframe2 = str_rot13($encode_iframe2);

    $iframemovie_2 = '<iframe height="550px" sandboxscrolling="no" frameborder="0"allowfullscreen="true" webkitallowfullscreen="true"  mozallowfullscreen="true" class="embed-responsive-item" width="100%" src="../playerone.php?url='.$encode_iframe2.'" allowfullscreen></iframe>';

    $encode_iframe3 = base64_encode($getfilemovie['fembed']);
    $encode_iframe3 = str_rot13($encode_iframe3);

    $iframemovie_3 = '<iframe height="550px" sandboxscrolling="no" frameborder="0"allowfullscreen="true" webkitallowfullscreen="true"  mozallowfullscreen="true" class="embed-responsive-item" width="100%" src="../playerone.php?url='.$encode_iframe3.'" allowfullscreen></iframe>';
   
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kanit&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Searching..</title>
    <style>
        html,body{
            width:100%;
            height:100%;
            font-family: 'Fredoka One','Kanit', cursive;
        }
    </style>
</head>
<body style="color:black;">
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel"> Movie File </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <?php 
          if($movie != ""){
            ?>
              Iframe 1 : <a href="../playerone.php?url=<?= $movie;?>" target="_blank">ดูตัวอย่าง</a>
              <input type="text" class="form-control" value="<?= htmlentities($player);?>">
            <?php
          }

          if($encode_iframe2 != ""){
            ?>
              Iframe 2 : <a href="../playerone.php?url=<?= $encode_iframe2;?>" target="_blank">ดูตัวอย่าง</a>
              <input type="text" class="form-control" value="<?= htmlentities($iframemovie_2);?>">
            <?php
          }

          if($encode_iframe3 != ""){
            ?>
              Iframe 3 (Fembed) : <a href="../playerone.php?url=<?= $encode_iframe3;?>" target="_blank">ดูตัวอย่าง</a>
              <input type="text" class="form-control" value="<?= htmlentities($iframemovie_3);?>">
            <?php
          }
        ?>
       
        
        

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
    $('#myModal').modal('toggle')

</script>
</body>
</html>


   