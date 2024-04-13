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
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
  <link href="./../src/tailwind.css" rel="stylesheet">
  <title>Schedule</title>
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
  <a href="#" class="text-[#151313] mr-2 font-medium hover:text-gray-600">Schedule</a>
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
  <br>

<!-- component -->
<div class="lg:flex lg:h-auto lg:flex-col">
  <header class="flex items-center justify-between border-b border-gray-200 px-6 py-4 lg:flex-none">
    <h1 class="text-base font-semibold leading-6 text-gray-900">
        <time datetime="<?php echo date('Y-m'); ?>"><?php echo date('F Y'); ?></time>
    </h1>
    <div class="flex items-center">
      <!-- <div class="relative flex items-center rounded-md bg-white shadow-sm md:items-stretch">
        <button type="button" class="flex h-9 w-12 items-center justify-center rounded-l-md border-y border-l border-gray-300 pr-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pr-0 md:hover:bg-gray-50">
          <span class="sr-only">Previous month</span>
          <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
          </svg>
        </button>
        <button type="button" class="hidden border-y border-gray-300 px-3.5 text-sm font-semibold text-gray-900 hover:bg-gray-50 focus:relative md:block">Today</button>
        <span class="relative -mx-px h-5 w-px bg-gray-300 md:hidden"></span>
        <button type="button" class="flex h-9 w-12 items-center justify-center rounded-r-md border-y border-r border-gray-300 pl-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pl-0 md:hover:bg-gray-50">
          <span class="sr-only">Next month</span>
          <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
          </svg>
        </button>
      </d/iv> -->
      
      <!-- <div class="hidden md:ml-4 md:flex md:items-center">
        <div class="relative">
          <div class="relative"></div>
            <button type="button" class="flex items-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" id="menu-button" aria-expanded="false" aria-haspopup="true">
              Month view
              <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
              </svg>
            </button>
            <div class="hidden absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5">
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Month view</a>
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Week view</a>
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Day view</a>
            </div>
          </div>
          <script>
            document.getElementById('menu-button').addEventListener('click', function() {
              var dropdown = this.nextElementSibling;
              dropdown.classList.toggle('hidden');
            });
          </script>
        </div> -->

        <!-- The Add Event button -->
        <button id="addEventButton" type="button" class="ml-6 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"><i class="ri-add-line"></i>Add event</button>

        <!-- The Add Event modal -->
        <div id="addEventModal" class="hidden fixed top-0 left-0 w-full h-full z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-4 rounded">
                <h2 class="text-lg font-bold mb-2"><i class="ri-add-line"></i>Add Event</h2>
                <form action="/create/schedule" id="addEventForm" method="POST">

                <div class="mb-4">
                  <label for="eventName" class="block mb-2 mt-0 text-sm font-bold text-gray-700">Name of the Event</label>
                  <input id="event_name" name="event_name" type="text" class="w-64 px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required>
                </div>
              
                <div class="mb-4">
                  <label for="eventDate" class="block mb-2 mt-0 text-sm font-bold text-gray-700">Date</label>
                  <input id="date" name="date" type="date" class="w-64 px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="mb-4">
                  <label for="eventDay" class="block mb-2 mt-0 text-sm font-bold text-gray-700">Day</label>
                  <input id="day" name="day" type="text" class="w-64 px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline" readonly>
                </div>

                  <div class="flex justify-center items-center">
                    <button type="submit" class="ml-3 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
                    <button id="cancelButton" type="button" class="ml-3 rounded-md bg-gray-100 px-3 py-2 text-sm font-semibold text-black shadow-sm hover:bg-gray-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Cancel</button>
                  </div>
                </form>
            </div>
        </div>
        <script>
          document.getElementById('addEventButton').addEventListener('click', function() {
              // Show the Add Event modal
              document.getElementById('addEventModal').classList.remove('hidden');
          });

          document.getElementById('cancelButton').addEventListener('click', function() {
              // Hide the Add Event modal
              document.getElementById('addEventModal').classList.add('hidden');
          });

          document.getElementById('date').addEventListener('change', function() {
              // When the date is picked, automatically check which day it is
              var date = new Date(this.value);
              document.getElementById('day').value = date.toLocaleDateString('en-US', { weekday: 'long' });
          });
        </script>

        <div class="ml-3 h-6 w-px bg-gray-300"></div>
        
        <!-- The Remove Event button -->
        <button type="button" class="ml-3 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Remove event</button>
      </div>
    </div>
  </header>
  
<div class="shadow ring-1 ring-black ring-opacity-5 lg:flex lg:flex-auto lg:flex-col">
<!-- DAYS OF THE WEEK -->
<div class="grid grid-cols-7 gap-px border-b border-gray-300 bg-gray-200 text-center text-xs font-semibold leading-6 text-gray-700 lg:flex-none">
  <div class="flex justify-center bg-blue-200 py-2">
    <span>M</span>
    <span class="sr-only sm:not-sr-only">on</span>
  </div>
  <div class="flex justify-center bg-blue-200 py-2">
    <span>T</span>
    <span class="sr-only sm:not-sr-only">ue</span>
  </div>
  <div class="flex justify-center bg-blue-200 py-2">
    <span>W</span>
    <span class="sr-only sm:not-sr-only">ed</span>
  </div>
  <div class="flex justify-center bg-blue-200 py-2">
    <span>T</span>
    <span class="sr-only sm:not-sr-only">hu</span>
  </div>
  <div class="flex justify-center bg-blue-200 py-2">
    <span>F</span>
    <span class="sr-only sm:not-sr-only">ri</span>
  </div>
  <div class="flex justify-center bg-blue-200 py-2">
    <span>S</span>
    <span class="sr-only sm:not-sr-only">at</span>
  </div>
  <div class="flex justify-center bg-blue-200 py-2">
    <span>S</span>
    <span class="sr-only sm:not-sr-only">un</span>
  </div>
</div>
<!-- END DAYS OF THE WEEK -->

<div class="flex bg-gray-50 text-xs leading-6 text-gray-700 lg:flex-auto">
<!-- CALENDAR DAYS -->
<div class="hidden w-full lg:grid lg:grid-cols-7 lg:grid-rows-6 lg:gap-px">
<?php
    date_default_timezone_set('Asia/Manila');

    // Get the current month and year
    $month = date('m');
    $year = date('Y');

    // Get the number of days in the month
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    // Find out what day of the week the first day of the month is
    $firstDayOfMonth = date('N', strtotime("$year-$month-01"));

    // Calculate how many days to go back to the previous month
    $daysToGoBack = $firstDayOfMonth - 1;

    // Get the timestamp for the day to start from in the previous month
    $startDayOfPrevMonth = strtotime("$year-$month-01 - $daysToGoBack day");
    
    $query = $conn->query("SELECT * FROM calendar");
    $holidays = $query->fetchAll(PDO::FETCH_ASSOC);

    // Loop through each day of the month
    for ($day = 1; $day <= $daysInMonth; $day++) {
        // Format the date
        $date = $year . '-' . $month . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);

        // Find out what day of the week this day is
        $dayOfWeek = date('N', strtotime($date));

        // If this is the first day of the loop, add divs for the last few days of the previous month
        if ($day == 1) {
            for ($i = 0; $i < $daysToGoBack; $i++) {
                // Get the date for this day of the previous month
                $prevMonthDate = date('Y-m-d', $startDayOfPrevMonth + ($i * 24 * 60 * 60));

                // Output the div for this day
                echo '<div class="relative bg-gray-100 px-3 py-2 text-gray-500">';
                echo '<time datetime="' . $prevMonthDate . '">' . date('j', strtotime($prevMonthDate)) . '</time>';
                echo '</div>';
            }
        }
?>
<div class="relative bg-white px-3 py-2">
    <?php
    $currentDate = date('Y-m-d');
    $timeClass = $date == $currentDate ? 'flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 font-semibold text-white' : '';

    // Check if this day is a holiday
    $holidaysToday = [];
    foreach ($holidays as $holiday) {
        if ($holiday['date'] == $date) {
            $holidaysToday[] = $holiday;
        }
    }
    ?>
    <time datetime="<?php echo $date; ?>" class="<?php echo $timeClass; ?>"><?php echo $day; ?></time>
    <?php foreach ($holidaysToday as $holiday): ?>
      <p class="flex-auto mt-2 mb-2 truncate text-sm italic text-blue-600"><?php echo $holiday['event_name']; ?></p>
    <?php endforeach; ?>
    <?php if ($date == $currentDate && $onLeave > 0): ?>
    <ol class="mt-2">
    <li>
        <a href="#" class="group flex">
        <p class="flex-auto mt-2 mb-2 truncate text-sm font-medium text-gray-900">Employees</p>
        </a>
    </li>
    <li>
        <a href="#" class="group flex">
        <p class="flex-auto mb-4 truncate text-sm font-medium text-gray-900">On Leave</p>
        <p class="ml-3 hidden flex-none text-sm font-bold text-blue-500 xl:block"><?php echo $onLeave; ?></p>
        </a>
    </li>
    </ol>
    <?php endif; ?>
</div>
<?php
    // If this is the last day of the loop and it's not a Sunday, add divs for the first few days of the next month
    if ($day == $daysInMonth) {
        // Get the timestamp for the first day of the next month
        $firstDayOfNextMonth = strtotime("$year-$month-$day + 1 day");

        for ($i = $dayOfWeek; $i < 7; $i++) {
            // Get the date for this day of the next month
            $nextMonthDate = date('Y-m-d', $firstDayOfNextMonth);

            // Output the div for this day
            echo '<div class="relative bg-gray-200 px-3 py-2 text-gray-500">';
            echo '<time datetime="' . $nextMonthDate . '">' . date('j', $firstDayOfNextMonth) . '</time>';
            echo '</div>';

            // Add one day to the timestamp
            $firstDayOfNextMonth += 24 * 60 * 60;
        }
    }
    }
?>
</div>
<!-- END OF CALENDAR DAYS -->
</div>
</div>
</div>
  <!-- component -->
</main>
<!-- End Main Bar -->
<script  src="./../src/route.js"></script>
<script  src="./../src/form.js"></script>
<script type="module" src="../public/humanResources/js/sidenav-active-inactive.js"></script>
</script>
</body>
</html>