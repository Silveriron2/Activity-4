<?php
include_once "../database/dbconnection.php";

class Userhandler extends Dbconnection{

    public function insertuser(array $insertdata){

        $data = ['fname','lname','email','password','token'];

        foreach($data as $key){ 
            if(empty($insertdata[$key])){
                return['message' => " {$key} is required!"];
            }
        }
        $fname = $insertdata['fname'];
        $lname = $insertdata['lname'];
        $email = $insertdata['email'];
        $password = $insertdata['password'];
        $token = $insertdata['token'];

        $checksql = $this->conn->query("SELECT * FROM users WHERE email = '$email' ");
        if($checksql->num_rows > 0){
            return ['message' => 'Email already exists!'];
        }else{

        $prepare = $this->conn->prepare("INSERT INTO users (fname,lname,email,password,token) VALUES (?, ?, ?, ?, ?)");
        $prepare->bind_param("sssss",$fname,$lname,$email,$password,$token);
        $ifinsert = $prepare->execute();
        $prepare->close();

        if($ifinsert){
            return ['message' => 'Inserted Successfully!'];
        }else{
            return ['message' => 'Insert failed!'];
        }

    }

    }


    


    public function getallusers(){
        $data = $this->conn->query("SELECT * FROM users");
        $result = $data->fetch_all(MYSQLI_ASSOC);
        return $result;
    }





    public function searchbyemail(array $search){
        if(empty($search['email'])){
            return json_encode(['message' => 'Please provide email.']);
        }
        //$email = $this->conn->real_escape_string($search['email']);
        $email = $search['email'] ?? null;
        $getemail = "%$email%";
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email LIKE ? ");
       $stmt->bind_param('s',$getemail);
        $stmt->execute();
        $data = $stmt->get_result();
        $datas = $data->fetch_all(MYSQLI_ASSOC);
        
        if ($datas){
            return $datas;
        }else{
            return ['message'=>'No record found!'];
        }
       
    }
}
?>