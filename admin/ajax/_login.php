<?php

    require('../../condb.php');

    $a_username = mysqli_real_escape_string($condb,$_POST['a_username']);
    $a_password = mysqli_real_escape_string($condb,$_POST['a_password']);

    $user = mysqli_query($condb,"SELECT * FROM admin WHERE a_username = '$a_username' AND a_password = '$a_password'");
    $num_user = mysqli_num_rows($user);

    if($num_user == 1){
        session_start();
        $row_user = mysqli_fetch_array($user);
        $_SESSION['a_id'] = $row_user['a_id'];
        ?>
            <meta http-equiv="refresh" content="3;">

            success
            <br>
        <?php
    }else{

        ?>
            error
        <?php
    }






?>