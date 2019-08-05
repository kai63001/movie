<?php

    require('../condb.php');

    $v_id = mysqli_real_escape_string($condb,$_GET['v_id']);

    $check = mysqli_num_rows(mysqli_query($condb,"SELECT * FROM report WHERE r_vid = '$v_id'"));

    if($check >= 1){
        echo "error";
    }else{
    
        $insert_report = mysqli_query($condb,"INSERT INTO report (
            r_vid
        )VALUES(
            '$v_id'
        )");
        
        if($insert_report){
            echo mysqli_error($condb);
            
        }
    }