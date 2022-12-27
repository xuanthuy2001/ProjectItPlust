<?php  
    namespace admin\app\models;
    use database\Database as Model;
    use \PDO;
    class Danh_muc extends Model{
        public function __construct()
        {
            parent::__construct();
        }
        public function getData($key='')
        {
            $datas= [];
            $keyword = "%{$key}%";
            if(empty($key)){
                $sql = "SELECT * FROM `danh-muc`";
            }
            else{
                $sql = "SELECT * FROM `danh-muc` WHERE `danh-muc`.`name` LIKE :keyword";
            }
          
            $stmt= $this->db->prepare($sql);
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
            return $datas ; 
        }
        public function getAllDataByPaging($start, $limit, $key = '')
        {
       
            $datas = [];
            $keyword = "%{$key}%";
            
            if(empty($key)){
                $sql = "SELECT * FROM `danh-muc` AS `ncc`  LIMIT :startRow, :limitRow ";
            } else {
                $sql = "SELECT * FROM `danh-muc` AS `ncc` WHERE `ncc`.`name` LIKE  :keyword LIMIT :startRow,:limitRow ";
            }
        
            $stmt = $this->db->prepare($sql);
            if($stmt) {
                if(!empty($key)) {
                    $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
                }
                $stmt->bindParam(':startRow', $start, PDO::PARAM_INT);
                $stmt->bindParam(':limitRow', $limit, PDO::PARAM_INT);
                
                if($stmt->execute()) {
                    if($stmt->rowCount() > 0) {
                        $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    $stmt->closeCursor();
                }
            }
            return $datas;
        }
        function getSub()
        {
            $datas=[];
            $sql="SELECT `c1`.`id` as `paren_id`,`c1`.`name` AS `parentName`, `c2`.`name` AS `sub_category`, `c2`.`id` as `sub_id`  FROM (
                SELECT * FROM `danh-muc` ) AS `c1` INNER JOIN (
            SELECT * FROM `danh-muc` ) AS `c2` ON `c1`.`id` = `c2`.`parent_id`";
            $stmt = $this->db->prepare($sql);
            if($stmt->execute())
            {
                $datas= $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt->closeCursor();
            }
            return $datas;
        }
        public function get_all_id_name(){
            $status = ACTIVE_STATUS;
            $datas = [];
            $sql = "SELECT `id`, `name` FROM `danh-muc` WHERE `status` = :status";
            $stmt = $this->db->prepare($sql);
            if($stmt){
                $stmt->bindParam(':status', $status);
                if($stmt->execute()){
                    $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt->closeCursor();
                }
            }
            return $datas;
        }
        public function checkUniqueSp($name,$dmID, $id = 0)
        // hàm kiểm tra tên đã tồn tại trong bảng hay chưa?
        {
            $flagCheck = false; //khong ton tai
            if($id === 0){
                // insert
                $sql = "SELECT `danh-muc`.`id`,`san-pham`.`name` FROM `san-pham` INNER JOIN `dm-sp` ON `san-pham`.`id` = `dm-sp`.`id_sp` INNER JOIN `danh-muc` ON `danh-muc`.`id`=`dm-sp`.`id_dm` WHERE `danh-muc`.`id`=:dmID AND `san-pham`.`name`=:name "; 
            }
            else{
                // update
                // loai chu chinh no , chi kiem tra dl con lai  => chuc nang update
                $sql = "SELECT `danh-muc`.`id`,`san-pham`.`name` FROM `san-pham` INNER JOIN `dm-sp` ON `san-pham`.`id` = `dm-sp`.`id_sp` INNER JOIN `danh-muc` ON `danh-muc`.`id`=`dm-sp`.`id_dm` WHERE (`danh-muc`.`id`=:dmID AND `san-pham`.`name`=:name) AND
                `san-pham`.`id` != :id
                "; 
            }
            $stmt = $this -> db ->prepare($sql);
            if($stmt){
                $stmt -> bindParam(':dmID',$dmID, PDO::PARAM_INT);
                $stmt -> bindParam(':name',$name, PDO::PARAM_STR);
                if($id !== 0){
                    $stmt -> bindParam(':id',$id, PDO::PARAM_INT);
                }
                if($stmt -> execute()){
                    if($stmt->rowCount()>0){
                        return $stmt->rowCount();
                        $flagCheck = true;//ton tai
                    }
                    $stmt -> closeCursor();
                }
            }
            return $flagCheck ;
        }
        public function getListsp($id)
        {
            $datas=[];
            $sql = "SELECT `san-pham`.*,`danh-muc`.`name` AS `name_dm` FROM `san-pham` INNER JOIN `dm-sp` ON `san-pham`.`id` = `dm-sp`.`id_sp` INNER JOIN `danh-muc` ON `dm-sp`.`id_dm` = `danh-muc`.`id` WHERE `danh-muc`.`id` = :id";
            $stmt = $this->db->prepare($sql);
            if($stmt)
            {
                $stmt->bindParam(':id',$id,PDO::PARAM_INT);
                if($stmt->execute()){
                    if($stmt->rowCount() > 0){
                        $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $stmt->closeCursor();
                    }
                }
            }
            return $datas;
        }
    }