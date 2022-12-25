<?php if(!defined('ADMIN_APP_PATH')) exit('Can not access'); ?>
<!-- khong duoc phep truy cap truc tiep vao file view -->
<form>
    <div class="row">
        <div class="col-md-4">
            <img style="width: 100%;" src="<?=  PATH_UPLOAD_BRAND_LOGO.$data["image"] ?>" alt="">
        </div>
        <div class="col-md-8">
        <fieldset disabled>
            <div class="form-group">
                <label>Tên</label>
                <input type="text" class="form-control" value="<?=  $data["name"] ?>">
            </div>
            <div class="form-group">
                <label>Địa chỉ</label>
                <input type="text" class="form-control" value="<?=  $data["address"] ?>">
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Email Liên hệ</label>
                        <input type="text" class="form-control" value="<?=  $data["email"] ?>">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>trang web</label>
                        <a class="form-control" href="<?=  $data['url'] ?>">
                            <?=  $data["url"] ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>tel</label>
                <input type="text" class="form-control" value="<?=  $data["tel"] ?>">
            </div>
            <div class="form-group">
                <label>hotline</label>
                <input type="text" class="form-control" value="<?=  $data["hotline"] ?>">
            </div>
            <div class="form-group">
                <label>trạng thái</label>
                <input type="text" class="form-control" value="<?=  $data["status"] == ACTIVE_STATUS ? LABLE_ACTIVE_STATUS : LABLE_DEACTIVE_STATUS ?>">
            </div>
           <div class="row">
            <div class="col-4">
                    <div class="form-group">
                        <label>ngày thêm</label>
                        <input type="text" class="form-control" value="<?=  $data["created_at"] ?>">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>ngày sửa</label>
                        <input type="text" class="form-control" value="<?=  $data["updated_at"] ?>">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>ngày xóa</label>
                        <input type="text" class="form-control" value="<?=  $data["deleted_at"] ?>">
                    </div>
                </div>
           </div>
        </fieldset>
        </div>
    </div>
</form>