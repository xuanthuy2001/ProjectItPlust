<?php  if(!defined('ADMIN_APP_PATH')){exit("can not found ");}?>
<div class="content">
    <div class="row">
                    <div class="col mb-2">
                        <a class="btn btn-primary ml-1" href="<?=  route('danh_muc','index') ?>"> View All</a>
                        <a class="btn btn-primary ml-1" href="<?=  route('danh_muc','create') ?>"> Thêm</a>
                    </div>
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input value="" id="js-nameBranch" type="text" class="form-control small" placeholder="Search for...">
                            <div class="input-group-append">
                                <button id="js-search" class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
    <table class="table">
    <thead class="thead-dark">
        <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Xem ds sản phẩm</th>
        <th scope="col">Trang blog</th>
        <th scope="col">Tên danh mục cha</th>
        <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php  foreach($listDm as $value): ?>
            <tr>
            <td scope="col"><?=  $value['id'] ?></td>
            <td scope="col"><?=  $value['name'] ?></td>
            <td scope="col">
                <a class=" text-success"  href="<?=  route('danh_muc','listSp',['id'=>$value["id"]]) ?>">DS sản phẩm</a>
            </td>
            <td scope="col">
            <a class=" text-success"  href="<?=  route('san_pham','listSp',['id'=>$value["id"]]) ?>">Trang blog</a>
            </td>
            <td scope="col">
                <?php  if($value['parent_id'] == PARENT_ID): ?>
                        la danh muc cha
                <?php  else: ?>
                    <?php  foreach($dataSub as $val): ?>
                        <?php  if($value['id'] == $val['sub_id']): ?>
                            <label style="color:blue" for=""><?=  $val['parentName'] ?></label>
                        <?php  endif; ?>
                    <?php  endforeach ?>
                <?php endif ?>  
            </td>
            <td scope="col">
                <a href="">sua</a>|
                <a href="">xoa</a>
            </td>
        </tr>
        <?php  endforeach; ?>
    </tbody>
    </table>
        <?= $htmlPage; ?>
</div>
