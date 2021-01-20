    <?php declare(strict_types=1);
    /***************************************************************************
    *  Each class should be modeled after the relevant database table.
    *  This serves as an example of such class. 
    *  Its attributes should reflect your own SQL table
    *  In these we find ourselves one layer of abstraction down from the Database
    ****************************************************************************/ 
        require_once __DIR__ . "/Database.php";
        require_once "module/function.php";

        class User extends Database{
                
            private const TABLENAME = "Users";  
            private  $id       = NULL;
            private $surname   = "";
            private $name      = "";
            private $email     = "";
            private $hash      = "";

            //getter
            public function id() {

                return $this->id;
            }

            public function surname() {

                return $this->surname;
            }

            public function name() {

                return $this->name;
            }

            public function email() {

                return $this->email;
            }

            public function hash() {

                return $this->hash;
            }


            //Setter
            public function set_id(int $input) {

                $this->id = $input;
            }

            public function set_surname(string $input) {

                $this->surname = $input;
            }

            public function set_name(string $input) {

                $this->name = $input;
            }

            public function set_email(string $input) {

                $this->email = $input;
            }

            public function set_hash(string $input) {

                $this->hash = $input;
            }

           
            
            
            //Quite bad, it's basically a hack as of now.
            function populate(array $input): void {

                foreach ($this as $column => $value) {
                    
                        $this-> $column = $input[$column];
                }
            }

            //This one needed quite a bit of workarounds, it employs functions that can be found in function.php for formatting the input
            //to use as as a valid query
            function add_user(): bool {

                if(empty($this->search_table(self::TABLENAME, "email", $this->email))) {
                    
                    $all = array();

                    foreach ($this as $column => $value) {

                        $all[$column] = $value;    
                    }

                    $all = strip_unset($all);
                    $col = format_col_pdo($all);                
                    $val = format_values_pdo($all);

                    $success = $this->insert_table(self::TABLENAME, $col, $val);

                    return $success;
                }

                return false;   
            }

            //needs more test
            public function update_user(string $field): bool {

                $user = $this->search_table(self::TABLENAME, "email", $this->email);
                
                foreach($this as $column => $value) {
                    
                    if($user[$column] != $value) {
                        
                        $success = $this->update_row(self::TABLENAME, $column, $value, $field);
                    
                        return $success;       
                    }
                }
                return false;
            }

        
            function delete_user(): bool {

                $user = $this->search_table(self::TABLENAME, "email", $this->email);
                
                if(!empty($user)) {
        
                    $success = $this->delete_row(self::TABLENAME, 'email', $user[0]['email']);
        
                    return $success;                     
                }
                    return false;        
            }


            //this method needs some more work for sure, ideally this should instantiate a new User instance with the retrieved data, 
            //this object would then be serialized into a session
            function logIn(): array {
                
                $user = $this->search_table(self::TABLENAME, 'email', $this->email);
                if(!empty($user)) {
                
                    if(password_verify($this->hash, $user[0]["hash"])) {
                        
                        return $user[0];
                    }
                }

                return array();
            }
        }
