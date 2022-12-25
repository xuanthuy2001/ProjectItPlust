<?php  
    namespace admin\app\models;
    use database\Database as Model;
    use \PDO;
    class Login extends Model{
        public function __construct()
        {
            parent::__construct();
        }
        public function checkUser($user,$password)
        {
            $data=[];
            $sql = "SELECT * FROM `users` as `u` WHERE `u`.`email`=:user AND `u`.`password`=:password limit 1";
            $stmt = $this->db->prepare($sql);
            if($stmt)
            {
                $stmt->bindParam(':user',$user,PDO::PARAM_STR);
                $stmt->bindParam(':password',$password,PDO::PARAM_STR);
                if($stmt->execute()){
                    if($stmt->rowCount()>0){
                        $data=$stmt->fetch(PDO::FETCH_ASSOC);
                    }
                }
                $stmt->closeCursor();
            }
            return $data;
        }
    }