<?php  
    namespace admin\app\controller;
    use admin\app\controller\Controller;
    use admin\app\models\Login;
    class LoginController extends Controller{
        protected $loginModel;
        public function __construct()
        {
            parent::__construct();
            $this->loginModel = new Login;
        }
        public function index()
        {
            // $NAME=$_COOKIE['admin@gmail_com'];
            // echo $_COOKIE['admin@gmail_com'];

            // if(isset($NAME))
            // {
            //     if($NAME=='123456')
            //     {
            //         echo "success";
            //     }
            //     else
            //     {
            //         echo "error";       
            //     }    
            // }
            // die();
            if(isset($_SESSION["username"]) && isset($_SESSION["password"]) )
          {
            return redirect('dashboard','index');
          }
            $this->loadHeader('login/header_view');
            $this->loadView('login/index_view');
            $this->loadFooter('login/footer_view');
        }
        public function handleLogin()   
        {
            if(isset($_POST["submit"]))
            {
                $userName = trim(strip_tags($_POST["email"]))??'';
                $password = trim(strip_tags($_POST["password"]))??'';
                $remember_login = trim(strip_tags($_POST["remember_login"]??'')) ?? '';

                if(empty($userName)||empty($password))
                {
                    $_SESSION["flash_message"]="vui long nhap du lieu";
                    return redirect('login','index',["message"=>$_SESSION["flash_message"]]);  
                }
                else{
                    $infoUser = $this->loginModel->checkUser($userName,$password);
                    if(empty($infoUser)){
                        $_SESSION["flash_message"]="tai khoan khong ton tai";
                        return redirect('login','index',["message"=>$_SESSION["flash_message"]]);
                    }
                    else{ 
                        if(!empty($remember_login)){
                            setcookie($userName, $password, time() + 2592000);
                        }
                        $_SESSION["flash_message"]="Đăng nhập thành công";
                        $_SESSION["username"]=$userName;
                        $_SESSION["password"]=$password;
                        return redirect('dashboard','index',["message"=>$_SESSION["flash_message"]]);
                    }
                }
            }
            else{
                $_SESSION["flash_message"]="bạn không có quyền truy cập";
                return redirect('login','index',["message"=>$_SESSION["flash_message"]]);
            }
        }
        public function logout()
        {
            $cookieName = $_SESSION["username"];
            session_unset();
            setcookie("$cookieName",'',time()-1);
            $_SESSION["flash_message"]="Đăng xuất thành công";
            return redirect('login','index',["message"=>$_SESSION["flash_message"]]);
        }
    }
