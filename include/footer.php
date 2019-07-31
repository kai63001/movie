<footer style="background:#383838;padding:15px;">
    <div class="row">
        <div class="col-md-4">
            <h1 style="font-family: 'Concert One', cursive;font-size:72px;"><b>MOVIE<font color="#ff3838">2D</font></b></h1>
            แหลงรวมหนังคุณภาพดี
            
            
        </div>
        <div class="col-md-4">
            <a href="" style="color:white;">หนังทั้งหมด</a> 
            <a href="" style="color:white;">ขอหนัง</a> 
            <a href="" style="color:white;">หนังที่มีคนดูเยอะที่สุด</a> 
            <a href="" style="color:white;">ติดต่อเรา</a>
        </div>
        <div class="col-md-4">
            <?php
                $get_tags = mysqli_query($condb,"SELECT * FROM tags");
                while($row_tags = mysqli_fetch_array($get_tags)){
                    ?>
                         <a href=""><span class="badge badge-light"><?= $row_tags['t_name'];?></span></a>
                    <?php
                }

            ?>
        </div>
    </div>
</footer>