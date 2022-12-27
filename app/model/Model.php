<?php  
    namespace app\model;
    use database\Database as db;
    use \PDO;
    class Model extends db{
        public function __construct()
        {
            parent::__construct();
        }
        public function getAllDataSpByPaging($start, $limit, $key = '')
        {
            $status= ACTIVE_STATUS;
            $min=0;
            $data = [];
            $keyword = "%{$key}%";
            if(empty($key)){
                $sql = "SELECT `id`, `name`, `price`, `image`, `descriptions`, `content` FROM `san-pham` WHERE `status`=:status AND `so_luong` > :min LIMIT :startRow, :limitRow";
            } else {
                $sql = "SELECT `id`, `name`, `price`, `image`, `descriptions`, `content` FROM `san-pham` WHERE `status`=:status AND `so_luong` > :min AND `san-pham`.`name` LIKE :keyword  LIMIT :startRow, :limitRow";
            }
            $stmt = $this->db->prepare($sql);
            if($stmt) {
                $stmt->bindParam(':status',$status,PDO::PARAM_INT);
                $stmt->bindParam(':min',$min,PDO::PARAM_INT);
                if(!empty($key)) {
                    $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
                }
                $stmt->bindParam(':startRow', $start, PDO::PARAM_INT);
                $stmt->bindParam(':limitRow', $limit, PDO::PARAM_INT);
                if($stmt->execute()) {
                    if($stmt->rowCount() > 0) {
                        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    $stmt->closeCursor();
                }
            }
            return $data;
        }
        public function getDatas($key='')
        {
            $status= ACTIVE_STATUS;
            $min=0;
            $datas= [];
            $keyword = "%{$key}%";
            if(empty($key))
            {
                $sql = "SELECT `id`, `name`, `price`, `image`, `descriptions`, `content` FROM `san-pham` WHERE `status`=:status AND `so_luong` > :min";
            }else{
                $sql = "SELECT `id`, `name`, `price`, `image`, `descriptions`, `content` FROM `san-pham` WHERE `status`=:status AND `so_luong` > :min AND `san-pham`.`name` LIKE :keyword ";
            }
            $stmt= $this->db->prepare($sql);
            if($stmt){
                $stmt->bindParam(':status',$status, PDO::PARAM_INT);
                $stmt->bindParam(':min',$min, PDO::PARAM_INT);
                if(!empty($key)) {
                    $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
                }
                if($stmt->execute())
                {
                    if($stmt->rowCount() >0)
                    {
                        $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    $stmt->closeCursor();
                }
            }
            return $datas ;
        }
        public function getDanhMuc()
        {
            $datas= [];
            $status = ACTIVE_STATUS;
            $sql = "SELECT `danh-muc`.`id`,`danh-muc`.`name` , COUNT(`dm-sp`.`id_sp`) AS `sl_sp` FROM `danh-muc` 
            LEFT JOIN 
            `dm-sp`
            ON `danh-muc`.`id` = `dm-sp`.`id_dm`
            GROUP BY `danh-muc`.`id`,`danh-muc`.`name`";
            $stmt = $this->db->prepare($sql);
            if($stmt){
                $stmt->bindParam(':status',$status,PDO::PARAM_INT);
                if($stmt->execute()){
                    $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                $stmt->closeCursor();
            }
            return $datas;
        }
        public function listNCC()
        {
            $datas= [];
            $status = ACTIVE_STATUS;
            $sql = "SELECT `danh-muc`.`id`,`danh-muc`.`name` , COUNT(`dm-sp`.`id_sp`) AS `sl_sp` FROM `danh-muc` 
            LEFT JOIN 
            `dm-sp`
            ON `danh-muc`.`id` = `dm-sp`.`id_dm`
            GROUP BY `danh-muc`.`id`,`danh-muc`.`name`";
            $stmt = $this->db->prepare($sql);
            if($stmt){
                $stmt->bindParam(':status',$status,PDO::PARAM_INT);
                if($stmt->execute()){
                    $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                $stmt->closeCursor();
            }
            return $datas;
        }
    }