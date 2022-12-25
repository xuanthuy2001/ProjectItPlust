<?php if(!defined('ADMIN_APP_PATH')) exit('Can not access'); ?>
<!-- khong duoc phep truy cap truc tiep vao file view -->

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <p> This is add NCC page !</p>
            <a class="btn btn-primary" href="index.php?c=brand"> List brands</a>
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

            <form class="border p-3" method="post" action="index.php?c=nha_cung_cap&m=handleAdd" enctype="multipart/form-data"> 
                <div class="mb-3">
                    <label for="name" class="form-label">Name (*)</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address (*)</label>
                    <input type="text" class="form-control" id="address" name="address">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email (*)</label>
                    <input type="text" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="tel" class="form-label">Tel (*)</label>
                    <input type="text" class="form-control" id="tel" name="tel">
                </div>
                <div class="mb-3">
                    <label for="hotline" class="form-label">Hotline (*)</label>
                    <input type="text" class="form-control" id="hotline" name="hotline">
                </div>
                <div class="mb-3">
                    <label for="url" class="form-label">Địa chỉ trang web (*)</label>
                    <input type="text" class="form-control" id="url" name="url">
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