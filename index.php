<?php
 session_start();
// database conncetion
require_once './src/dbconn.php';

//     $base_url = '/Finance'; // Define your base URL here
//     if (isset($_SESSION['user'])) {
//         $role = $_SESSION['user']['role'];
//         $current_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // get the current path

//         // Define the keywords for each role
//         $keywords = [
//             'Product Order' => ['/po/'],
//             'Human Resources' => ['/hr/'],
//             'Point of Sales' => ['/sls/'],
//             'Inventory' => ['/inv/'],
//             'Finance' => ['/fin/'],
//             'Delivery' => ['/dlv/'],
//         ];

//         // Check if the role exists in the keywords array
//         if (isset($keywords[$role])) {
//             $allowed = false;
//             foreach ($keywords[$role] as $keyword) {
//                 if (strpos($current_path, $keyword) !== false) {
//                     // The path contains one of the keywords for this role
//                     $allowed = true;
//                     break;
//                 }
//             }

//             if (!$allowed) {
//                 // The path does not contain any of the keywords for this role
//                 // Redirect to a default page
//                 $target_path = '';
//                 switch ($role) {
//                     case 'Product Order':
//                         $target_path = "$base_url/po/dashboard";
//                         break;
//                     case 'Human Resources':
//                         $target_path = "$base_url/hr/employees";
//                         break;
//                     case 'Point of Sales':
//                         $target_path = "$base_url/sls/Dashboard";
//                         break;
//                     case 'Inventory':
//                         $target_path = "$base_url/inv/dashboard";
//                         break;
//                     case 'Finance':
//                         $target_path = "$base_url/fin/dashboard";
//                         break;
//                     case 'Delivery':
//                         $target_path = "$base_url/dlv/dashboard";
//                         break;
//                     default:
//                         $target_path = "$base_url/";
//                         break;
//                 }
//             }
//         } else {
//             session_destroy();
//             // The role does not exist in the keywords array
//             // Redirect to a default page
//             $target_path = "$base_url/";
//             if ($current_path != $target_path) {
//                 header("Location: $target_path");
//                 exit();
//             }
//         }
//     } else {
//         // If the user is not logged in, redirect to the login page
//         $target_path = "$base_url/";
//         if ($current_path != $target_path) {
//             header("Location: $target_path");
//             exit();
//         }
//     }
// }


// router
require_once './router.php';

// routes
require_once './web.php';


Router::post('/login', function(){
    $db = Database::getInstance();
    $conn = $db->connect();

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM account_info WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = array();
        // Password is correct
        $_SESSION['user']['account_id'] = $user['id'];
        $_SESSION['user']['username'] = $user['username'];
        $_SESSION['user']['role'] = $user['role'];
        $_SESSION['user']['employee_id'] = $user['employees_id'];

        //redirects to the right page
        if ($user['role'] == 'Product Order') {
            header("Location: /Finance/po/dashboard");
            exit();
        } 
        if ($user['role'] == 'Human Resources') {
            header("Location: /Finance/hr/employees");
            exit();
        } 
        if ($user['role'] == 'Point of Sales') {
            header("Location: /Finance/sls/Dashboard");
            exit();
        } 
        if ($user['role'] == 'Inventory') {
            header("Location: /Finance/inv/main");
            exit();
        } 
        if ($user['role'] == 'Finance') {
            header("Location: /Finance/fin/dashboard");
            exit();
        } 
        if ($user['role'] == 'Delivery') {
            header("Location: /Finance/dlv/dashboard");
            exit();
        } 
    } else {
        header("Location: /Finance/?error=1");
        exit();
    }
});

Router::post('/logout', function(){
    session_destroy();
    header("Location: /Finance/");
    exit();
});

// header("Location: /Finance/");



