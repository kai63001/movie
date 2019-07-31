<?php

    require('../../condb.php');

    $name = mysqli_real_escape_string($condb,$_GET['name']);
    $name = str_replace(' ','+',$name);

    // $regex2 = '/[a-z\ ]/';
    // $data_eng2 = preg_replace($regex2, '', $name);
    // $data_expert2 = mb_strimwidth($data_eng2,0,250,"", "UTF-8");
    
    $searchimovie = file_get_contents('https://www.imovie-hd.com/?s='.$name);
    $check2 = strpos($searchimovie,'Nothing Found');

    if($check2 != ""){
        $name2 = explode(':',$name);
        $search = file_get_contents('https://www.imovie-hd.com/?s='.$name2[1]);
        $check = strpos($search,'Nothing Found');
        if($check != ""){
            echo "Nothing Found";
        }else{
            $start = strpos($searchimovie,'class="entry-title"><a href="');
            $searchimovie = substr($searchimovie,$start);
            $searchimovie = str_replace('class="entry-title"><a href="','',$searchimovie);
            $stop = strpos($searchimovie,'"');
            $searchimovie = substr($searchimovie,0,$stop);
            echo "success";
        }
    }else{
            $start = strpos($searchimovie,'class="entry-title"><a href="');
            $searchimovie = substr($searchimovie,$start);
            $searchimovie = str_replace('class="entry-title"><a href="','',$searchimovie);
            $stop = strpos($searchimovie,'"');
            $searchimovie = substr($searchimovie,0,$stop);
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

    echo $getfilemovie['ตัวเล่นหลัก'];

?>