<?php
/*
 * PDO Database Class
 * Connect to database
 * Create prepared statements
 * Bind values
 * Return rows and results
 */

class Database {

    private $host = DB_HOST;
    private $dbname = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;

    private $dbh;   // database handler or like conn
    private $stmt;  // database statement
    private $error;


    public function __construct(){
        
        try {
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            //code...
            $this->dbh = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->user, $this->pass, $options);

        } catch (PDOException $e) {
            //throw $th;
            $this->error = $e->getMessage();
            die($this->error);
        }

    }

    public function get($table, $where){
        //$conn = self::__construct();
        
        $field = $where[0];
        $operator = $where[1];
        $value = $where[2];
        
        // sample: WHERE email = :email
        $this->query("SELECT * FROM {$table} WHERE {$field} $operator :{$field}");
        
        // bind the field and value
        $this->bind(":{$field}", $value);
        $this->stmt->execute();

        return $this;   // return instance of this class
    }

    // Prepare statement with query
    public function query($query){
        $this->stmt = $this->dbh->prepare($query);  // PDO prepare
    }

    // Bind values
    public function bind($param, $value, $type = null){
        if(is_null($type)){
            // make this always run. pass bool true
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        //echo "<br/>",$param," -> ",$value,"<br/><br/>";
        $this->stmt->bindValue($param, $value, $type);  // PDO BindValue
    }

    // Execute the prepared statement
    public function execute(){
        return $this->stmt->execute();  // PDO Execute
    }

    // Get result set as array of objects 
    public function resultSet(){
        $this->execute();   // object function execute
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get single record as object
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Get row count
    public function rowCount(){
        return $this->stmt->rowCount(); // PDO rowcCount
    }

}

?>