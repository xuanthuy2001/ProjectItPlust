<?php  
    if(!defined("APP_PATH"))
    {
        die("can not access");
    }
    $c=ucfirst($_GET["c"]??"home");
    $m=$_GET["m"]??"index";
    $nameController= "{$c}Controller";
    $fileController= "{$c}Controller.php";
    $fullPathController= NAMESPACE_CONTROLLER.$fileController;
    $fullRealPath = str_replace("\\", "/", $fullPathController);
    if(file_exists($fullPathController)){
        $controller = NAMESPACE_CONTROLLER.$nameController;
        $ojb=new $controller;
        $ojb->$m();
    }
    else{
        exit('not found ' . $fullPathController);
    }
