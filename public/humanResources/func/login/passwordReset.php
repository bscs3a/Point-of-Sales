<?php 

require_once 'src/dbconn.php';

function passwordReset($account_id){
    $db = Database::getInstance();
    $conn = $db->connect();

    $passwordLength = random_int(7, 12);
    $password = substr(bin2hex(random_bytes(12)), 0, $passwordLength);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE account_info SET password = :password WHERE account_id = :id");
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':id', $account_id);
    try{
        $stmt->execute();
    }catch(PDOException $e){
        echo $e->getMessage();
    }
    return $password; 
}