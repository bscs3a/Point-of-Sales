<?php 
// require_once './src/dbconn.php';

// try {
//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//         $firstName = $data['firstName'];
//         $lastName = $data['lastName'];
        
//         $db = Database::getInstance();
//         $conn = $db->connect();
    
//         $query = "INSERT INTO test_table (first_name, last_name) VALUES (:firstName, :lastName)";
//         $stmt = $conn->prepare($query);
//         $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
//         $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
    
//         $stmt->execute();
//     }
// } catch (PDOException $e) {
//   echo "Error: " . $e->getMessage();
// }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
  <link href="./../src/tailwind.css" rel="stylesheet">
  <title>TEST</title>
</head>
<body class="text-gray-800 font-sans">

<!-- sidenav -->
<?php 
  include 'inc/sidenav.php';
?>
<!-- end of sidenav -->

<!-- Start Main Bar -->
<main id="mainContent" class="w-full md:w-[calc(100%-256px)] md:ml-64 min-h-screen transition-all main">
  <!-- Top Bar -->
  <div class="py-2 px-6 bg-white flex items-center shadow-md shadow-black/10">
   <button type="button" class="text-lg text-gray-600 sidebar-toggle">
  <i class="ri-menu-line"></i>
   </button>
   <ul class="flex items-center text-sm ml-4">  
  <li class="mr-2">
    <a route="/hr/dashboard" class="text-[#151313] hover:text-gray-600 font-medium">Human Resources</a>
  </li>
  <li class="text-[#151313] mr-2 font-medium">/</li>
  <a href="#" class="text-[#151313] mr-2 font-medium hover:text-gray-600">TEST</a>
   </ul>
   <ul class="ml-auto flex items-center">
  <li class="mr-1">
    <a href="#" class="text-[#151313] hover:text-gray-600 text-sm font-medium">Sample User</a>
  </li>
  <li class="mr-1">
    <button type="button" class="w-8 h-8 rounded justify-center hover:bg-gray-300"><i class="ri-arrow-down-s-line"></i></button> 
  </li>
   </ul>
  </div>
  <!-- End Top Bar -->

  <?php 
    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //     require_once './public/humanResources/func/test-add.php';
    //     insertEmployee($_POST);
    // }
  ?>
  <h3 class="ml-6 mt-8 text-xl font-bold">TEST ADD</h3>
  <form action="/add" method="POST">
  <label for="firstName">First Name:</label><br>
  <input type="text" id="firstName" name="firstName"><br><br>
  <label for="lastName">Last Name:</label><br>
  <input type="text" id="lastName" name="lastName"><br><br>

  <input type="submit" value="Submit">
</form>

<table>
  <tr><th>Name</th></tr>
  <?php
    $db = Database::getInstance();
    $conn = $db->connect();

    $stmt = $conn->prepare("SELECT * FROM test_table");
    
    // Execute the statement
    $stmt->execute();

    // Fetch all rows as an associative array
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Iterate over the names
    foreach ($users as $user) {
        // Access the name and id of the row and add it to the table
        // Also add a hyperlink to the /hr/test/{id} route with the id as a parameter
        echo "<tr><td><a route='/hr/test/id=" . $user['id'] . "'>" . $user['first_name'] . "</a></td></tr>";
    }
  ?>
</table>

</main>
<!-- End Main Bar -->
<script  src="./../src/route.js"></script>
<script  src="./../src/form.js"></script>

<!-- Sidebar active/inactive -->
<script>
  document.querySelector('.sidebar-toggle').addEventListener('click', function() {
    document.getElementById('sidebar-menu').classList.toggle('hidden');
    document.getElementById('sidebar-menu').classList.toggle('transform');
    document.getElementById('sidebar-menu').classList.toggle('-translate-x-full');
    document.getElementById('mainContent').classList.toggle('md:w-full');
    document.getElementById('mainContent').classList.toggle('md:ml-64');
  });
</script>
</body>
</html> 