<?php
require_once './src/dbconn.php';
// NEEDS FIX AUSHDURHFUSDHF IDK WHATS WRONG !!!!! 
// i keep redirecting to the index page and then when i click anything it says the error message for not finding the route
function searchEmployees($search) {
  $db = Database::getInstance();
  $conn = $db->connect();

  $query = "SELECT * FROM employees WHERE first_name LIKE :search OR last_name LIKE :search OR position LIKE :search OR department LIKE :search OR id LIKE :search;";
  $stmt = $conn->prepare($query);
  $searchTerm = "%" . $search . "%";
  $stmt->bindParam(":search", $searchTerm);
  $stmt->execute();
  $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return $employees;
}
