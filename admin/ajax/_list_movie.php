<?php

    require('../../condb.php');
    session_start();
    error_reporting(0);
    if(!$_SESSION['a_id']){
        header('location:../login.php');
        exit();
    }
    $namemovie = mysqli_real_escape_string($condb,$_GET['namemovie']);


    ?>
    <div class="row">
    <?php

            $new_movie = mysqli_query($condb,"SELECT * FROM video WHERE v_name LIKE '%".$namemovie."%' ORDER BY v_date DESC LIMIT 7");
            while($row_new = mysqli_fetch_array($new_movie)){
                ?>
                    <div class="col-md-2" style="margin-bottom:15px;"><img src="<?= $row_new['v_img'];?>" width="100%" loading="lazy" height="200px" alt=""></div>
                    <div class="col-md-8" style="margin-bottom:15px;">
                        <b><?= $row_new['v_name'];?></b>
                        <br/>
                        <?= substr($row_new['v_detail'],0,800);?>
                    </div>
                    <div class="col-md-2" style="margin-bottom:15px;">
                        <a class="btn btn-success" href="movie.php?ai=edit&v_id=<?= $row_new['v_id'];?>" style="text-decoration:none;color:white;"> <i class="fas fa-edit"></i> </a>
                        <button class="btn btn-danger" id="delete-<?=$row_new['v_id'];?>"> <i class="far fa-trash-alt"></i> </button>
                        <script>
                            $('#delete-<?=$row_new['v_id'];?>').click(function(){
                                Swal.fire({
                                title: 'แน่ใจหลอ',
                                text: "คุณแน่ในที่จะลบหลังเรื่องนี้",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'ลบเลย',
                                cancelButtonText: 'ยังก่อน'

                                }).then((result) => {
                                    
                                    if (result.value) {
                                        var XMLDelete = new XMLHttpRequest();
                                        XMLDelete.open('POST','system/delete_movie.php?v_id=<?=$row_new['v_id'];?>',true);
                                        XMLDelete.send();
                                        Swal.fire(
                                            
                                        'ลบแล้ว!',
                                        'ไฟล์หลังของคุณได้ถูกลบลงแล้ว',
                                        'success'
                                        )
                                        
                                    }
                                    
                                    
                                })
                            });
                        </script>
                    </div>
                    
                <?php
            }

        ?></div>