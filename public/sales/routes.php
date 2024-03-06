<?php 

$path = './public/sales/views';

Router::handle('GET', '/sls/sample', "$path/sls.sample.php");
Router::handle('GET', '/sls/link', "$path/sls.test-link.php");
Router::handle('GET', '/sls/catalog', "$path/sls.catalog.php");
Router::handle('GET', '/sls/transaction-history', "$path/sls.transactionHistory.php");
Router::handle('GET', '/sls/transaction-details', "$path/sls.transactionDetails.php");
Router::handle('GET', '/sls/sales', "$path/sls.sales.php");
