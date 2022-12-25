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
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">Tên-NCC</th>
                    <th scope="col">Ma-SP</th>
                    <th style="width: 20%;" scope="col">Tên</th>
                    <th style="width: 20%;" scope="col">Giá bán</th>
                    <th  style="width: 8%;"scope="col">trạng thái</th>
                    <th scope="col">ảnh</th>
                </tr>
            </thead>
            <tbody>
                <?php  foreach($listSp as $key=>$item): ?>
                    <tr>
                        <th scope="row"><?=  $item["ten-ncc"] ?></th>
                        <th scope="row"><?=  $item["id"] ?></th>
                        <td><?=  $item["name"] ?></td>
                        <td><?=  $item["price"] ?></td>
                        <td>
                         <?=  $item["status"] == ACTIVE_STATUS ?  LABLE_ACTIVE_STATUS : LABLE_DEACTIVE_STATUS ?>
                        </td>
                        <td>
                            <img src="<?=  $item["image"] ?>" alt="">
                        </td>
                    </tr>
                <?php  endforeach; ?>               
            </tbody>
            </table>
        </div>
</body>
</html>