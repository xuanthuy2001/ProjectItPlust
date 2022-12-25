<?php  if(!defined('ADMIN_APP_PATH')){exit("can not found ");}?>
<?php  if(isset($_SESSION["flash_message"])): ?>
        <h6 class="text-center text-success" > <?= $_SESSION["flash_message"]  ?></h6>
        <?php  unset($_SESSION["flash_message"]) ?>
<?php  endif; ?>