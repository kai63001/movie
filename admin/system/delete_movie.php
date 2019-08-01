<?php

    require('../../condb.php');

    $v_id = mysqli_real_escape_string($condb,$_GET['v_id']);

    $delete_movie = mysqli_query($condb,"DELETE FROM video WHERE v_id = '$v_id'");

?>