<?php  
    namespace database;
    use \PDO;
    use \PDOException;
    class Database{
        protected $db;
        public function __construct()
        {
            $this->db = $this->conn();
        }
        protected function conn()
        {
            try {
                $dbh = new PDO(DB_CONNECTION.":host=".DB_HOST.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
                return $dbh;
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
        // ngat kn
        protected function disconnection()
        {
            $this->db=null;
        }
        public function __destruct()
        {
            $this->disconnection();
        }
    }