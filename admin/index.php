<?php  
    if(session_status()===PHP_SESSION_NONE){
        session_start();
    }
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    require_once __DIR__."/../vendor/autoload.php";
    if(file_exists(__DIR__."/route/web.php")){
        require_once __DIR__."/route/web.php";
    }
    else{
        echo "he thong dang bao tri";
    }
