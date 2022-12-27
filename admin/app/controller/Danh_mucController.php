<?php  
    namespace admin\app\controller;
    use admin\app\controller\Controller;
    use admin\app\models\Danh_muc;
    use admin\app\libs\Pagination;
    use admin\app\libs\UploadFile as File;

    class Danh_mucController extends Controller{
        private $dm;
        const LIMIT_ROWS = 6;
        public function __construct()
        {
            parent::__construct();
            $this->redirectToLogin();
            $this->dm = new Danh_muc();
        }
        public function index()
        {
            $keyword = $_GET['s'] ?? ''; $keyword = trim(strip_tags($keyword)) ;
            $page = $_GET['page'] ?? ''; $page = trim(strip_tags($page));
            $linkPage = Pagination::createLink([
                'c'=>'danh_muc',
                'm' => 'index',
                'page' => '{page}',
                's' => $keyword
            ]);
            $datas =$this-> dm-> getData($keyword);
            $totalItems = count($datas);
            
            $paging = Pagination::paginate($linkPage, $totalItems, $page, self::LIMIT_ROWS, $keyword);
            $start = $paging['start'] ?? 0;
            $limit = $paging['limit'] ?? self::LIMIT_ROWS; 
            $htmlPage = $paging['htmlPage'];
            $dataDm = $this->dm->getAllDataByPaging($start, $limit, $keyword);
            $dataSub = $this->dm->getSub();
            $this->loadHeader('layouts/header_view',["title"=>"quan ly danh muc"]);
            $this->loadView('DM/index_view',[
                "listDm"=>$dataDm,
                'keyword' => $keyword,
                'htmlPage' => $htmlPage,
                'dataSub'=>$dataSub
            ]);
            $this->loadFooter('layouts/footer_view');  
        }
        public function create()
        {
        }
        public function listSp()
        {
            $id = $_GET["id"];
            $id = trim(strip_tags($id));
            $datas = $this->dm->getListsp($id);
            $this->loadHeader('layouts/header_view',["title"=>"Dashboard"]);
            $this->loadView('DM/listSp_view',["listSp"=>$datas]);
            $this->loadFooter('layouts/footer_view');
        }
    }
