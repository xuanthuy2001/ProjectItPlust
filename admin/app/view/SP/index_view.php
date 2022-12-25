<?php  if(!defined('ADMIN_APP_PATH')){exit("can not found ");}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="content">
        <div class="row">
            <div class="col mb-2">
                <a class="btn btn-primary ml-1" href="<?=  route('san_pham','index') ?>"> View All</a>
                <a class="btn btn-primary ml-1" href="<?=  route('san_pham','create') ?>"> Thêm</a>
            </div>
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input value="<?= htmlentities($keyword); ?>" id="js-nameBranch" type="text" class="form-control small" placeholder="Search for...">
                    <div class="input-group-append">
                        <button id="js-search" class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-dark">
            <thead>
                <tr>
                <th scope="col">Ma-NCC</th>
                <th style="width: 20%;" scope="col">Tên/Thông tin</th>
                <th  style="width: 8%;"scope="col">trạng thái</th>
                <th scope="col">info</th>
                <th style="width: 8%;" colspan="2">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php  foreach($listSp as $key=>$item): ?>
                    <tr>
                        <th scope="row"><?=  $item["id"] ?></th>
                        <td>
                            <a class="text-success" href="<?=  route("san_pham","detail",[
                                'id'=>$item["id"]
                            ]) ?>"><?=  $item["name"] ?></a>
                        </td>
                        <td>
                            <?=  $item["status"] == ACTIVE_STATUS ?  LABLE_ACTIVE_STATUS : LABLE_DEACTIVE_STATUS ?>
                        </td>
                        <td>
                            Giá: <span class="text-success" ><?=  $item["price"] ?></span>
                            <br>
                            SL: <span class="text-success" ><?=  $item["so_luong"] ?></span>
                            <br>
                        </td>
                        
                       
                        <td>   <a class="btn btn-outline-warning mb-2" href="<?=  route('san_pham','edit',[
                                'id'=>$item["id"]
                            ]) ?>">Sửa</a></td>
                        <td>   <a class="btn btn-outline-danger mb-2" href="<?=  route('san_pham','delete',[
                                'id'=>$item["id"]
                            ]) ?>">Xóa</a></td>
                    </tr>
                <?php  endforeach; ?>               
            </tbody>
            </table>
            <?= $htmlPage; ?>
        </div>
</body>
</html>