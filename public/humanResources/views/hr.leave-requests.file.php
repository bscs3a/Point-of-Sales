<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
  <link href="./../../src/tailwind.css" rel="stylesheet">
  <title>File a Leave</title>
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
  <a route="/hr/leave-requests" class="text-[#151313] mr-2 font-medium hover:text-gray-600">Leave Requests</a>
  <li class="text-[#151313] mr-2 font-medium">/</li>
  <a href="#" class="text-[#151313] mr-2 font-medium hover:text-gray-600">File a Leave</a>
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

  <!-- Request For Leave -->
  <div class="flex ml-20 mt-8 font-bold text-xl ">
    <h1>Request For Leave</h1>
   </div>
   <div class="flex flex-col ml-20">
    <!-- Column 1-->
  <div class="flex flex-col">
  <div class="mb-4 mt-8">
    <div class="flex">
      <div class="mr-2">
        <label class="block mb-2 mt-0 text-sm font-bold text-gray-700" for="middleName">
          Employee
        </label>
        <select
        class="w-64 px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
        name="employee" id="employee">
            <option value="">Select Employee</option>
            <?php
              $db = Database::getInstance();
              $conn = $db->connect();
              $query = "SELECT id, first_name, middle_name, last_name FROM employees";
              $stmt = $conn->prepare($query);
              $stmt->execute();
              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $fullName = $row['first_name'];
                  if (!empty($row['middle_name'])) {
                      $fullName .= ' ' . substr($row['last_name'], 0, 1) . '.';
                  }
                  $fullName .= ' ' . $row['last_name'];
                  echo "<option value='{$row['id']}'>{$fullName}</option>";
              }
            ?>
        </select>
      </div>
      <div class="mr-2">
        <label class="block mb-2 mt-0 text-sm font-bold text-gray-700" for="middleName">
          Department
        </label>
        <select
        class="w-64 px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
        name="department" id="department">
            <option value="">Select Department</option>
            <option value="Product Order">Product Order</option>
            <option value="Inventory">Inventory</option>
            <option value="Delivery">Delivery</option>
            <option value="Human Resources">Human Resources</option>
            <option value="Point of Sales">Point of Sales</option>
            <option value="Finance">Finance/Accounting</option>
        </select>
      </div>
      <div class="mr-2">
        <label class="block mb-2 mt-0 text-sm font-bold text-gray-700" for="firstName">
          Position
        </label>
        <select
          class="w-64 px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
          name="position" id="position">
            <option value="">Select Position</option>
          </select>
      </div>
  </div>
  <!-- Details of Leave -->
  <div class="flex  mt-8 font-bold text-xl ">
      <h1>Details of Leave</h1>
      </div>
      <div class="flex flex-col">
      <div class="mb-4 mt-8">
        <div class="flex">
          <div class="mr-2">
            <label class="block mb-2 mt-0 text-sm font-bold text-gray-700" for="firstName">
              Start Date
            </label>
            <input
              class="w-64 px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
              id="startdate"
              type="date"
            />
          </div>
          <div class="mr-2">
            <label class="block mb-2 mt-0 text-sm font-bold text-gray-700" for="middleName">
              End Date
            </label>
            <input
              class="w-64 px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
              id="enddate"
              type="date"
            />
          </div>
          <div class="mr-2">
            <label class="block mb-2 mt-0 text-sm font-bold text-gray-700" for="middleName">
              Type of Leave       
            </label>
            <select
            class="w-64 px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
            name="typeOfLeave" id="typeOfLeave">
            <option value="">Select Type of Leave</option>
            <option value="Sick Leave">Sick Leave</option>
            <option value="Vacation Leave">Vacation Leave</option>
            <option value="5 Days Forced Leave">5 Days Forced Leave</option>
            <option value="Special Privilege Leave">Special Privilege Leave</option>
            <option value="Maternity Leave">Maternity Leave</option>
            <option value="Paternity Leave">Paternity Leave</option>
            <option value="Parental Leave">Parental Leave</option>
            <option value="Rehabilitation Leave">Rehabilitation Leave</option>
            <option value="Special Leave (for women)">Special Leave (for women)</option>
            <option value="Study Leave">Study Leave</option>
            <option value="Terminal Leave">Terminal Leave</option>
            <option value="Special Emergency Leave">Special Emergency Leave</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Description-->
      <div class="mt-4">
    <label for="details" class="block mb-2 text-sm font-bold text-gray-900">Description</label>
    <textarea id="details" rows="8" style="resize: none;" class="mr-7 mt-4 block px-4 py-4 p-2.5 w-full sm:w-[780px] text-sm text-gray-700 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500  dark:focus:ring-blue-500 dark:focus:border-blue-500" maxlength="255"></textarea>
    <div id="charCount" class="text-sm text-gray-500">255 characters left</div>
</div>
<script>
  // Details 255 CHARACTERS
  document.getElementById('details').addEventListener('input', function() {
      var remaining = 255 - this.value.length;
      document.getElementById('charCount').textContent = remaining + ' characters left';
  });
</script>

  <!-- BUTTONS -->
  <span class="mt-4">   
    <button route="/hr/leave-requests/file-leave" type="button" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">Submit</button>
    <button route="/hr/leave-requests" type="button" class="focus:outline-none text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">Cancel</button>
  </span>
  </div>
  </div>
</main>
<!-- End Main Bar -->
<script  src="./../../src/route.js"></script>
<script  src="./../../src/form.js"></script>
<script type="module" src="../public/humanResources/js/sidenav-active-inactive.js"></script>

<script>
  // Sidebar Toggle
  document.querySelector('.sidebar-toggle').addEventListener('click', function() {
    document.getElementById('sidebar-menu').classList.toggle('hidden');
    document.getElementById('sidebar-menu').classList.toggle('transform');
    document.getElementById('sidebar-menu').classList.toggle('-translate-x-full');
    document.getElementById('mainContent').classList.toggle('md:w-full');
    document.getElementById('mainContent').classList.toggle('md:ml-64');
  });

   // DEPARTMENT AND POSITION DROPDOWN
   document.getElementById('Department').addEventListener('change', function() {
  var positionSelect = document.getElementById('Position');
  var department = this.value;

  // Clear the position select
  positionSelect.innerHTML = '<option value="">Select Position</option>';

  // Define the positions for each department
  var positions = {

      'Product Order': [
        'Order Processor',
        'Order Entry Clerk',
        'Quality Control Inspector',
        'Logistics Coordinator',
        'Procurement Specialist'
      ],

      'Inventory': [
        'Inventory Manager/Controller',
        'Inventory Planner',
        'Stock Controller',
        'Purchasing Manager',
        'Warehouse Manager',
        'Materials Manager'
      ],

      'Delivery': [
        'Delivery Driver',
        'Courier',
        'Warehouse Associate',
        'Customer Service Representative',
        'Parcel Sorter'
      ],

      'Human Resources': [
        'Recruiter',
        'HR Manager/Director',
        'Compensation and Benefits Specialist',
        'HR Coordinator',
        'HR Legal Compliance Specialist'
      ],

      'Point of Sales': [
        'Retail Associate/Cashier',
        'Inventory Control Specialist',
        'Sales Associate',
        'Customer Service Representative',
        'Business Analyst',
        'E-commerce Coordinator'
      ],

      'Finance': [
        'Accountant',
        'Bookkeeper',
        'Financial Analyst',
        'Tax Accountant',
        'Cost Accountant',
        'Credit Analyst',
        'Payroll Specialist'
      ]
  };
});
</script>
</body>
</html> 