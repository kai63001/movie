<?php

    require('../condb.php');

    $movie = mysqli_query($condb,"SELECT * FROM video ORDER BY v_date DESC LIMIT 24 ");

    while($row_movie = mysqli_fetch_array($movie)){
        ?>
            <div class="col-md-2 col-sm-4 col-6" style="margin-bottom:15px;">
                <a href="<?= $row_movie['v_id'];?>/<?= str_replace(' ','-',$row_movie['v_name']); ?>" style="text-decoration:none;color:white;">
                    <div class="movie"> 
                        <img src="<?= $row_movie['v_img'];?>" width="100%" height="250px" loading="lazy" alt="">
                        <p style=""><?= $row_movie['v_name'];?></p>
                        <p style="margin-top:-16px;color:#e3e3e3;"><?= $row_movie['v_tags'];?></p>
                        <span class="imdb"> <i class="fa fa-star" ></i> <?= $row_movie['v_imdb'];?> </span>
                    </div>
                </a>
            </div>
        <?php
    }
?>