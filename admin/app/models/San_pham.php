<?php  
    namespace admin\app\models;
    use database\Database as Model;
    use \PDO;
    class San_pham extends Model{
        public function __construct()
        {
            parent::__construct();
        }
        public function getAllDataSpByPaging($start, $limit, $key = '')
        {
            $data = [];
            $keyword = "%{$key}%";
            if(empty($key)){
                $sql = "SELECT
                `sp`.*
                FROM
                    `san-pham` AS `sp`
                 LIMIT :startRow, :limitRow";
            } else {
                $sql = "SELECT
                `sp`.*
                FROM
                    `san-pham` AS `sp`
                WHERE `name` LIKE :keyword LIMIT :startRow, :limitRow";
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
                        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    $stmt->closeCursor();
                }
            }
            return $data;
        }
        public function getData($key='')
        {
            $datas= [];
            $keyword = "%{$key}%";
            if(empty($key))
            {
                $sql = "SELECT `sp`.* FROM `san-pham` AS `sp`";
            }else{
                $sql = "SELECT
                `sp`.*
                FROM
                    `san-pham` AS `sp`
                 WHERE `sp`.`name` LIKE :keyword ";
            }
           
            $stmt= $this->db->prepare($sql);
            if($stmt){
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
        public function insert($name,$price,$so_luong,$image,$descriptions,$content,$ncc=[],$dm=[]){
            $createdAt = date('Y-m-d H:i:s');
            $flagCheck = false; // insert thanh cong hay ko
            $sql = "INSERT INTO `san-pham`(`name`, `price`,`so_luong`, `image`, `descriptions`, `content`,  `created_at`) VALUES (:name,:price,:so_luong,:image,:descriptions,:content,:created_at)";
            $stmt = $this->db->prepare($sql);
            if($stmt){
                $stmt->bindParam(':name',$name,PDO::PARAM_STR);
                $stmt->bindParam(':price',$price,PDO::PARAM_STR);
                $stmt->bindParam(':so_luong',$so_luong,PDO::PARAM_INT);
                $stmt->bindParam(':image',$image,PDO::PARAM_STR);
                $stmt->bindParam(':descriptions',$descriptions,PDO::PARAM_STR);
                $stmt->bindParam(':content',$content,PDO::PARAM_STR);
                $stmt->bindParam(':created_at',$createdAt,PDO::PARAM_STR);
                if($stmt->execute()){
                    $idNew = $this->db->lastInsertId();
                    $idNew = intval($idNew);
                    $flagCheck = true;
                }
                if($flagCheck){
                   foreach($ncc as $val){
                        $sql_sp_ncc= "INSERT INTO `sp-ncc`(`ma-ncc`, `ma-sp`) VALUES (:ma_ncc,:ma_sp)";
                        $stmt2 = $this->db->prepare($sql_sp_ncc);
                        if($stmt2){
                            $stmt2->bindParam(':ma_ncc',$val,PDO::PARAM_INT);
                            $stmt2->bindParam(':ma_sp',$idNew,PDO::PARAM_INT);
                            if($stmt2->execute()){
                                $flagCheck = true;
                            }
                            else{
                                $flagCheck = false;
                            }
                        }
                   }
                   foreach($dm as $val){
                    $sql_sp_ncc= "INSERT INTO `dm-sp`(`id_sp`, `id_dm`) VALUES (:ma_sp,:ma_dm)";
                    $stmt2 = $this->db->prepare($sql_sp_ncc);
                    if($stmt2){
                        $stmt2->bindParam(':ma_sp',$idNew,PDO::PARAM_INT);
                        $stmt2->bindParam(':ma_dm',$val,PDO::PARAM_INT);
                        if($stmt2->execute()){
                            $flagCheck = true;
                        }
                        else{
                            $flagCheck = false;
                        }
                    }
               }
                } 
                return $flagCheck;
            }
        }
        public function detail($id)
        {
        }
        public function getDetailSp($id)
        {
            $data = [];
            $sql = "SELECT `id`, `name`, `price`, `image`, `descriptions`, `content`, `status`, `so_luong`, `created_at`, `updated_at`, `deleted_at` FROM `san-pham` WHERE id=:id";
            $stmt = $this->db->prepare($sql);
            if($stmt)
            {
                $stmt->bindValue(':id',$id,PDO::PARAM_INT);
                if($stmt ->execute()){
                    if($stmt ->rowCount()>0)
                    {
                        $data = $stmt ->fetch(PDO::FETCH_ASSOC);
                    }
                    $stmt->closeCursor();
                }
            }
            return $data ;
        }
        public function dsNccInner($id)
        {
            $datas=[];
            $sql = "SELECT `nha-cung-cap`.`id`,`nha-cung-cap`.`name` AS `name_ncc` FROM `san-pham` INNER JOIN `sp-ncc` ON `san-pham`.`id` = `sp-ncc`.`ma-sp` INNER JOIN `nha-cung-cap` ON `nha-cung-cap`.`id` = `sp-ncc`.`ma-ncc` WHERE `san-pham`.`id`=:id  ";
            $stmt = $this->db->prepare($sql);
            if($stmt){
                $stmt->bindParam(':id',$id,PDO::PARAM_INT);
                if($stmt -> execute()){
                    $datas=$stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt->closeCursor();
                }
            }
            return $datas;
        }
    }