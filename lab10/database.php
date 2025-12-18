<?php
class Database {
    protected $host;
    protected $user;
    protected $password;
    protected $db_name;
    protected $conn;

    public function __construct() { 
        $this->getConfig();
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->db_name); 
        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    
    private function getConfig() {
        include_once("config.php");
        $this->host = $config['host'];
        $this->user = $config['username'];
        $this->password = $config['password'];
        $this->db_name = $config['db_name'];
    }
    
    public function getAll($table, $order_by=null) {
        $order_clause = $order_by ? " ORDER BY " . $order_by : "";
        $sql = "SELECT * FROM " . $table . $order_clause;
        return $this->conn->query($sql);
    }

    public function insert($table, $data) {
        if (is_array($data)) {
            $column = [];
            $value = [];
            foreach($data as $key => $val) {
                $val = $this->conn->real_escape_string($val); 
                $column[] = $key;
                $value[] = "'{$val}'";
            }
            $columns = implode(",", $column);
            $values  = implode(",", $value);
        }
        $sql = "INSERT INTO " . $table . " (" . $columns . ") VALUES (" . $values . ")";
        $result = $this->conn->query($sql);
        return $result;
    }
    
    public function getOne($table, $where) {
        $sql = "SELECT * FROM " . $table . " WHERE " . $where;
        $result = $this->conn->query($sql); 
        return $result ? $result->fetch_assoc() : null;
    }
    
    public function update($table, $data, $where) {
        $updates = [];
        if (is_array($data)) {
            foreach($data as $key => $val) {
                $val = $this->conn->real_escape_string($val);
                $updates[] = "$key='{$val}'";
            }
            $update_value = implode(",", $updates);
        }
        $sql = "UPDATE " . $table . " SET " . $update_value . " WHERE " . $where;
        $result = $this->conn->query($sql);
        return $result;
    }

    public function delete($table, $filter) {
        $sql = "DELETE FROM " . $table . " WHERE " . $filter;
        $result = $this->conn->query($sql);
        return $result;
    }
}