<?php if(!defined('ADMIN_APP_PATH')) exit('Can not access'); ?>
<!-- khong duoc phep truy cap truc tiep vao file view -->
<div class="container-fluid">
    <div class="row">
        <?php  if(isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-danger" role="alert">
                <?=  $_SESSION['flash_message'] ?>
            </div>
            <?php  unset($_SESSION['flash_message']) ?>
        <?php  endif ?>
        <br>
        <div class="col">
            <h3> Not found data !</h3>
        </div>
    </div>
</div>