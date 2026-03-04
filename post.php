<?php 
$data=json_decode(file_get_contents("php://input"),true);
$email=$data['email']??null;
$password=$data['password']??null;
$program=$data['program']??null;
if(empty($email) || empty($password) || empty($program)){
    http_response_code(400);
    echo json_encode([
        "status"=>"failed",
        "message"=>"Missing Fields"
    ]);
    exit();
}
if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
   http_response_code(400);
    echo json_encode([
        "status"=>"failed",
        "message"=>"Invalid Email"
    ]);
    exit();
}
if(strlen($password)<8){
     http_response_code(400);
    echo json_encode([
        "status"=>"failed",
        "message"=>"Password must be 8 char long"
    ]);
    exit();
}

try{  
    $hashPassword=password_hash($password,PASSWORD_DEFAULT);
    $sql="INSERT INTO users(email,password,program) VALUES(?,?,?)";
    $stmt=$conn->prepare($sql);
    $stmt->execute([
        $email,$hashPassword,$program
    ]);
    http_response_code(201);
    echo json_encode([
        "status"=>"success",
        "message"=>"Account Created"
    ]);
}
catch(PDOException $e){
     echo json_encode([
        "status"=>"failed",
        "message"=>$e->getMessage()
    ]);
}

?>