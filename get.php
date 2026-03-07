<?php

// ito yung SQL ng GET ALL USERS
try{
$sql="SELECT * FROM users";
$stmt=$conn->prepare($sql);
$stmt->execute();
$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
if($stmt->rowCount()==0){
    http_response_code(200);
    echo json_encode([
        "status"=>"success",
        "message"=>"No records found"
    ]);
}
else{
    http_response_code(200);
    echo json_encode($results);
}
}
catch(PDOException $e){
    echo json_encode([
        "status"=>"failed",
        "message"=>$e->getMessage()
    ]);
}

?>