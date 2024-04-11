<?php
$db = Database::getInstance();
$conn = $db->connect();

$search = $_POST['search'] ?? '';
$query = "SELECT leave_requests.*, employees.image_url, employees.first_name, employees.middle_name, employees.last_name, employees.position, employees.department FROM leave_requests";
$query .= " LEFT JOIN employees ON leave_requests.employees_id = employees.id";

$params = [];

if (!empty($search)) {
  $query .= " WHERE employees.first_name = :search OR employees.last_name = :search OR employees.position = :search OR employees.department = :search OR leave_requests.id = :search OR leave_requests.type = :search OR leave_requests.employees_id = :search;";
  $params[':search'] = $search;
}

$stmt = $conn->prepare($query);
$stmt->execute($params);
$leaveRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pdo = null;
$stmt = null;
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
  <link href="./../src/tailwind.css" rel="stylesheet">
  <title>Leave Requests</title>
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
  <a href="#" class="text-[#151313] mr-2 font-medium hover:text-gray-600">Leave Requests</a>
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

  <!-- Leave Requests -->
  <div class="flex flex-wrap">
    <h3 class="ml-6 mt-8 text-xl font-bold">Leave Requests</h3>
    <button route="/hr/leave-requests/file-a-leave" class="mt-6 mr-4 flex ml-2 bg-green-500 text-white px-2 py-1 rounded-md hover:bg-green-600"><i class="ri-add-line"></i></button>

    <form action="/hr/leave-requests" method="POST" class="mt-6 ml-auto mr-4 flex">
      <input type="search" id="search" name="search" placeholder="Search" class="w-40 px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
      <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-1 rounded-md hover:bg-blue-600"><i class="ri-search-line"></i></button>
    </form>
  </div> 

  <!-- UNCOMMENT THIS AFTER FINISHING THE BACKEND FOR LEAVE REQUESTS -->
  <?php 
    if (empty($leaveRequests)) {
        require_once 'inc/noResult.php';
    } 
    else {
        require_once 'inc/leave-requests.table.php';
    } 
  ?>

  <!-- Reject modal -->
  <div id="rejectModal" class="hidden fixed flex top-0 left-0 w-full h-full items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-5 rounded-lg text-center">
          <h2 class="mb-4">Reject leave request?</h2>
          <button id="confirmReject" class="mr-2 px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded">Yes</button>
          <button id="cancelReject" class="px-4 py-2 bg-gray-300 text-black rounded">No</button>
      </div>
  </div>

  <!-- <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md m-5">
    <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
      <thead class="bg-gray-50">
        <tr>
          <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
          <th scope="col" class="px-6 py-4 font-medium text-gray-900">Name</th>
          <th scope="col" class="px-6 py-4 font-medium text-gray-900">Request Date</th>
          <th scope="col" class="px-6 py-4 font-medium text-gray-900">Reason</th>
          <th scope="col" class="px-6 py-4 font-medium text-gray-900">Status</th>
          <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 border-t border-gray-100">
        <tr class="hover:bg-gray-50">
          <td class="flex gap-3 px-6 py-4 font-normal text-gray-900 items-center">
            <div class="relative h-10 w-10">
              <img
                class="h-full w-full rounded-full object-cover object-center"
                src="https://pbs.twimg.com/media/GJMnNhcXoAEM1Es?format=png"
                alt=""
              />
              <span class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-green-400 ring ring-white"></span>
            </div>
          </td>
          <td class="px-6 py-4">
            <div class="text-sm">
              <div class="font-medium text-gray-700">Employee Name</div>
              <div class="text-gray-400">Employee Position</div>
            </div>
          </td>
          <td class="px-6 py-4">
            <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600">
              MM/DD/YYYY
            </span>
          </td>
          <td class="px-6 py-4"> 
            <div class="font-medium text-gray-700">Sick Leave</div>
            <div>
              Ever since one fated day, my world's been fading to gray. Despite the unclouded sky, staining the Earth with its dye. Afraid of taking the leap or to forevermore sleep. With cowardice as my guard, I'll keep enduring these scars.
            </div>
          </td>
          <td class="px-6 py-4">
            <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-yellow-600">
              Pending
            </span>
          </td>   
          <td class="px-6 py-4">
            <div class="flex justify-end gap-4">
              <a x-data="{ tooltip: 'Delete' }" href="#">   
                <i class="ri-check-line"></i>     
              </a>
              <a x-data="{ tooltip: 'Edit' }" href="#">
                <i class="ri-close-line"></i>     
              </a>
            </div>
          </td>
        </tr>

        <tr class="hover:bg-gray-50">
          <td class="flex gap-3 px-6 py-4 font-normal text-gray-900">
            <div class="relative h-10 w-10">
              <img
                class="h-full w-full rounded-full object-cover object-center"
                src="https://pbs.twimg.com/media/GJMmbo7XsAAqA9R?format=png"
                alt=""
              />
              <span class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-green-400 ring ring-white"></span>
            </div>
          </td>
          <td class="px-6 py-4">
            <div class="text-sm">
              <div class="font-medium text-gray-700">Employee Name</div>
              <div class="text-gray-400">Employee Position</div>
            </div>
          </td>
          <td class="px-6 py-4">
            <span
              class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600"
            >       
              MM/DD/YYYY
            </span>
          </td>
          <td class="px-6 py-4">
            <div class="font-medium text-gray-700">Vacation Leave</div>
            <div>
              A spiral without an end to solitude I'm condemned. Barely able to recall how full of joy I once was. My life now follows this trend of every day that I spend staring into a screen and simply daring to dream.
            </div>
          </td>
          <td class="px-6 py-4">
            <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-yellow-600">
              Pending
            </span>
          </td>
          <td class="px-6 py-4">
            <div class="flex justify-end gap-4">
              <a x-data="{ tooltip: 'Delete' }" href="#">   
                <i class="ri-check-line"></i>     
              </a>
              <a x-data="{ tooltip: 'Edit' }" href="#">
                <i class="ri-close-line"></i>     
              </a>
            </div>
          </td>
        </tr>               
      </tbody>
    </table>
  </div> -->
</div>
<!-- End Leave Requests -->
  
</main>
<!-- End Main Bar -->
<script  src="./../src/route.js"></script>
<script  src="./../src/form.js"></script>
<script type="module" src="../public/humanResources/js/sidenav-active-inactive.js"></script>
<script>
  document.getElementById('rejectButton').addEventListener('click', function() {
    document.getElementById('rejectModal').classList.remove('hidden');
  });

  document.getElementById('cancelReject').addEventListener('click', function() {
      document.getElementById('rejectModal').classList.add('hidden');
  });

  document.getElementById('confirmReject').addEventListener('click', function() {
      // Handle the deletion here
      console.log('Deleting...');
  });
</script>
</body>
</html> 