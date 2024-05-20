<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
  <link href="./../src/tailwind.css" rel="stylesheet">
  <title>Dashboard</title>
</head>

<body class="text-gray-800 font-sans">
 
<!-- sidenav -->
<?php 
  require_once 'inc/sidenav.php';
?>
<!-- end of sidenav -->

<!-- Start Main Bar -->
<main id = "mainContent" class="w-full md:w-[calc(100%-256px)] md:ml-64 min-h-screen transition-all main">
  <div class="py-2 px-6 bg-white flex items-center shadow-md shadow-black/10">
   <button type="button" class="text-lg text-gray-600 sidebar-toggle">
  <i class="ri-menu-line"></i>
   </button>
   <ul class="flex items-center text-sm ml-4">  
  <li class="mr-2">
    <a href="#" class="text-[#151313] hover:text-gray-600 font-medium">Human Resources</a>
  </li>
  <li class="text-[#151313] mr-2 font-medium">/</li>
  <a href="#" class="text-[#151313] mr-2 font-medium hover:text-gray-600">Dashboard</a>
   </ul>
   <ul class="ml-auto flex items-center">
   <li class="mr-1">
   <?php
    $db = Database::getInstance();
    $conn = $db->connect();

    $username = $_SESSION['user']['username'];

    // Fetch the employees_id based on the username
    $stmt = $conn->prepare("SELECT employees_id FROM account_info WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $employees_id = $user['employees_id'];

    // Use the current date for attendance_date
    date_default_timezone_set('Asia/Manila');
    $attendance_date = date('Y-m-d');

    // Check if a row exists for the current date and employees_id
    $stmt = $conn->prepare("SELECT * FROM attendance WHERE attendance_date = :attendance_date AND employees_id = :employees_id");
    $stmt->execute([
        ':attendance_date' => $attendance_date,
        ':employees_id' => $employees_id,
    ]);
    $attendance = $stmt->fetch(PDO::FETCH_ASSOC);

    $pdo=null;
    $stmt=null;

    $stmt = $conn->prepare("SELECT * FROM attendance WHERE attendance_date = :attendance_date AND employees_id = :employees_id AND clock_out IS NULL");
    $stmt->execute([
        ':attendance_date' => $attendance_date,
        ':employees_id' => $employees_id,
    ]);
    $clockOut = $stmt->fetch(PDO::FETCH_ASSOC);

    $pdo=null;
    $stmt=null;
    ?>

    <?php if (!$attendance): ?>
        <form method="post" action="/clock-in">
            <button id="clockInButton" type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded">Clock In</button>
        </form>
    <?php elseif ($clockOut): ?>
        <form method="post" action="/clock-out">
            <button id="clockOutButton" type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">Clock Out</button>
        </form>
    <?php elseif (!$clockOut): ?>
        <button id="workDoneButton" type="button" class="bg-gray-300 text-black px-2 py-1 rounded">See You Tomorrow!</button>
    <?php endif; ?>

    </li>

    <div class="ml-3 h-6 w-px mr-3 bg-gray-300"></div>

   <li class="mr-1">
  <?php
  $username = $_SESSION['user']['username'];
  ?>
    <a href="#" class="text-[#151313] hover:text-gray-600 text-sm font-medium"><?php echo $username; ?></a>
  </li>
  <li class="mr-1 relative">
    <button type="button" class="w-8 h-8 rounded justify-center hover:bg-gray-300 dropdown-btn"><i class="ri-arrow-down-s-line"></i></button>
    <div class="dropdown-content hidden absolute right-0 mt-2 w-48 bg-white border border-gray-300 divide-y divide-gray-100 rounded-md shadow-lg">
      <form method="post" action="/logout">
          <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
      </form>
    </div>
  </li>
    <script>
        document.querySelector('.dropdown-btn').addEventListener('click', function() {
            document.querySelector('.dropdown-content').classList.toggle('hidden');
        });
    </script>
   </ul>
  </div>
  
  <!-- WELCOME, USER! -->
  <?php
  $db = Database::getInstance();
  $conn = $db->connect();

  $username = $_SESSION['user']['username'];

  $stmt = $conn->prepare("SELECT employees.first_name FROM account_info 
                        JOIN employees ON account_info.employees_id = employees.id 
                        WHERE account_info.username = :username");

  $stmt->bindParam(':username', $username);
  $stmt->execute();

  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  $firstName = $user['first_name'];
  ?>
  <h1 class="ml-6 mt-4 text-4xl font-bold">Welcome, <?php echo $firstName; ?>!</h1>

  <!-- Employee  -->
  <div class="p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      
    <?php
      $db = Database::getInstance();
      $conn = $db->connect();

      $query = "SELECT COUNT(*) as total_employees FROM employees";
      $stmt = $conn->prepare($query);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $total_employees = $result['total_employees'];

      $query = "SELECT * FROM employees ORDER BY id DESC LIMIT 3";
      $stmt = $conn->prepare($query);
      $stmt->execute();
      $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/10">
      <div class="text-2xl text-center font-semibold">Total Employees</div>
      <div class="text-2xl text-center font-semibold"><?php echo $total_employees; ?></div>
    </div>
<!--  -->
      <?php
      $db = Database::getInstance();
      $conn = $db->connect();

      $query = "SELECT COUNT(*) as count FROM leave_requests WHERE CURDATE() BETWEEN start_date AND end_date AND status = 'Approved'";
      $stmt = $conn->prepare($query);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $onLeave = $result['count'];

      $pdo = null;
      $stmt = null;
      ?>
    <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/10">
      <div class="text-2xl text-center font-semibold">On Leave</div>
      <div class="text-2xl text-center font-semibold"><?php echo $onLeave; ?></div>
    </div>
<!--  -->
    <?php
    $db = Database::getInstance();
    $conn = $db->connect();

    // Query to get the total number of employees
    $queryTotal = "SELECT COUNT(*) as count FROM employees";
    $stmtTotal = $conn->prepare($queryTotal);
    $stmtTotal->execute();
    $resultTotal = $stmtTotal->fetch(PDO::FETCH_ASSOC);
    $totalCount = $resultTotal['count'];

    // Query to get the number of employees on leave
    $queryLeave = "SELECT COUNT(*) as count FROM leave_requests WHERE CURDATE() BETWEEN start_date AND end_date AND status = 'Approved'";
    $stmtLeave = $conn->prepare($queryLeave);
    $stmtLeave->execute();
    $resultLeave = $stmtLeave->fetch(PDO::FETCH_ASSOC);
    $leaveCount = $resultLeave['count'];
    
    // Query to get the number of employees on clocked in
    $queryAttendance = "SELECT COUNT(*) as count FROM attendance WHERE attendance_date = CURDATE() AND clock_out IS NULL";
    $stmtAttendance = $conn->prepare($queryAttendance);
    $stmtAttendance->execute();
    $resultAttendance = $stmtAttendance->fetch(PDO::FETCH_ASSOC);
    $attendanceCount = $resultAttendance['count'];

    // Calculate the number of employees on board
    $onBoardCount = $attendanceCount;

    $pdo = null;
    $stmtTotal = null;
    $stmtLeave = null;
    ?>
    <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/10">
      <div class="text-2xl text-center font-semibold">On Board</div>
      <div class="text-2xl text-center font-semibold"><?php echo $onBoardCount; ?></div>
    </div>
    </div>
  </div>
  <!-- Newly Hired Employees -->
  <h3 class="ml-6 mt-4 text-xl font-bold">Newly Hired Employees</h3>
  
  <?php 
    if (empty($employees)) {
        require_once 'inc/noResult.php';
    } 
    else {
        require_once 'inc/employees.table.php';
    } 
  ?>
  </div>
  
</div>
</div>
</div>
<!-- Payroll --> 
<h4 class="ml-6 mt-4 text-xl font-bold"> Payroll </h4>
<?php 
  $db = Database::getInstance();
  $conn = $db->connect();

  $search = $_POST['search'] ?? '';
  $query = "SELECT payroll.*, salary_info.*, employees.* FROM payroll";
  $query .= " 
  LEFT JOIN employees ON payroll.employees_id = employees.id
  LEFT JOIN salary_info ON salary_info.employees_id = employees.id AND payroll.salary_id = salary_info.id";

  $stmt = $conn->prepare($query);
  $stmt->execute();
  $payroll = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $pdo = null;
  $stmt = null;
  if (empty($payroll)) {
      require_once 'inc/noResult.php';
  } 
  else {
      require_once 'inc/payroll-list-dashboard.table.php';
  } 
  ?>
<!-- Chart -->
<!-- <div>
  <div class="flex items-center min-h-full max-w-full">
    <canvas id="myChart" style="height:400px;"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      const ctx = document.getElementById('myChart');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
          datasets: [{
            label: '# Employees Payroll',
            data: [25, 50, 10, 24, 100, 95, 85],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    </script>  
  </div>
</div> -->
<!-- End Chart -->
</main>
<!-- End Main Bar-->
<script  src="./../src/route.js"></script>
<script  src="./../src/form.js"></script>
<script type="module" src="../public/humanResources/js/sidenav-active-inactive.js"></script>
</body>

</html>