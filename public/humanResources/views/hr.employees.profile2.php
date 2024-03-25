<?php
    // Check if the id is set in the URL
    // Start a new session or resume the existing one
    if (isset($_SESSION['id'])) {
        // Get the id from the session
        $id = $_SESSION['id'];

        $db = Database::getInstance();
        $conn = $db->connect();

        // Prepare the SQL statement
        $query = "SELECT employees.*, employment_info.*, salary_info.*, tax_info.*, benefit_info.*, account_info.* FROM employees
        LEFT JOIN employment_info ON employment_info.employees_id = employees.id
        LEFT JOIN salary_info ON salary_info.employees_id = employees.id
        LEFT JOIN tax_info ON tax_info.employees_id = employees.id
        LEFT JOIN benefit_info ON benefit_info.employees_id = employees.id
        LEFT JOIN account_info ON account_info.employees_id = employees.id
        WHERE employees.id = :id;";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $employees = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Employee doesn't exist";
    }
    
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
  <link href="./../../src/tailwind.css" rel="stylesheet">
  <title>Profile</title>
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
  <a href="#" class="text-[#151313] mr-2 font-medium hover:text-gray-600">Profile</a>
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

  <h3 class="ml-6 mt-8 text-xl font-bold">Profile</h3>

<!-- Profile-->
  <div class="py-2 px-6">
      <div class="flex flex-wrap">
        <div class="mr-4">
          <img src="<?php echo htmlspecialchars($employees['image_url']); ?>" alt="Profile Picture" class="mt-4 w-48 h-48 object-cover">
          <span>
            <div class="ml-4 mb-20 mt-4"> 
              <button type="button" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900"
              route="/hr/employees/update">Edit</button>
              <button type="button" class="focus:outline-none text-gray-700 bg-white hover:bg-white focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">Delete</button>
            </div>     
          </span>
        </div>
<!-- ----- -->

<!-- <div class="flex flex-col ml-20">
  <div class="mt-26">
    <div class="flex">
      <div class="mr-2"> -->
  <!-- <table class="min-w-full">
    
      <thead>
        <tr>
          <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
            First Name</th>
          <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
            Middle Name</th>
          <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
            Last Name</th>
        </tr>
      </thead>
        <tbody class="bg-white">
          <tr>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
              <div class="flex items-center">
                <div class="ml-4">
              <span class="text-sm leading-5 text-gray-900">Ziggy</span>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
              <span class="text-sm leading-5 text-gray-900">Castro</span>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
              <div class="text-sm leading-5 text-gray-900">Co</div>
            </td>
          </tr>
        </tbody>
      </table> -->
      
  <!-- <table class="min-w-full">
    
      <thead>
        <tr>
          <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
            Date of Birth</th>
          <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
            Gender</th>
          <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
            Nationality</th>
        </tr>
      </thead>
      
        <tbody class="bg-white">
          <tr>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
              <div class="flex items-center">
                <div class="ml-4">
              <span class="text-sm leading-5 text-gray-900">12/19/2001</span>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
              <span class="text-sm leading-5 text-gray-900">Female</span>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
              <div class="text-sm leading-5 text-gray-900">Filipino</div>
            </td>
          </tr>
        </tbody>
      </table> -->
      <!-- </div>
    </div>
  </div>
</div> -->
          <!-- ----- -->
      <!-- Employee Information -->
    
            <div class="flex flex-col ml-20">
              <div class="mt-26">
                <div class="flex">
                  <div class="mr-2">
                    <h2 class="block mb-4 mt-2 text-sm font-bold text-gray-700">
                      First Name
                    </h2>
                    <h2 class="block mb-2 mt-0 text-sm font-medium text-gray-500">
                    <?php echo htmlspecialchars($employees['first_name']); ?>
                    </h2>
                  </div>
                  <div class="mr-2">
                    <h2 class="block mb-2 mt-2 ml-20 text-sm font-bold text-gray-700">
                      Middle Name
                    </h2>
                    <h2 class="block mb-2 mt-4 text-sm ml-20 font-medium text-gray-500">
                    <?php echo htmlspecialchars($employees['middle_name']); ?>
                    </h2>
                  </div>
                  <div>
                    <h2 class="block mb-2 mt-2 ml-20 text-sm font-bold text-gray-700">
                    Last Name
                  </h2>
                  <h2 class="block mb-2 mt-4 text-sm ml-20 font-medium text-gray-500">
                  <?php echo htmlspecialchars($employees['last_name']); ?>
                  </h2>
                </div>
                </div>
              </div>
              <!--Column 2-->
              <div class="mt-26">
                <div class="flex">
                  <div class="mr-2">
                <h2 class="block mb-4 mt-2 text-sm font-bold text-gray-700">
                  Date of Birth
                </h2>
                <h2 class="block mb-2 mt-4 text-sm font-medium text-gray-500">
                <?php echo htmlspecialchars($employees['dateofbirth']); ?>
                </h2>
                </div>
                <div>
                  <h2 class="block mb-4 mt-2 ml-20 text-sm font-bold text-gray-700">
                    Gender</h2>
                  <h2 class="block mb-2 mt-4 ml-20 text-sm font-medium text-gray-500"> 
                  <?php echo htmlspecialchars($employees['gender']); ?>
                  </h2>
                </div>
                <div>
                  <h2 class="block mb-2 mt-2 ml-20 text-sm font-bold text-gray-700">
                  Nationality
                  </h2>
                  <h2 class="block mb-2 mt-4 ml-20 text-sm font-medium text-gray-500">
                  <?php echo htmlspecialchars($employees['nationality']); ?>
                  </h2>
                </div>
            </div>
          </div>
          <!-- Column 2-->
          <div class="mt-26">
            <div class="flex">
              <div class="mr-2">
            <h2 class="block mb-4 mt-2 text-sm font-bold text-gray-700">
              Civil Status
            </h2>
            <h2 class="block mb-2 mt-4 text-sm font-medium text-gray-500">
            <?php echo htmlspecialchars($employees['civil_status']); ?>
            </h2>
            </div>
            <div>
              <h2 class="block mb-4 mt-2 ml-20 text-sm font-bold text-gray-700">
                Address</h2>
              <h2 class="block mb-2 mt-4 ml-20 text-sm font-medium text-gray-500"> 
              <?php echo htmlspecialchars($employees['address']); ?>
              </h2>
            </div>
            <div>
              <h2 class="block mb-2 mt-2 ml-20 text-sm font-bold text-gray-700">
              Contact Number
              </h2>
              <h2 class="block mb-2 mt-4 ml-20 text-sm font-medium text-gray-500">
              <?php echo htmlspecialchars($employees['contact_no']); ?>
              </h2>
            </div>
        </div>
      </div>
      <!--Column 3-->
      <div class="mt-26">
        <div class="flex">
          <div class="mr-2">
        <h2 class="block mb-4 mt-2 text-sm font-bold text-gray-700">
          Email
        </h2>
        <h2 class="block mb-2 mt-4 text-sm font-medium text-gray-500">
        <?php echo htmlspecialchars($employees['email']); ?>
        </h2>
        </div>
        <div>
          <h2 class="block mb-4 mt-2 ml-20 text-sm font-bold text-gray-700">
            Department</h2>
          <h2 class="block mb-2 mt-4 ml-20 text-sm font-medium text-gray-500"> 
          <?php echo htmlspecialchars($employees['department']); ?>
          </h2>
        </div>
        <div>
          <h2 class="block mb-2 mt-2 ml-20 text-sm font-bold text-gray-700">
          Position
          </h2>
          <h2 class="block mb-2 mt-4 ml-20 text-sm font-medium text-gray-500">
          <?php echo htmlspecialchars($employees['position']); ?>
          </h2>
        </div>
    </div>
  </div>
      <!--EMPLOYMENT INFO-->
      <div class="mt-26">
        <div class="flex">
          <div class="mr-2">
        <h2 class="block mb-4 mt-2 text-sm font-bold text-gray-700">
          Date of Hire
        </h2>
        <h2 class="block mb-2 mt-4 text-sm font-medium text-gray-500">
        <?php echo htmlspecialchars($employees['dateofhire']); ?>
        </h2>
        </div>
        <div>
          <h2 class="block mb-4 mt-2 ml-20 text-sm font-bold text-gray-700">
          Start of Employment</h2>
          <h2 class="block mb-2 mt-4 ml-20 text-sm font-medium text-gray-500"> 
          <?php echo htmlspecialchars($employees['startdate']); ?>
          </h2>
        </div>
        <div>
          <h2 class="block mb-2 mt-2 ml-20 text-sm font-bold text-gray-700">
          End of Employment
          </h2>
          <h2 class="block mb-2 mt-4 ml-20 text-sm font-medium text-gray-500">
          <?php echo htmlspecialchars($employees['enddate']); ?>
          </h2>
        </div>
    </div>
  </div>
  <!--Column 4-->
    <div>
      <h2 class="block mb-2 mt-8 text-base font-bold text-gray-700">Salary Information and Tax Information</h2>
    </div>
    <div class="mt-26">
      <div class="flex">
        <div class="mr-2">
      <h2 class="block mb-4 mt-2 text-sm font-bold text-gray-700">
        Monthly Salary
      </h2>
      <h2 class="block mb-2 mt-4 text-sm font-medium text-gray-500">
        ₱ <?php echo htmlspecialchars($employees['monthly_salary']); ?>
      </h2>
      </div>
      <div>
        <h2 class="block mb-4 mt-2 ml-20 text-sm font-bold text-gray-700">
          Income Tax</h2>
        <h2 class="block mb-2 mt-4 ml-20 text-sm font-medium text-gray-500"> 
          ₱ <?php echo htmlspecialchars($employees['income_tax']); ?>
        </h2>
      </div>
      <div>
        <h2 class="block mb-2 mt-2 ml-20 text-sm font-bold text-gray-700">
          Withholding tax
        </h2>
        <h2 class="block mb-2 mt-4 ml-20 text-sm font-medium text-gray-500">
          ₱ <?php echo htmlspecialchars($employees['withholding_tax']); ?>
        </h2>
      </div>
  </div>
  </div>
  <!-- Column 5-->
  <div class="mt-26">
    <div class="flex">
      <div class="mr-2">
    <h2 class="block mb-4 mt-2 text-sm font-bold text-gray-700">
      SSS
    </h2>
    <h2 class="block mb-2 mt-4 text-sm font-medium text-gray-500">
    ₱ <?php echo htmlspecialchars($employees['sss_fund']); ?>
    </h2>
    </div>
    <div>
      <h2 class="block mb-4 mt-2 ml-20 text-sm font-bold text-gray-700">
        Pag-IBIG Fund</h2>
      <h2 class="block mb-2 mt-2 ml-20 text-sm font-medium text-gray-500"> 
      ₱ <?php echo htmlspecialchars($employees['pagibig_fund']); ?>
      </h2>
    </div>
    <div>
      <h2 class="block mb-2 mt-2 ml-20 text-sm font-bold text-gray-700">
      Philhealth
      </h2>
      <h2 class="block mb-2 mt-4 ml-20 text-sm font-medium text-gray-500">
      ₱ <?php echo htmlspecialchars($employees['philhealth']); ?>
    </div>
  </div>
  </div>
  <!-- Column 6-->
  <div class="mt-26">
  <div class="flex">
  <div class="mr-2">
  <h2 class="block mb-4 mt-2 text-sm font-bold text-gray-700">
  13th Month Pay
  </h2>
  <h2 class="block mb-2 mt-4 text-sm font-medium text-gray-500">
  ₱ <?php echo htmlspecialchars($employees['thirteenth_month']); ?>
  </h2>
  </div>
  <div>
  <h2 class="block mb-4 mt-2 ml-20 text-sm font-bold text-gray-700">
  Total Salary</h2>
  <h2 class="block mb-2 mt-4 ml-20 text-sm font-medium text-gray-500"> 
  ₱ <?php echo htmlspecialchars($employees['total_salary']); ?>
  </h2>
  </div>
  </div>
  </div>
  <!--Account Information-->
    <div>
      <h2 class="block mb-2 mt-8 text-base font-bold text-gray-700">Account Information</h2>
    </div>
    <div class="mt-26">
      <div class="flex">
        <div class="mr-2">
      <h2 class="block mb-4 mt-2 text-sm font-bold text-gray-700">
        Username
      </h2>
      <h2 class="block mb-2 mt-4 text-sm font-medium text-gray-500">
      <?php echo htmlspecialchars($employees['username']); ?>
      </h2>
      </div>
      <div>
        <h2 class="block mb-4 mt-2 ml-20 text-sm font-bold text-gray-700">
          Password</h2>
        <h2 class="block mb-2 mt-4 ml-20 text-sm font-medium text-gray-500"> 
        <?php echo htmlspecialchars($employees['password']); ?>
        </h2>
      </div>
  </div>
  </div>
        </div>
      </div>
  </div>
 

</main>
<!-- End Main Bar -->
<script  src="./../../src/route.js"></script>
<script  src="./../../src/form.js"></script>

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