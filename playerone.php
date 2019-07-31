<?php
    $url = $_GET['url'];
    $url = str_rot13($url);
    $url = base64_decode($url);
    $file = file_get_contents_curl('https://xn--72czp7a9bc4b9c4e6b.com/embed3.php?url='.$url);

    $file = str_replace('http://bit.ly/Doo-vdo-macau','http://google.com',$file);
    $file = str_replace('var timeleft = 10;','var timeleft = 0;',$file);

    $file = str_replace('<script src="/asset/default/player/base.js?v=1563386997"></script>','',$file);

    $cut = $file;
    $start = strpos($cut,'<div id=\'adsclick\'></div>');
    $cut = substr($cut,$start);
    $stop = strpos($cut,'</script>');
    $cut = substr($cut,0,$stop);
    
    $file = str_replace($cut,'',$file);

    $file = str_replace('$(\'#playervideo\').hide(); ','',$file);


    $file = str_replace('<div class="skipads" id="skipads">','',$file);
    $file = str_replace('<span id="timeer">กรุณารอ 5 วิ</span></div>','',$file);
    $file = str_replace('<title>ดูหนังใหม่.COM</title>','<title> ROMEO - PLAYER </title>',$file);

    echo $file;

    function file_get_contents_curl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt_array($ch,array(
            CURLOPT_USERAGENT=>'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0',
            CURLOPT_ENCODING=>'gzip, deflate',
            CURLOPT_HTTPHEADER=>array(
                    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language: en-US,en;q=0.5',
                    'Connection: keep-alive',
                    'Upgrade-Insecure-Requests: 1',
            ),
        ));
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    

?>