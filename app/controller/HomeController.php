<?php  
    namespace app\controller;

    use app\controller\Controller;
    use app\libs\Pagination;
    use app\model\Model;
    class HomeController extends Controller{
        private $model;
        const LIMIT_ROWS = 6;
        public function __construct()
        {
            parent::__construct();
            $this->model = new Model();
        }
        public function index(){
            $keyword = $_GET["s"] ?? "";
            $keyword = trim(strip_tags($keyword));
            $page = $_GET["page"]?? "";
            $page = is_numeric($page) & $page> 0 ? $page :1;
            $linkPage = Pagination::createLink([
                'c' => 'home',
                'm' => 'index',
                'page' => '{page}',
                's' => $keyword
            ]);
            $allSanPham = $this->model->getDatas($keyword);
            $totalItems = count($allSanPham);
            $paging = Pagination::paginate($linkPage, $totalItems, $page, self::LIMIT_ROWS, $keyword);
            
            $start = $paging['start'] ?? 0;
            $limit = $paging['limit'] ?? self::LIMIT_ROWS; 
            $htmlPage = $paging['htmlPage'];
            $dataSP = $this->model->getAllDataSpByPaging($start, $limit, $keyword);
            $listDanhMuc = $this->model->getDanhMuc();
          
            $listNCC = $this->model->listNCC();
            $this->loadHeader([
                'title'=>"trang chu"
            ]);
            $this->loadView('home/index_view',[
                'listSp' => $dataSP,
                'keyword' => $keyword,
                'htmlPage' => $htmlPage,
                'limit' => $limit,
                'totalItems'=>$totalItems,
                'listDanhMuc'=>$listDanhMuc
            ]);
            $this->loadFooter();
        }
        
    }
