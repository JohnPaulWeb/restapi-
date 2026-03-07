<?php

// ito yung Response ng URL
if(empty($id)){
    http_response_code(400);
    echo json_encode([
        "status" => "failed",
        "message" => "Missing ID"
    ]);
    exit();
}

// ito yung  MYSQL

try{
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$result){
        http_response_code(404);
        echo json_encode([
            "status" => "failed",
            "message" => "User not found"
        ]);
    } else {
        http_response_code(200);
        echo json_encode($result);
    }
}
catch(PDOException $e){
    echo json_encode([
        "status" => "failed",
        "message" => $e->getMessage()
    ]);
}
?>