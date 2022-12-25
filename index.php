<?php  
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    if(session_status()===PHP_SESSION_NONE){
        session_start();
    }
    require_once __DIR__.'/vendor/autoload.php';
    if(file_exists(__DIR__.'/route/web.php')){
        require __DIR__.'/route/web.php';
    }else{
        echo "he thong dang bao tri";
    }

