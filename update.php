<?php
$data=json_decode(file_get_contents("php://input"), true);
$email=$data['email']??null;
$password=$data['password']??null;
$program=$data['program']??null;
if(empty($email) || empty($password) || empty($program))
  if(empty($id)){
    http_response_code(400);
    echo json_encode([
        "status"=>"failed",
        "message"=>"Missing Id"
    ]);
  }
if($email1==null &&!filter_var($email,FILTER_VALIDATE_EMAIL)){
    http_response_code(400);
    echo json_encode([
        "status"=>"failed",
        "message"=>"Invalid Email"
    ]);
    exit();
}


if($password!=null && strlen($password)<8){
    http_response_code(400);
    echo json_encode([
        "status"=>"failed",
        "message"=>"Password must be 8"
    ]);
    exit();
}

try{
    $hashPassword=password_hash($password,PASSWORD_DEFAULT);
$sql="UPDATE users SET email=COALESCE(?,email), password=COALESCE(?,password), 
    program=COALESCE(?,program) WHERE id=?";
    $stmt=$conn->prepare($sql);
    $stmt->execute([
        $email,$hashPassword,$program,$id
    ]);
    if($stmt->rowCount()==0){
        http_response_code(400);
        echo json_encode([
             "status"=>"failed",
        "message"=>"No Record for this Id"
        ]);
    }
    else {
        echo json_encode([
             "status"=>"Success",
        "message"=>"Account is Updated"
        ]);
    }
}

catch(PDOException $e) {
    echo json_encode([
        "status"=>"failed",
        "message"=>$e->getMessage()
    ]);
}



?>