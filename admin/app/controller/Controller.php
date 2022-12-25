<?php  
    namespace admin\app\controller;

    class Controller{
        protected $rootPathView;
        public function __construct()
        {   
            $this->rootPathView = ADMIN_PATH_APP_VIEW;
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
        protected function loadHeader($path,$header=[])
        {
            return $this->loadView($path,$header);
        }
        protected function loadFooter($path,$footer=[])
        {
            return $this->loadView($path,$footer);
        }
        protected function redirectToLogin()
        {
            if(!$this->checkUserLogin())
            {
                return  redirect('login','index');
                exit();
            }
        }
        private function checkUserLogin()
        {
            $sessionUser = $this->getUserSession();
            if(!empty($sessionUser))
            {
                return true;
            }
            return false; 
        }
        protected function getUserSession()
        {
            $user = $_SESSION["username"]??'';
            return $user;
        }
    }
