<?php

require_once './src/dbconn.php';

function insertEmployee($data) {
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    
    $db = Database::getInstance();
    $conn = $db->connect();

    $query = "INSERT INTO test_table (first_name, last_name) VALUES (:firstName, :lastName)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
    $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);

    $stmt->execute();
}