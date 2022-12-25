
        <div class="content">
            <div class="row">
                <div class="col mb-2">
                    <a class="btn btn-primary ml-1" href="<?=  route('nha_cung_cap','index') ?>"> View All</a>
                    <a class="btn btn-primary ml-1" href="<?=  route('nha_cung_cap','create') ?>"> Thêm</a>
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
                <th style="width: 20%;" scope="col">Tên</th>
                <th  style="width: 8%;"scope="col">trạng thái</th>
                <th scope="col">info</th>
                <th scope="col">DS sản phẩm</th>
                <th style="width: 8%;" colspan="2">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php  foreach($listNcc as $key=>$item): ?>
                    <tr >
                        <th scope="row"><?=  $item["id"] ?></th>
                        <td><a class="text-success"  href="<?=  route('nha_cung_cap','detail',[
                            'id' => $item["id"]
                        ]) ?>"><?=  $item["name"] ?></a></td>
                        <td>
                            <?=  $item["status"] == ACTIVE_STATUS ?  LABLE_ACTIVE_STATUS : LABLE_DEACTIVE_STATUS ?>
                        </td>
                        <td>
                            Địa chỉ: <span class="text-success" ><?=  $item["address"] ?></span>
                            <br>
                            Email:<a class="text-success" href="mailto:<?=  $item["email"] ?>"><?=  $item["email"] ?></a>
                            <br>
                            SĐT: <span class="  text-success" ><?=  $item["tel"] ?> </span>  <br>
                            Hotline <span class=" text-success" ><?=  $item["hotline"] ?></span>  <br>
                            Địa chỉ webSite: <a class="text-success" href="<?=  $item["url"] ?>"><?=  $item["url"] ?></a>
                            <br>
                            Ngày tạo: <span class="text-warning"><?=  $item["created_at"] ?></span> <br>
                            Ngày sửa: <span class="text-warning"><?=  $item["updated_at"] ?></span> <br>
                            Ngày xóa: <span class="text-warning"><?=  $item["deleted_at"] ?></span>
                        </td>
                        <td>
                            <a class=" text-success"  href="<?=  route('nha_cung_cap','listSp',[
                                'id'=>$item["id"]
                            ]) ?>">DS sản phẩm</a>
                        </td>
                        <td>   
                            <?php  if( $item["status"] == ACTIVE_STATUS ): ?>
                                <a class="btn btn-outline-warning mb-2" href="<?=  route('nha_cung_cap','edit',['id'=>$item["id"]]) ?>">Sửa</a>
                            <?php  else: ?>
                                <a style="pointer-events: none;  cursor: default; " class="btn btn-outline-warning mb-2" href="<?=  route('nha_cung_cap','edit',['id'=>$item["id"]]) ?>">Sửa</a>
                            <?php endif;  ?>
                        </td>
                        <td>   
                            <?php  if( $item["status"] == ACTIVE_STATUS ): ?>
                                <button id="<?= $item['id']; ?>" class="btn btn-danger js-delete-brand">Xóa</button>
                            <?php  else: ?>
                                <button disabled id="<?= $item['id']; ?>" class="btn btn-danger js-delete-brand">Xóa</button>
                            <?php endif;  ?>

                        </td>
                    </tr>
                <?php  endforeach; ?>               
            </tbody>
            </table>
            <?=  $htmlPage ?>
        </div>
