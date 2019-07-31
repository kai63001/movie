<?php

    $youtube = file_get_contents('https://www.youtube.com/results?search_query=Pok%C3%A9mon+Detective+Pikachu+%E0%B9%82%E0%B8%9B%E0%B9%80%E0%B8%81%E0%B8%A1%E0%B8%AD%E0%B8%99+%E0%B8%A2%E0%B8%AD%E0%B8%94%E0%B8%99%E0%B8%B1%E0%B8%81%E0%B8%AA%E0%B8%B7%E0%B8%9A+%E0%B8%9E%E0%B8%B4%E0%B8%84%E0%B8%B2%E0%B8%8A%E0%B8%B9');

    $start = strpos($youtube,'data-context-item-id="');
    $youtube = substr($youtube,$start);
    $youtube = str_replace('data-context-item-id="','',$youtube);
    $stop = strpos($youtube,'"');
    $youtube = substr($youtube,0,$stop);

    echo $youtube;


?>