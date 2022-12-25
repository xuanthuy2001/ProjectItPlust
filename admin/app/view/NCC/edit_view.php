<?php if(!defined('ADMIN_APP_PATH')) exit('Can not access'); ?>
<!-- khong duoc phep truy cap truc tiep vao file view -->
<form method="post" action="<?=  route('nha_cung_cap','update') ?>" enctype="multipart/form-data">
    <?php  if(isset($_SESSION["flash_message"])): ?>
         <div class="alert alert-danger" role="alert">
            <?=  $_SESSION['flash_message'] ?>
        </div>
        <?php  unset($_SESSION['flash_message']) ?>
    <?php  endif; ?>
    
    <?php if(!empty($messagesError)): ?>
                <ul>
                    <?php foreach($messagesError as $err): ?>
                        <?php if(!empty($err)): ?>
                            <li class="text-danger"><?= $err; ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>   
    <div class="row">
        <input value="<?=  $data["id"] ?>" name="id" type="hidden" class="form-control" id="customFile" />
        <div class="col-md-4">
            <img style="width: 100%;" src="<?=  PATH_UPLOAD_BRAND_LOGO.$data["image"] ?>" alt="">
            <input name="logo" type="file" class="form-control" id="customFile" />
        </div>
        <div class="col-md-8">
        <fieldset >
            <div class="form-group">
                <label>Tên</label>
                <input name="name" type="text" class="form-control" value="<?=  $data["name"] ?>">
            </div>
            <div class="form-group">
                <label>Địa chỉ</label>
                <input name="address" type="text" class="form-control" value="<?=  $data["address"] ?>">
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Email Liên hệ</label>
                        <input name="email" type="text" class="form-control" value="<?=  $data["email"] ?>">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>trang web</label>
                        <input name="url"  type="text" class="form-control" value="<?=  $data["url"] ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>tel</label>
                <input name="tel" type="text" class="form-control" value="<?=  $data["tel"] ?>">
            </div>
            <div class="form-group">
                <label>hotline</label>
                <input name="hotline" type="text" class="form-control" value="<?=  $data["hotline"] ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="btn-submit" > Sửa</button>
        </fieldset>
        </div>
    </div>
</form>