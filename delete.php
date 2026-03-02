<?php 
if(empty($id)){
    http_response_code(400);
    echo json_encode(
        ["status"=>"failed","message"=>"Account is deleted"]
    );
    exit();
}

    // ito naman yung not found
try{
    $sql="DELETE FROM users where id=?";
    $stmt=$conn->prepare($sql);
    $stmt->execute([
        $id
    ]);
      if($stmt->rowCount()==0){
        http_response_code(400);
        echo json_encode([
            "status"=>"failed",
            "message"=>"No Record for this ID"
        ]);

    }
    // ito yung message once nag success yung account mo 
    else{
        http_response_code(200);
        echo json_encode([
            "status"=>"success",
            "message"=>"Account is Deleted"
        ]);
    }
//  ito naman yung PDOException
}
catch(PDOException $e){
    echo json_encode([
        "status"=>"failed",
        "message"=>$e->getMessage()
    ]);
}





?>