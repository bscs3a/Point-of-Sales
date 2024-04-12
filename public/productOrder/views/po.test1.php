<?php
// Print GET parameters for debugging
print_r($_GET);
var_dump($_GET);

error_reporting(E_ALL);
ini_set('display_errors', 1); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagination Example</title>
    <style>
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
        }
        .pagination li {
            margin-right: 10px;
        }
        .pagination a {
            text-decoration: none;
            color: #333;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .pagination a.active {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pagination Example</h1>
        <ul class="pagination">
            <?php
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
            $totalPages = 10; // Change this to the total number of pages you have
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<li><a href="/master/po/test1/pagenumber=' . $i . '" class="' . ($currentPage == $i ? 'active' : '') . '">' . $i . '</a></li>';
            }
            ?>
        </ul>
    </div>
    <script src="./../src/route.js"></script>
<script src="./../src/form.js"></script>
</body>
</html>
