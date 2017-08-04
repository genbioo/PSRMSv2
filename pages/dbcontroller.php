<?php
class DBController {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "psrms";
    public $conn;
    public $update_status;
    public $lastID;
    public $entryCount;
    
    public function __construct() {
        try {
        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->password);
        // set the PDO error mode to exception
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
    }
    
    function runFetch($query) {
        $sth = $this->conn->query($query);
        while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $resultset[] = $row;
        }
        $this->entryCount = $sth->fetchColumn();
        if(!empty($resultset))
            return $resultset;
    }
    
    function runUpdate($query) {
        $stmt = $this->conn->prepare($query);
        if($stmt->execute()) {
            $this->update_status = true;
            $this->lastID = $this->conn->lastInsertId(); //ID of recently inserted value
        }
    }
    
    function getUpdateStatus() {
        return $this->update_status;
    }
    
    function getLastInsertID() {
        return $this->lastID;
    }
    
    function getFetchCount() {
        return $this->entryCount;
    }
}
?>