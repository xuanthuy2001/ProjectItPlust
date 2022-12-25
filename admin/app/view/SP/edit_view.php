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
            <img style="width: 100%;" src="<?=  PATH_UPLOAD_PRODUCT.$data["image"] ?>" alt="">
            <input name="logo" type="file" class="form-control" id="customFile" />
        </div>
        <div class="col-md-8">
        <fieldset >
            <div class="form-group">
                <label>Tên</label>
                <input name="name" type="text" class="form-control" value="<?=  $data["name"] ?>">
            </div>
            <div class="form-group">
                <label>Giá</label>
                <input name="price" type="text" class="form-control" value="<?=  $data["price"] ?>">
            </div> 
            <div class="mb-3">
                <label for="so_luong" class="form-label">Số lượng (*)</label>
                <input type="number" class="form-control" id="so_luong" name="so_luong" value="<?=  $data["so_luong"] ?>">
            </div>             
            <div class="form-group">
                <label>mô tả</label>
                <input name="descriptions" type="text" class="form-control" value="<?=  $data["descriptions"] ?>">
            </div>            
            <div class="mb-3">
                    <label for="content" class="form-label">Mô tả chi tiết (*)</label>
                    <textarea  name="content" id="" style="width: 100%;"rows="10"><?= $data["content"]  ?></textarea>
            </div>          
            <div class="col-md-6">
                <label for="name" class="form-label ">Nhà cung cấp (*)</label>
                <select name="ncc[]" style="width: 100%;" multiple class="form-select" >
                        <?php  foreach($totalDsNCC as $item => $value): ?>
                            <option 
                            <?php  foreach($DsNCC_da_dang_ky as $key => $val): ?>
                                <?php  if($val["id"] == $value["id"]): ?>
                                    selected
                                <?php  endif; ?>
                            <?php  endforeach; ?>
                            value="<?=  $value['id'] ?>"><?=  $value["name"] ?></option>
                        <?php  endforeach; ?>
                </select>
            </div>  
          
            <button type="submit" class="btn btn-primary" name="btn-submit" > Sửa</button>
        </fieldset>
        </div>
    </div>
</form>