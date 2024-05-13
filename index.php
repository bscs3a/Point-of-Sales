<?php
 session_start();
// database conncetion
require_once './src/dbconn.php';

// router
require_once './router.php';

// routes
require_once './web.php';

//for login guarding
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    if (isset($_SESSION['user'])) {
        $role = $_SESSION['user']['role'];
        $url = $_SERVER['REQUEST_URI']; // get the current URL

        // Define the keywords for each role
        $keywords = [
            'Product Order' => ['/po/'],
            'Human Resources' => ['/hr/'],
            'Point of Sales' => ['/sls/'],
            'Inventory' => ['/inventory/'],
            'Finance' => ['/fin/'],
            'Delivery' => ['/delivery/'],
        ];

        // Check if the role exists in the keywords array
        if (isset($keywords[$role])) {
            $allowed = false;
            foreach ($keywords[$role] as $keyword) {
                if (strpos($url, $keyword) !== false) {
                    // The URL contains one of the keywords for this role
                    $allowed = true;
                    break;
                }
            }

            if (!$allowed) {
                // The URL does not contain any of the keywords for this role
                // Redirect to a default page
                switch ($role) {
                    case 'Product Order':
                        header("Location: /po/dashboard");
                        break;
                    case 'Human Resources':
                        header("Location: /hr/dashboard");
                        break;
                    case 'Point of Sales':
                        header("Location: /sls/dashboard");
                        break;
                    case 'Inventory':
                        header("Location: /inventory/dashboard");
                        break;
                    case 'Finance':
                        header("Location: /fin/dashboard");
                        break;
                    case 'Delivery':
                        header("Location: /delivery/dashboard");
                        break;
                    default:
                        header("Location: /");
                        break;
                }
                exit();
            }
        } else {
            // The role does not exist in the keywords array
            // Redirect to a default page
            header("Location: /");
            exit();
        }
    } else {
        // If the user is not logged in, redirect to the login page
        header("Location: /");
        exit();
    }
}
// header("Location: /Finance/");



