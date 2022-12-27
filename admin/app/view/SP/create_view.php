<?php if(!defined('ADMIN_APP_PATH')) exit('Can not access'); ?>
<!-- khong duoc phep truy cap truc tiep vao file view -->

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <p> This is add NCC page !</p>
            <a class="btn btn-primary" href="index.php?c=san_pham"> List san pham</a>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col">
            <?php if(!empty($messagesError)): ?>
                <ul>
                    <?php foreach($messagesError as $err): ?>
                        <?php if(!empty($err)): ?>
                            <li class="text-danger"><?= $err; ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>    

            <?php if(!empty($messagesExists)): ?>
                <p class="text-danger"><b><?= $messagesExists; ?></b></p>
                <?php  unset($_SESSION['messagesExists']);?>
            <?php endif; ?>

            <?php if(!empty($messagesFail)): ?>
                <p class="text-danger"><b><?= $messagesFail; ?></b></p>
            <?php endif; ?>

            <form class="border p-3" method="post" action="index.php?c=san_pham&m=handleAdd" enctype="multipart/form-data"> 
                <div class="mb-3">
                    <label for="name" class="form-label">Name (*)</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="name" class="form-label ">Nhà cung cấp (*)</label>
                        <select name="ncc[]" style="width: 100%;" multiple class="form-select" >
                                <?php  foreach($dsNcc as $item => $value): ?>
                                    <option  value="<?= $value['id'] ?>"><?=  $value["name"] ?></option>
                                <?php  endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="name" class="form-label ">Sản phẩm thuộc danh mục (*)</label>
                        <select name="dm[]" style="width: 100%;" multiple class="form-select" >
                                <?php  foreach($dsDanh_muc as $item => $value): ?>
                                    <option  value="<?=  $value['id'] ?>"><?=  $value["name"] ?></option>
                                <?php  endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6"> 
                        <div class="mb-3">
                            <label for="price" class="form-label">price (*)</label>
                            <input type="text" class="form-control" id="price" name="price">
                        </div>
                        <div class="mb-3">
                            <label for="so_luong" class="form-label">Số lượng (*)</label>
                            <input type="number" class="form-control" id="so_luong" name="so_luong">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="descriptions" class="form-label">Mô tả ngắn (*)</label>
                    <input type="text" class="form-control" id="descriptions" name="descriptions">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Mô tả chi tiết (*)</label>
                    <textarea  name="content" id="" style="width: 100%;"rows="10"></textarea>
                </div>
                <div class="mb-3">
                    <label for="logo" class="form-label">Logo (*)</label>
                    <input type="file" class="form-control" id="logo" name="logo">
                </div>
                <button type="submit" class="btn btn-primary" name="btnAdd">Submit</button>
            </form>
        </div>
    </div>
</div>