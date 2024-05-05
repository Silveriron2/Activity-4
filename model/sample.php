<?php
include $_SERVER['DOCUMENT_ROOT'].'/Integrative_Programming/Activity4/database/database.php';
header('Content-Type: application/json');

class UserModel extends Dbconnection{

  public function Create(array $params){

    $array = ['name', 'email', 'password', 'token'];
    
      foreach($array as $key){
        if(empty($params[$key])){
          return ['message' => "{$key} is required"];
        }
      }

    $name = $params['name'];
    $email = $params['email'];
    $password = $params['password'];
    $token = $params['token'];

    $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, token) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $token);

    $isInserted = $stmt->execute();

    if($isInserted){
      return ['message' => 'user inserted successfully'];
    } else {
      return ['message' => 'Failed to insert user'];
    }
  }

  public function getAll(){

    $getAll = $this->conn->query("SELECT * FROM users");

    if($getAll->num_rows > 0)
      $result = $getAll->fetch_all(MYSQLI_ASSOC);
        return $result;
  }

  public function Search(array $params){
    
    if(empty($params['email'])){
      return ['message' => 'email is required'];
    }

    $email = $params['email'] ?? '';

    $stmt = $this->conn->prepare("SELECT * FROM users WHERE email LIKE ?");
    $emailParam = "%$email%";
    $stmt->bind_param("s", $emailParam);

    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
      $data = $result->fetch_all(MYSQLI_ASSOC);
      return $data;
    } else {
      return ['message' => 'No users found'];
    }
  }
}

?>
