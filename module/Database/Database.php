<?php declare(strict_types=1);
/* **************************************************************************************************************
 * The (quite) basic DAO, capable of operating the simplest of CRUD operations. As such its method put emphasis on 
 * simplicity and generality. 
 * Classes modeled after your DB tables expand on these method to realize operations that are relevant to them.
 * (User having a logIn() method which make use of the Database search_table() method for exemple)
 ****************************************************************************************************************/
    class Database {
       
            protected const HOST   = "localhost";
            protected const PORT   = "3306";
            protected const DBNAME = "test";
            protected const ENC    = "utf8";
            protected const USER   = "root";
            protected const PASS   = "";
            

        static function connect_db(): PDO {

            $db = new PDO("mysql:host=" . self::HOST   . ";
                          port="        . self::PORT   . ";
                          dbname="      . self::DBNAME . ";
                          charset="     . self::ENC    . ";", 
                                          self::USER, self::PASS
            );
            
            return $db; 
         }
        
        //You'll have to format_col_pdo() and format_value_pdo for this to work 
        static function search_table(string $table, string $column, string $value): array {
             
            $db  = self::connect_db();
            $req = $db->prepare("SELECT * FROM `$table` WHERE `$column` = $value");
            
            $req->execute();
        
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }

        static function insert_table(string $table, string $column, string $value): bool {
            
            if(empty($value)) {
                return false;
            }

            $db  = self::connect_db();
            $req = $db->prepare("INSERT INTO `$table` ($column) VALUES ($value);");
            
            $req->execute();

            if($req->rowCount() === 0) {
                
                return false;
            }
            
            return true;
        }

        //this have to be fixed according to the change made to the insert_table method, 
        static function update_row(string $table, string $column, $value, string $where, $whereVal): bool  {

            $db  = self::connect_db();
            $req = $db->prepare("UPDATE `$table` set `$column` = \"$value\" WHERE `$table`.`$where` = \"$whereVal\";");

            $req->execute();
           
            if($req->rowCount() === 0) {

                return false;
            }

            return true;    
        }

        static function delete_row(string $table, string $column, $whereChange): bool {
           
            $db  = self::connect_db();
            $req = $db->prepare("DELETE FROM `$table` WHERE `$table`.`$column` = :whereChange;");

            $req->bindParam(":whereChange", $whereChange);
            $req->execute();

            if($req->rowCount()) {

                return false;
            }

            return true;       
        }

        static function fetch_table(string $table) {

            $db = self::connect_db();
            $req = $db->prepare("SELECT * FROM `$table`");

            $req->execute();

            return $req->fetchAll(PDO::FETCH_ASSOC);
        }
    }



