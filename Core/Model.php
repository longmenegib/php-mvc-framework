<?php
    include_once './config/config.php';

    class BaseModel{
     
        protected static $instance;

        protected $db;
        protected $tableName;

        public function __construct(){
            $this->db = $this->getInstance();
        }

        private function getInstance () {
            global $db_name;
            global $host;
            global $db_password;
            global $db_username;

            if(is_null(self::$instance)){
                self::$instance =  new PDO('mysql:host='.$host.';dbname='.$db_name, $db_username, $db_password);
            }
            return self::$instance;
        }

        public function __toString() {
            echo '<pre>';
           
            echo '</pre>';
            return '';
        }

        public function executeSql($query){
            $request = $this->db->prepare($query);

            $request->execute();
            $response = $request->fetchAll();

            echo '<pre>';
            print_r($response);
            echo '</pre>';
            return $response;
        }

        public function create($param=array()){
            
            $table_columns = implode(',', array_keys($param));
            $table_value = implode("','", $param);

            $sql = "INSERT INTO $this->tableName($table_columns) VALUES('$table_value')";
            $this->executeSql($sql);
        }

        public function update($param=array(), $id){
            echo 'update';
           $args = array();
           foreach($param as $key=>$value){
               $args[] = "$key = '$value'";
           }
            $sql = "UPDATE $this->tableName SET ". implode(',', $args);
            $sql .= " WHERE id=$id";

            $this->executeSql($sql);
        }

        public function delete($id){
            $sql = "DELETE FROM $this->tableName WHERE id=$id";

            $this->executeSql($sql);
        }

        public function select($row='*', $where=null){
            if($where !=null){
                $sql = "SELECT $row FROM $this->tableName WHERE $where";
            }else{
                $sql = "SELECT $row FROM $this->tableName";
            }
            $this->executeSql($sql);
        }

        public function count(){
            $req = $this->db->query("SELECT COUNT(*) FROM $this->tableName");
            $col = $req->fetchColumn();
            return $req->fetchColumn();
        }
       
        public function createDb($DBName, $server, $username, $password){
            try {
                
                $this->db = new PDO("mysql:host=$server", $username, $password);
                
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "CREATE DATABASE $DBName";
                
                $this->db->exec($sql);
                
                echo "DB created successfully<br>";

              } catch(PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
              }

            $this->db = null;
        }
    }

?>