<?php 
require "./public/finance/routes.php";
require "./public/sales/routes.php";
require "./public/delivery/routes.php";
require "./public/humanResources/routes.php";
require "./public/inventory/routes.php";
require "./public/admin/routes.php";
require "./public/productOrder/routes.php";

$default = [
    '/' => "./src/landing.php",
    '/404' => "./src/error.php",
];

$routes = array_merge($sls, $fin, $inv, $dlv, $hr, $po, $default);

Router::setRoutes($routes);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$basePath = '/Finance'; // change me according to your root folder name
$path = str_replace($basePath, '', $path);

// for login guarding
// Get the user's role from the session
$role = isset($_SESSION['user']) ? $_SESSION['user']['role'] : null;

// Define the URLs for each role
$keywords = [
    'Product Order' => ['url' => '/po/', 'default' => '/po/dashboard'],
    'Human Resources' => ['url' => '/hr/', 'default' => '/hr/dashboard'],
    'Point of Sales' => ['url' => '/sls/', 'default' => '/sls/Dashboard'],
    'Inventory' => ['url' => '/inv/', 'default' => '/inv/main'],
    'Finance' => ['url' => '/fin/', 'default' => '/fin/dashboard'],
    'Delivery' => ['url' => '/dlv/', 'default' => '/dlv/dashboard'],
];

if ($role === null || !isset($keywords[$role]) ) {
    $path = '';
} else {
    if (strpos($currentUri, $keywords[$role]['url']) === false) {
        $path = $keywords[$role]['default'];
    }
}
// end guard login

foreach ($routes as $route => $action) {
    if (strpos($route, '{') !== false) {
        // This is a dynamic route
        $pattern = str_replace('{id}', '(\d+)', $route);
        if (preg_match("#^$pattern$#", $path, $matches)) {
            // Call the action with the id as a parameter
            $action($matches[1]);
            exit();
        }
    } else if ($path === $route || $path === $route . '/') {
        // This is a static route
        include $action;
        exit();
    }
}

$currentUri = $_SERVER['REQUEST_URI'];
Router::handle('GET', $currentUri);