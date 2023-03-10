<?php  
    namespace admin\app\controller;
    use admin\app\controller\Controller;
    use admin\app\models\San_pham;
    use admin\app\libs\Pagination;
    use admin\app\models\Nha_cung_cap;
    use admin\app\libs\UploadFile as File;
    use admin\app\models\Danh_muc;

    class San_phamController extends Controller{
        private $sp;
        private $ncc;
        private $dm;
        const LIMIT_ROWS = 6;
        public function __construct()
        {
            parent::__construct();
            $this->redirectToLogin();
            $this->sp = new San_pham;
            $this->ncc = new Nha_cung_cap;
            $this->dm = new Danh_muc;
        }
        public function index()
        {
            $keyword = $_GET["s"] ?? "";
            $keyword = trim(strip_tags($keyword));
            $page = $_GET["page"]?? "";
            $page = is_numeric($page) & $page>0 ? $page :1;
            $linkPage = Pagination::createLink([
                'c' => 'san_pham',
                'm' => 'index',
                'page' => '{page}',
                's' => $keyword
            ]);
            $allSanPham = $this->sp->getData($keyword);
            $totalItems = count($allSanPham);
    
            $paging = Pagination::paginate($linkPage, $totalItems, $page, self::LIMIT_ROWS, $keyword);
            $start = $paging['start'] ?? 0;
            $limit = $paging['limit'] ?? self::LIMIT_ROWS; 
            $htmlPage = $paging['htmlPage'];
            $dataSP = $this->sp->getAllDataSpByPaging($start, $limit, $keyword);
            
            // $datas= $this->sp->getData();
            $this->loadHeader('layouts/header_view',["title"=>"Dashboard"]);
            $this->loadView('SP/index_view',[
                'listSp' => $dataSP,
                'keyword' => $keyword,
                'htmlPage' => $htmlPage
            ]);
            $this->loadFooter('layouts/footer_view');
        } 
        public function detail()
        {
            $id = $_GET["id"];
            $item= $this->sp->detail($id);
         
            $this->loadHeader('layouts/header_view',["title"=>"Dashboard"]);
            $this->loadView('SP/detail_view',["item"=>$item]);
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
              $dsNcc = $this->ncc->listNcc();
              $dsDanh_muc =$this->dm->get_all_id_name();
              
            $this->loadHeader('layouts/header_view',["title"=>"th??m nh?? cung c???p"]);
            $this->loadView('SP/create_view',[
                'messagesError' => $messagesError,
                'messagesExists'=>$messagesExists,
                'dsNcc'=>$dsNcc,
                'dsDanh_muc'=> $dsDanh_muc
            ]);
            $this->loadFooter('layouts/footer_view');

        }
        public function handleAdd()
        {   
            
            if(isset($_POST['btnAdd'])){
                $name = $_POST['name']??'';$name = trim(strip_tags($name));
                $price = $_POST['price']??'';$price = trim(strip_tags($price));
                $descriptions = $_POST['descriptions']??'';$descriptions = trim(strip_tags($descriptions));
                $content = $_POST['content']??'';$content = trim(strip_tags($content));
                $so_luong = $_POST['so_luong']??'';$so_luong = trim(strip_tags($so_luong));
                $ncc = $_POST['ncc'] ?? '';
                $dm = $_POST['dm'] ?? '';
            
                $logo = null;
                // tien hanh upload logo
                if(!empty($_FILES['logo']['name'])){
                // nguoi dung thuc su co upload logo
                    $logo = File::uploadFileToServer($_FILES['logo'],PATH_UPLOAD_PRODUCT);
                }
                // kiem tra tinh hop le cua du lieu
                // ten thuong hieu khong duoc trong
                // logo thuong hieu khong duoc trong
                $validations = validationSpData($name,$price, $so_luong,$ncc,$dm,$logo);
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
                      //  start  kiem tra danh m???c da co sp n??y ch??a
                        $issetDM=[];
                        $dmHL=[];
                        
                        foreach($dm as $val)
                        {
                            $checkUnique = $this->dm->checkUniqueSp($name, $val);
                            if($checkUnique)
                            {
                                $issetDM[].=$val;
                            }
                            else{
                                $dmHL[].=$val;
                            }
                        }
                      //  end  kiem tra danh m???c da co sp n??y ch??a
                    
                    //  start  kiem tra nha cung cap da co sp n??y ch??a
                        $issetNCC=[];
                        $nccHL=[];
                        foreach($ncc as $item =>$val)
                        {
                            $checkUnique = $this->ncc->checkUniqueSp($name, $val);
                            if($checkUnique)
                            {
                                $issetNCC[].=$val;
                            }
                            else{
                                $nccHL[].=$val;
                            }
                        }
                        
                        if(empty($issetNCC) && empty($issetDM)){
                            $insert = $this->sp->insert($name,$price,$so_luong,$logo,$descriptions,$content,$nccHL,$dmHL);
                            
                            if($insert){
                                // thanh cong - quay ve trang list brands
                                return redirect("san_pham" , "index");
                            } else {
                                // that bai - quay ve lai form add
                                return redirect("san_pham" , "create",[
                                    "state" => "error",
                                ]);
                            }
                        }
                        else{
                            $_SESSION['errorAdd'] = $issetNCC;
                            // can xoa bo anh da dc upload len server
                            if(!empty($logo)) {
                                // xoa anh
                                File::deleteFileServer($logo, PATH_UPLOAD_PRODUCT);
                            }
                            // quay ve form add
                            return redirect("san_pham" , "create",[
                                "state" => "error",
                            ]);
                        }
                //  end  kiem tra nha cung cap da co sp n??y ch??a
                
              
                    
                  
                }else
                {
                    // co loi
                    // gan loi vao session
                    $_SESSION['errorAdd'] = $validations;
                    // can xoa bo anh da dc upload len server

                    if(!empty($logo)) {
                        // xoa anh
                        File::deleteFileServer($logo, PATH_UPLOAD_PRODUCT);
                    }
                    // quay ve form add
                    return redirect("san_pham" , "create",[
                        "state" => "error",
                    ]);
                }
            }
        }
        public function edit()
        {
            $id = $_GET["id"] ?? '';
            $id = is_numeric($id) ? $id : 0;
            $totalDsNCC = $this->ncc->listNcc();
            $DsNCC_da_dang_ky = $this->sp->dsNccInner($id);
            $infoSP = $this->sp->getDetailSp($id);
            if(!empty($infoSP)){
                $state=isset($_GET["state"]) ? trim($_GET["state"]) : '';
                $messagesError=[];
                if(isset($_SESSION['messagesError']) && $state==="empty" ){
                    $messagesError = $_SESSION['messagesError'];
                }
                $this->loadHeader('layouts/header_view',["title"=>"detail"]);
                $this->loadView('SP/edit_view',[
                    'data'=>$infoSP,
                    'totalDsNCC'=>$totalDsNCC,
                    'DsNCC_da_dang_ky'=>$DsNCC_da_dang_ky,
                    'messagesError'=>$messagesError
                ]);
                $this->loadFooter('layouts/footer_view');
            }
            else{
                // kh??ng c?? dl trong db
                $_SESSION['flash_message'] = "B???n kh??ng ???????c ph??p th???c hi???n h??nh ?????ng n??y";
                $this->loadHeader('layouts/header_view',["title"=>"404"]);
                $this->loadView('errors/404_view');
                $this->loadFooter('layouts/footer_view');
            }
        }
        public function delete()
        {
            echo "delete";
        }
       
    }
