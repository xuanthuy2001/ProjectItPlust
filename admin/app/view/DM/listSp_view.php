<?php  if(!defined('ADMIN_APP_PATH')){exit("can not found ");}?>

        <div class="content">
        <table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">Tên-danh muc</th>
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
                        <th scope="row"><?=  $item["name_dm"] ?></th>
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
