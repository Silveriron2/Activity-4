<?php
class Dbconnection {
    protected $conn;
    public function __construct()
    {
        $this->conn = new mysqli('localhost','root','','usersdb');
    }
}
?>