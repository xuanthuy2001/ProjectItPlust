<?php  
    namespace admin\app\controller;
    use admin\app\controller\Controller;
    class DashboardController extends Controller{
        public function __construct()
        {
            parent::__construct();
        }
    
        public function index()
        {
 
           if(empty($_SESSION["username"]) && empty($_SESSION["password"]))
           { 
            $_SESSION["flash_message"]="bạn không có quyền truy cập";
            return redirect('login','index',["message"=>$_SESSION["flash_message"]]);
           }
           
            $this->loadHeader('layouts/header_view',["title"=>"Dashboard"]);
            $this->loadView('home/index_view');
            $this->loadFooter('layouts/footer_view');
        }  
    }
