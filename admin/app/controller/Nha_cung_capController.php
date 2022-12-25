<?php  
    namespace admin\app\controller;
    use admin\app\controller\Controller;
    use admin\app\models\Nha_cung_cap;
    use admin\app\libs\Pagination;
    use admin\app\libs\UploadFile as File;
    class Nha_cung_capController extends Controller{
        protected $ncc;
        const LIMIT_ROWS = 2;
        public function __construct()
        {
            parent::__construct();
            $this->redirectToLogin();
            $this->ncc = new Nha_cung_cap;
        }
    
        public function index()
        {
            $keyword = $_GET["s"]?? '';
            $keyword = trim(strip_tags($keyword));
            $page = $_GET["page"] ?? '';
            $page = trim(strip_tags($page));
            $linkPage = Pagination::createLink([
                'c' => 'nha_cung_cap',
                'm' => 'index',
                'page' => '{page}',
                's' => $keyword
            ]);
          
            $datas= $this->ncc->getData($keyword);
            $totalItems = count($datas);
            $paging = Pagination::paginate($linkPage, $totalItems, $page, self::LIMIT_ROWS, $keyword);
            $start = $paging['start'] ?? 0;
            $limit = $paging['limit'] ?? self::LIMIT_ROWS; 
            $htmlPage = $paging['htmlPage'];
            $dataNCC = $this->ncc->getAllDataByPaging($start, $limit, $keyword);
            $this->loadHeader('layouts/header_view',["title"=>"Dashboard"]);
            $this->loadView('NCC/index_view',[
                "listNcc"=>$dataNCC,
                'keyword' => $keyword,
                'htmlPage' => $htmlPage
            ]);
            $this->loadFooter('layouts/footer_view');
        }  
        public function create()
        {
              //xu ly logic o day
              $state = trim($_GET['state'] ?? '');
              // $state === error || $state === name-exists || $state === fail
              $messagesError = [];
              if($state === 'error' && isset($_SESSION['errorAdd'])){
                  $messagesError = $_SESSION['errorAdd'];
              }
              $messagesExists = null;
              if($state === 'Da-dang-ky' && isset($_SESSION['messagesExists'])){
                $messagesExists = $_SESSION['messagesExists'];
              }
            $this->loadHeader('layouts/header_view',["title"=>"thêm nhà cung cấp"]);
            $this->loadView('NCC/create_view',[
                'messagesError' => $messagesError,
                'messagesExists'=>$messagesExists
            ]);
            $this->loadFooter('layouts/footer_view');

        }
        public function handleAdd()
        {   
            if(isset($_POST['btnAdd'])){
                $name = $_POST['name']??'';
                $name = trim(strip_tags($name));
                $address = $_POST['address']??'';
                $address = trim(strip_tags($address));
                $email = $_POST['email']??'';
                $email = trim(strip_tags($email));
                $tel = $_POST['tel']??'';
                $tel = trim(strip_tags($tel));
                $hotline = $_POST['hotline']??'';
                $hotline = trim(strip_tags($hotline));
                $url = $_POST['url']??'';
                $url = trim(strip_tags($url));
                $logo = null;
                
                // tien hanh upload logo
                if(!empty($_FILES['logo']['name'])){
                // nguoi dung thuc su co upload logo
                    $logo = File::uploadFileToServer($_FILES['logo'],PATH_UPLOAD_BRAND_LOGO);
                }

                // kiem tra tinh hop le cua du lieu
                // ten thuong hieu khong duoc trong
                // logo thuong hieu khong duoc trong
                $validations = validationBandData($name,$email,$tel);
                // ???
                $flagCheck = true; // thong bao loi
                foreach ($validations as $val) {
                    if(!empty($val)){
                        $flagCheck = false;
                        break;
                    }
                }
                
                if($flagCheck){
                
                    // khong co loi gi ca
                    // xoa bo di session error
                    if(isset($_SESSION['errorAdd'])){
                        unset($_SESSION['errorAdd']);
                    }
                    
                    // kiem tra ten thuong hieu da ton tai trong db chua ?
                    // neu chua ton tai thi se duoc them moi
                    // neu ton tai roi - bao loi va quay ve form add
                    
                    $checkUnique = $this->ncc->checkUnique($tel,$hotline,$email,$url);

                    if($checkUnique){
                        // ton tai roi
                        $_SESSION['messagesExists'] = "Một số thông tin đã được đăng ký";
                        // can xoa bo anh da dc upload len server
                        if(!empty($logo)) {
                            // xoa anh
                            File::deleteFileServer($logo, PATH_UPLOAD_BRAND_LOGO);
                        }
                        // quay ve form add
                        return redirect("nha_cung_cap" , "create",[
                            "state" => "Da-dang-ky",
                        ]);
                    } else {
                     
                        $insert = $this->ncc->insert($name,$logo,$address,$tel,$email,$hotline,$url);
                        if($insert){
                            // thanh cong - quay ve trang list brands
                            return redirect("nha_cung_cap" , "index");
                        } else {
                            // that bai - quay ve lai form add
                            return redirect("nha_cung_cap" , "create",[
                                "state" => "error",
                            ]);
                        }
                    }
                }else
                {
                    // co loi
                    // gan loi vao session
                    $_SESSION['errorAdd'] = $validations;
                    // can xoa bo anh da dc upload len server

                    if(!empty($logo)) {
                        // xoa anh
                        File::deleteFileServer($logo, PATH_UPLOAD_BRAND_LOGO);
                    }
                    // quay ve form add
                    return redirect("nha_cung_cap" , "create",[
                        "state" => "error",
                    ]);
                }
            }
        }
        public function detail()
        {
            $id = $_GET["id"] ?? '';
            $id = is_numeric($id) ? $id :0;
            $infoNCC = $this->ncc->getDetailNcc($id);
            if(!empty($infoNCC)){
                $this->loadHeader('layouts/header_view',["title"=>"detail"]);
                $this->loadView('NCC/detail_view',[
                    'data'=>$infoNCC
                ]);
                $this->loadFooter('layouts/footer_view');
            }
            else{
                // không có dl trong db
                $this->loadHeader('layouts/header_view',["title"=>"404"]);
                $this->loadView('errors/404_view');
                $this->loadFooter('layouts/footer_view');
            }
        }
        public function edit()
        {
            $id = $_GET["id"] ?? '';
            $id = is_numeric($id) ? $id : 0;
            $infoNCC = $this->ncc->getDetailNcc($id);
            if(!empty($infoNCC)){
                $state=isset($_GET["state"]) ? trim($_GET["state"]) : '';
                $messagesError=[];
                if(isset($_SESSION['messagesError']) && $state==="empty" ){
                    $messagesError = $_SESSION['messagesError'];
                }
                $this->loadHeader('layouts/header_view',["title"=>"detail"]);
                $this->loadView('NCC/edit_view',[
                    'data'=>$infoNCC,
                    'messagesError'=>$messagesError
                ]);
                $this->loadFooter('layouts/footer_view');
            }
            else{
                // không có dl trong db
                $_SESSION['flash_message'] = "Bạn không được phép thực hiện hành động này";
                $this->loadHeader('layouts/header_view',["title"=>"404"]);
                $this->loadView('errors/404_view');
                $this->loadFooter('layouts/footer_view');
            }
        }
        public function update()
        {
            if(isset($_POST["btn-submit"])){
                $id= $_POST["id"]; $id= trim(strip_tags($id))??"";
                $id = is_numeric($id) ? $id : 0;
                $name= $_POST["name"]; $name= trim(strip_tags($name))??"";
                $address= $_POST["address"]; $address= trim(strip_tags($address))??"";
                $email= $_POST["email"]; $email= trim(strip_tags($email))??"";
                $url= $_POST["url"]; $url= trim(strip_tags($url))??"";
                $tel= $_POST["tel"]; $tel= trim(strip_tags($tel))??"";
                $hotline= $_POST["hotline"]; $hotline= trim(strip_tags($hotline))??"";
                $checkUpload = null;
                if(!empty($_FILES["logo"]["name"])){
                    // nguoi dung muon thay doi logo thuong hieu
                    $newLogo = File::uploadFileToServer($_FILES["logo"],PATH_UPLOAD_BRAND_LOGO);
                    if($newLogo !== false){
                        $checkUpload =true;// thuc su co upload logo moi
                    }
                }
                else{
                    $newLogo = '';
                }
                $validations= validationBandData($name,$email,$tel);
                $checkValidation = true;
                foreach($validations as $value)
                {
                    if(!empty($value)){
                        $checkValidation = false;
                        break;
                    }
                }
                // start checkvalidation 
                    if($checkValidation){
                        // start checkUnique
                            $checkUnique = $this->ncc->checkUnique($tel,$hotline,$email,$url, $id);
                            // nếu  tồn tại thì quay lại trang báo lỗi đồng thời xóa ảnh đã upload trước đó
                            if($checkUnique){
                                $_SESSION["flash_message"]="thông tin đã được đăng ký";
                                if($checkUpload){
                                    File::deleteFileServer($newLogo, PATH_UPLOAD_BRAND_LOGO);
                                }
                                return redirect("nha_cung_cap","edit",[
                                    'id'=>$id
                                ]);
                            }
                            else{
                                if(isset($_SESSION['messagesError'])){
                                    unset($_SESSION['messagesError']);
                                }
                               
                                $update = $this->ncc->handleUpdate($id,$name,$newLogo,$address,$tel,$email,$hotline,$url);
                                
                                if($update){
                                    // thanh cong quay ve trang list brands
                                    return redirect('nha_cung_cap','index');
                                }
                                else{
                                    $_SESSION["flash_message"]="Lỗi không xác định";
                                    if($checkUpload){
                                        File::deleteFileServer($newLogo, PATH_UPLOAD_BRAND_LOGO);
                                    }
                                    return redirect("nha_cung_cap","edit",[
                                        'id'=>$id
                                    ]);
                                }
                            }
                        // end checkUnique
                    }
                    else{
                         // co loi nhap du lieu tu nguoi dung
                        // gan loi vao session
                        $_SESSION['messagesError'] = $validations;
                        // xoa anh upload neu co (neu nhu nguoi dung co upload logo moi thi moi xoa)
                        if($checkUpload){
                            File::deleteFileServer($newLogo, PATH_UPLOAD_BRAND_LOGO);
                        }
                       
                        return redirect("nha_cung_cap","edit",[
                            'id'=>$id,
                            'state'=>'empty'
                        ]);
                    }
                // end checkvalidation 
              
            }
        }
        public function delete()
        {
            // phuong thuc nay chi chap nhan request ajax gui len
            if(isRequestAjax()){
                // xu ly
                $id = $_POST['idNcc'] ?? '';
                $id = is_numeric($id) && $id > 0 ? $id : 0;
                if($id !== 0){
                    // hop le
                    // viet model de xoa thuong hieu theo id
                    $softDelete = $this->ncc->softDelete($id);
                    if($softDelete){
                        echo "SUCCESS";
                    }
                    else {
                        echo "FAIL";
                    }
                } else {
                    echo "ERROR";
                }
            }
        }
        public function listSp()
        {
            $id = $_GET["id"];
            $datas = $this->ncc->getListsp($id);
            $this->loadHeader('layouts/header_view',["title"=>"Dashboard"]);
            $this->loadView('NCC/list_spItem',["listSp"=>$datas]);
            $this->loadFooter('layouts/footer_view');
        }
    }
