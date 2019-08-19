<?php


    $s = curlimovie('https://www.mio-anime.com/player/bXFtbG9xaHJZV1NvcWF4Zm1KcWVsSnFWWUppZ24yU25ZV2FwYTZaaW8yWmVxcVJs');
    $start_cut = strpos($s,'fembed.php?hash=');
    $s = substr($s,$start_cut);
    $s = str_replace('fembed.php?hash=','',$s);
    $stop_cut = strpos($s,'\"');
    $s = substr($s,0,$stop_cut);
    echo $s;   
    

    function curlimovie($url) {
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, 'https://www.mio-anime.com/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        header('Content-Type: text/html; charset=UTF-8');
        header("Access-Control-Allow-Origin: *");
        $data = curl_exec($ch); 
        curl_close($ch); 
        return $data;   
    }
?>