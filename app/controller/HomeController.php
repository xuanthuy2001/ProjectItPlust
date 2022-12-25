<?php  
    namespace app\controller;
    use app\controller\Controller;

    class HomeController extends Controller{
        public function index(){
            $this->loadHeader();
            $this->loadView('home/index_view');
            $this->loadFooter();
        }
    }
