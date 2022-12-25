<?php  
    namespace app\controller;
    class Controller{
        protected $rootPathView;
        public function __construct()
        {   
            $this->rootPathView = PATH_APP_VIEW;
        }
        public function __call($name, $arguments)
        {
            exit("not found request:" . $name);
        }
        protected function loadView($path,$data=[])
        {
            extract($data);
            require $this->rootPathView.$path.'.php';
        } 
        protected function loadHeader($header=[])
        {
            return $this->loadView('layouts/header_view',$header);
        }
        protected function loadFooter($footer=[])
        {
            return $this->loadView('layouts/footer_view',$footer);
        }
    }