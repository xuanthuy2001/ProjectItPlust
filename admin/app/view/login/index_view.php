<?php  if(!defined('ADMIN_APP_PATH')){exit("can not found ");}?>

<form class="user" method="Post" action="<?=route('login','handleLogin') ?>">
    <?php  if(isset($_SESSION["flash_message"])): ?>
        <h6 class="text-center text-danger" > <?= $_SESSION["flash_message"]  ?></h6>
        <?php  unset($_SESSION["flash_message"]) ?>
    <?php  endif; ?>
    <div class="form-group">
        <input name="email" type="email" class="form-control form-control-user"
            id="exampleInputEmail" aria-describedby="emailHelp"
            placeholder="Enter Email Address...">
    </div>
    <div class="form-group">
        <input name="password" type="password" class="form-control form-control-user"
            id="exampleInputPassword" placeholder="Password">
    </div>
    <div class="form-group">
        <div class="custom-control custom-checkbox small">
            <input name="remember_login" type="checkbox" class="custom-control-input" id="customCheck">
            <label class="custom-control-label" for="customCheck">Remember
                Me</label>
        </div>
    </div>
    <button name="submit"  class="btn btn-primary btn-user btn-block">
        Login
    </button>
</form>