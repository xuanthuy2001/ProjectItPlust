<?php  
    namespace admin\app\models;
    use database\Database as Model;
    use \PDO;
    class Nha_cung_cap extends Model{
        public function __construct()
        {
            parent::__construct();
        }
        public function getData($key='')
        {
            $datas= [];
            $keyword = "%{$key}%";
            if(empty($key)){
                $sql = "SELECT * FROM `nha-cung-cap`";
            }
            else{
                $sql = "SELECT * FROM `nha-cung-cap` WHERE `nha-cung-cap`.`name` LIKE :keyword";
            }
          
            $stmt= $this->db->prepare($sql);
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
        public function getListsp($id)
        {
            $datas=[];
            $sql = "SELECT `sp`.*, `ncc`.`id` as `ma-ncc`, `ncc`.`name` as `ten-ncc` FROM `san-pham` AS `sp` INNER JOIN `sp-ncc` ON `sp`.`id` = `sp-ncc`.`ma-sp` INNER JOIN `nha-cung-cap` AS `ncc` ON `sp-ncc`.`ma-ncc` = `ncc`.`id` WHERE `ncc`.`id` =:id;";
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
        public function getAllDataByPaging($start, $limit, $key = '')
        {
       
            $datas = [];
            $keyword = "%{$key}%";
            
            if(empty($key)){
                $sql = "SELECT * FROM `nha-cung-cap` AS `ncc`  LIMIT :startRow, :limitRow ";
            } else {
                $sql = "SELECT * FROM `nha-cung-cap` AS `ncc` WHERE `ncc`.`name` LIKE  :keyword LIMIT :startRow,:limitRow ";
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
        public function checkUnique($tel,$hotline,$email,$url, $id = 0)
        // hàm kiểm tra dl đã tồn tại trong database?
        {
            $flagCheck = false; //khong ton tai
            if($id === 0){
                // insert
                $sql = "SELECT `ncc`.`id`,`ncc`.`tel`,`ncc`.`hotline`,`ncc`.`email`,`ncc`.`url` FROM `nha-cung-cap` AS `ncc` WHERE 
                `ncc`.`tel` = :tel OR
                `ncc`.`hotline`=:hotline OR
                `ncc`.`email`=:email OR
                `ncc`.`url`=:url
                LIMIT 1"; 
            }
            else{
                // update
                // loai chu chinh no , chi kiem tra dl con lai  => chuc nang update
                $sql = "SELECT `ncc`.`id`,`ncc`.`tel`,`ncc`.`hotline`,`ncc`.`email`,`ncc`.`url` FROM `nha-cung-cap` AS `ncc` WHERE 
                (`ncc`.`tel` = :tel OR
                `ncc`.`hotline`=:hotline OR
                `ncc`.`email`=:email OR
                `ncc`.`url`=:url) AND
                `ncc`.`id` != :id
                LIMIT 1"; 
            }
            $stmt = $this -> db ->prepare($sql);
            if($stmt){
                $stmt -> bindParam(':tel',$tel, PDO::PARAM_STR);
                $stmt -> bindParam(':hotline',$hotline, PDO::PARAM_STR);
                $stmt -> bindParam(':email',$email, PDO::PARAM_STR);
                $stmt -> bindParam(':url',$url, PDO::PARAM_STR);
                if($id !== 0){
                    $stmt -> bindParam(':id',$id, PDO::PARAM_INT);
                }
                if($stmt -> execute()){
                    if($stmt->rowCount()>0){
                        $flagCheck = true;//ton tai
                    }
                    $stmt -> closeCursor();
                }
            }
            return $flagCheck ;
        }
        public function checkUniqueSp($name,$nccID, $id = 0)
        // hàm kiểm tra dl đã tồn tại trong database?
        {
            $flagCheck = false; //khong ton tai
            if($id === 0){
                // insert
                $sql = "SELECT `nha-cung-cap`.`id`,`san-pham`.`name` FROM `san-pham` INNER JOIN `sp-ncc` ON `san-pham`.`id` = `sp-ncc`.`ma-sp` INNER JOIN `nha-cung-cap` ON `nha-cung-cap`.`id`=`sp-ncc`.`ma-ncc` WHERE `nha-cung-cap`.`id`=:nccID AND `san-pham`.`name`=:name "; 
            }
            else{
                // update
                // loai chu chinh no , chi kiem tra dl con lai  => chuc nang update
                $sql = "SELECT `nha-cung-cap`.`id`,`san-pham`.`name` FROM `san-pham` INNER JOIN `sp-ncc` ON `san-pham`.`id` = `sp-ncc`.`ma-sp` INNER JOIN `nha-cung-cap` ON `nha-cung-cap`.`id`=`sp-ncc`.`ma-ncc` WHERE (`nha-cung-cap`.`id`=:nccID AND `san-pham`.`name`=:name) AND
                `san-pham`.`id` != :id
                "; 
            }
            $stmt = $this -> db ->prepare($sql);
            if($stmt){
                $stmt -> bindParam(':nccID',$nccID, PDO::PARAM_INT);
                $stmt -> bindParam(':name',$name, PDO::PARAM_STR);
                if($id !== 0){
                    $stmt -> bindParam(':id',$id, PDO::PARAM_INT);
                }
                if($stmt -> execute()){
                    if($stmt->rowCount()>0){
                        $flagCheck = true;//ton tai
                    }
                    $stmt -> closeCursor();
                }
            }
            return $flagCheck ;
        }
        public function insert($name,$logo='',$address,$tel,$email,$hotline='',$url='')
        {
            $status = 1;
            $createdAt = date('Y-m-d H:i:s');
            $flagCheck = false; // insert thanh cong hay ko
            $sql = "INSERT INTO `nha-cung-cap`(`name`, `image`, `status`, `address`, `tel`, `hotline`, `email`, `url`, `created_at`) VALUES (:name,:image,:status,:address,:tel,:hotline,:email,:url,:created_at)";
            $stmt = $this->db->prepare($sql);
            if($stmt)
            {

                $stmt->bindParam(':name',$name,PDO::PARAM_STR);
                $stmt->bindParam(':image',$logo,PDO::PARAM_STR);
                $stmt->bindParam(':status',$status,PDO::PARAM_INT);
                $stmt->bindParam(':address',$address,PDO::PARAM_STR);
                $stmt->bindParam(':tel',$tel,PDO::PARAM_STR);
                $stmt->bindParam(':hotline',$hotline,PDO::PARAM_STR);
                $stmt->bindParam(':email',$email,PDO::PARAM_STR);
                $stmt->bindParam(':url',$url,PDO::PARAM_STR);
                $stmt->bindParam(':created_at',$createdAt,PDO::PARAM_STR);
                if($stmt->execute())
                {
                    $flagCheck = true;
                    $stmt->closeCursor();
                }
            }
            return $flagCheck;
        }
        public function getDetailNcc($id=0)
        {
            $data = [];
            $sql = "SELECT `id`, `name`, `image`, `status`, `address`, `tel`, `hotline`, `email`, `url`, `created_at`, `updated_at`, `deleted_at` FROM `nha-cung-cap` WHERE id=:id";
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

        public function handleUpdate($id,$name,$logo,$address,$tel,$email,$hotline='',$url='')
        {
            $updated_at = date('Y-m-d H:i:s');
            $flagCheck = false; // insert thanh cong hay ko
            if(empty($logo)){
                $sql = "UPDATE `nha-cung-cap` SET `name`=:name,`address`=:address,`tel`=:tel,`hotline`=:hotline,`email`=:email,`url`=:url,`updated_at`=:updated_at WHERE id = :id" ;
            }
            else{
                $sql = "UPDATE `nha-cung-cap` SET `name`=:name,`image`=:image,`address`=:address,`tel`=:tel,`hotline`=:hotline,`email`=:email,`url`=:url,`updated_at`=:updated_at WHERE `id` = :id";
            }
                
            $stmt = $this->db->prepare($sql);
            if($stmt){
                $stmt->bindParam(':id',$id,PDO::PARAM_INT);
                $stmt->bindParam(':name',$name,PDO::PARAM_STR);
                if(!empty($logo)){
                    $stmt->bindParam(':image',$logo,PDO::PARAM_STR);
                }
                $stmt->bindParam(':address',$address,PDO::PARAM_STR);
                $stmt->bindParam(':tel',$tel,PDO::PARAM_STR);
                $stmt->bindParam(':email',$email,PDO::PARAM_STR);
                $stmt->bindParam(':hotline',$hotline,PDO::PARAM_STR);
                $stmt->bindParam(':url',$url,PDO::PARAM_STR);
                $stmt->bindParam(':updated_at',$updated_at,PDO::PARAM_STR);
                if($stmt->execute()){
                    $flagCheck = true;
                    $stmt->closeCursor();
                }
            }   
            return $flagCheck;
        }
        public function softDelete($id)
        {
            $flagCheck = false;
            $deleted_at = date('Y-m-d H:i:s');
            $status = DEACTIVE_STATUS;
            $sql = "UPDATE `nha-cung-cap` SET `status` = :status , `deleted_at`=:deleted_at WHERE `id` = :id";
            $stmt = $this->db->prepare($sql);
            if($stmt){
                $stmt->bindParam(':status',$status,PDO::PARAM_INT);
                $stmt->bindParam(':deleted_at',$deleted_at,PDO::PARAM_STR);
                $stmt->bindParam(':id',$id,PDO::PARAM_STR);
                if($stmt->execute()){
                    $flagCheck = true;
                    $stmt->closeCursor();
                }
            }
            return $flagCheck;
        }
        public function listNcc()
        {
            $status = ACTIVE_STATUS;
            $datas=[];
            $sql = "SELECT `ncc`.`id`, `ncc`.`name`  FROM `nha-cung-cap` AS `ncc` where `ncc`.`status` = :status";
            $stmt  = $this->db->prepare($sql);
            if($stmt){
                $stmt->bindParam(':status',$status,PDO::PARAM_INT);
                if($stmt->execute()){
                    $datas= $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt->closeCursor();
                }
            }
            return $datas;
        }
    }