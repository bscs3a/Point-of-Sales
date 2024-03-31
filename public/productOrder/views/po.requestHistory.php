<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Request History</title>

    <link href="./../src/tailwind.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
  </head>
  <body>
    <div class="flex h-screen bg-gray-100">
      <!-- sidebar -->
        <div id="sidebar" class="flex h-screen">
          <?php include "components/po.sidebar.php" ?>
        </div>

      <!-- Main Content -->
        <div class="flex flex-col flex-1 overflow-y-auto">
          <!-- header -->
          <div class="flex items-center justify-between h-16 bg-white shadow-md px-4">
            <div class="flex items-center gap-4">
              <button id="toggleSidebar" class="text-gray-500 focus:outline-none focus:text-gray-700">
                <i class="ri-menu-line"></i>
              </button>
              <label class="text-black font-medium">Request History</label>
            </div>

            <!-- dropdown -->
            <div x-data="{ dropdownOpen: false }" class="relative my-32">
              <button @click="dropdownOpen = !dropdownOpen" class="relative z-10 border border-gray-50 rounded-md bg-white p-2 focus:outline-none">
                <div class="flex items-center gap-4">
                  <a class="flex-none text-sm dark:text-white" href="#">David, Marc</a>
                    <i class="ri-arrow-down-s-line"></i>
                </div>
              </button>

                <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

                <div x-show="dropdownOpen" class="absolute right-0 mt-2 py-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg z-20">
                  <a href="#" class="block px-8 py-1 text-sm capitalize text-gray-700">Log out</a>
                </div>
            </div>
          </div>

          <script>
            document.getElementById('toggleSidebar').addEventListener('click', function() {
                var sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('hidden', !sidebar.classList.contains('hidden'));
            });
          </script>

        <div class="h=screen px-10">
          <!-- Calender -->
          <div class="antialiased sans-serif">
            <div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
                <div class="container mx-auto py-2 md:py-10">
                    <div class="my-5 w-64">
                        <div class="relative">
                            
                            <input type="hidden" name="date" x-ref="date">
                            <input type="text" readonly x-model="datepickerValue" @click="showDatepicker = !showDatepicker" @keydown.escape="showDatepicker = false" class="w-full pl-4 pr-10 py-3 leading-none rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium" placeholder="Select date">

                            <div class="absolute top-0 right-0 px-3 py-2">
                              <svg class="h-6 w-6 text-gray-400"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>

                              <div class="bg-white mt-12 rounded-lg shadow p-4 absolute top-0 left-0" style="width: 17rem" x-show.transition="showDatepicker" @click.away="showDatepicker = false">
                                
                                <div class="flex justify-between items-center mb-2">
                                  <div>
                                    <span x-text="MONTH_NAMES[month]" class="text-lg font-semibold text-gray-800"></span>
                                    <span x-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
                                  </div>
                                  <div>
                                    <button type="button" class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" :class="{'cursor-not-allowed opacity-25': month == 0 }" :disabled="month == 0 ? true : false" @click="month--; getNoOfDays()">
                                      <svg class="h-6 w-6 text-gray-500 inline-flex"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>  
                                    </button>
                                    <button type="button" class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" :class="{'cursor-not-allowed opacity-25': month == 11 }" :disabled="month == 11 ? true : false" @click="month++; getNoOfDays()">
                                    <svg class="h-6 w-6 text-gray-500 inline-flex"  fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>									  
                                    </button>
                                  </div>
                                </div>

                                <div class="flex flex-wrap mb-3 -mx-1">
                                  <template x-for="(day, index) in DAYS" :key="index">	
                                    <div style="width: 14.26%" class="px-1">
                                      <div x-text="day" class="text-gray-800 font-medium text-center text-xs"></div>
                                    </div>
                                  </template>
                                </div>

                                <div class="flex flex-wrap -mx-1">
                                  <template x-for="blankday in blankdays">
                                    <div style="width: 14.28%" class="text-center border p-1 border-transparent text-sm"></div>
                                  </template>	
                                  <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">	
                                    <div style="width: 14.28%" class="px-1 mb-1">
                                      <div @click="getDateValue(date)" x-text="date" class="cursor-pointer text-center text-sm leading-none rounded-full transition ease-in-out duration-100" :class="{'bg-blue-500 text-white': isToday(date) == true, 'text-gray-700 hover:bg-blue-200': isToday(date) == false }"></div>
                                            </div>
                                        </template>
                                    </div>
                              </div>
                        </div>	 
                    </div>
                </div>
            </div>

            <script>
                const MONTH_NAMES = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                const DAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

                function app() {
                    return {
                        showDatepicker: false,
                        datepickerValue: '',
                        month: '',
                        year: '',
                        no_of_days: [],
                        blankdays: [],
                        days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

                        initDate() {
                            let today = new Date();
                            this.month = today.getMonth();
                            this.year = today.getFullYear();
                            this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
                        },

                        isToday(date) {
                            const today = new Date();
                            const d = new Date(this.year, this.month, date);

                            return today.toDateString() === d.toDateString() ? true : false;
                        },

                        getDateValue(date) {
                            let selectedDate = new Date(this.year, this.month, date);
                            this.datepickerValue = selectedDate.toDateString();

                            this.$refs.date.value = selectedDate.getFullYear() +"-"+ ('0'+ selectedDate.getMonth()).slice(-2) +"-"+ ('0' + selectedDate.getDate()).slice(-2);

                            console.log(this.$refs.date.value);

                            this.showDatepicker = false;
                        },

                        getNoOfDays() {
                            let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

                            // find where to start calendar day of week
                            let dayOfWeek = new Date(this.year, this.month).getDay();
                            let blankdaysArray = [];
                            for ( var i=1; i <= dayOfWeek; i++) {
                                blankdaysArray.push(i);
                            }

                            let daysArray = [];
                            for ( var i=1; i <= daysInMonth; i++) {
                                daysArray.push(i);
                            }

                            this.blankdays = blankdaysArray;
                            this.no_of_days = daysArray;
                        }
                    }
                }
            </script>
          </div>
        </div>

        <nav class="mx-5">
          <ul class="flex items-center justify-between -space-x-px h-8 text-sm">
            <li>
              <a href="#" class="flex items-center justify-center px-3 h-8 font-bold text-lg text-gray-800 dark:text-gray-400"><</a>
            </li>
            <li>
              <a href="#" class="flex items-center justify-center px-3 h-8 font-semibold text-2xl text-gray-800 dark:text-gray-400">March 2024</a>
            </li>
            <li>
              <a href="#" class="flex items-center justify-center px-3 h-8 font-bold text-lg text-gray-800 dark:text-gray-400">></a>
            </li>
          </ul>
        </nav>

        <!-- table -->
        <div
          class="overflow-hidden rounded-lg border border-gray-300 shadow-md m-5">
          <table
            class="w-full border-collapse bg-white text-left text-sm text-gray-500">
            <thead class="bg-gray-200">
              <tr class="border-b border-y-gray-300">
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                  Product
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                  Request ID
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                  Date
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                  Price
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-center text-gray-900">
                  Quantity
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-center text-gray-900">
                  Total
                </th>
              </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 border-b border-gray-300">
              <tr class="hover:bg-gray-100">
                <th class="flex gap-3 px-6 py-7 font-normal text-gray-900">
                  <div class="flex flex-col font-medium text-gray-700 text-sm">
                    <a>Stanley 84-073 Flat</a>
                    <a>Nose Pliers 6"</a>
                  </div>
                </th>
                <td class="px-6 py-7">
                  <div class="font-medium text-gray-700 text-sm">17703</div>
                </td>
                <td class="px-6 py-7">
                  <div class="font-medium text-gray-700 text-sm">...</div>
                </td>
                <td class="px-6 py-7">
                  <div class="font-medium text-gray-700 text-sm">
                    Php 1000
                  </div>
                </td>
                <td class="px-6 py-7">
                  <div class="flex justify-center font-medium text-gray-700 text-sm">
                    <nav>
                      <ul class="flex items-center -space-x-px h-8 text-sm">
                        <li>
                          <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-violet-950 hover:text-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">-</a>
                        </li>
                        <li>
                          <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-violet-950 hover:text-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                        </li>
                        <li>
                          <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-violet-950 hover:text-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">+</a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </td>
                <td class="px-6 py-7">
                  <div class="font-medium text-center text-gray-700 text-sm">
                    Php 2000
                  </div>
                </td>
              </tr>
            </tbody>

            <tfoot class="bg-gray-200">
              <tr class="border-b border-y-gray-300">
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                </th>
                <th scope="col" class="px-6 py-4 font-medium text-gray-900">
                </th>
                <th scope="col" class="px-6 py-4 ml-3 font-medium text-gray-900">
                  <div class="flex flex-col font-medium text-gray-700 gap-3">
                    <a>Items Subtotal: 2</a>
                    <a>Total Amount: Php 2000</a>
                  </div>
                </th>
              </tr>
            </tfoot>

          </table>
        </div>

        <!-- View All Button -->
        <div class="flex justify-end border-none">
          <button class="mr-5 py-3 px-4 border-2 border-black text-sm rounded-md bg-[#FFC955]">
            view all
          </button>
        </div>
        
      </div>
    </div>
  </body>
  <script  src="./../src/route.js"></script>
</html>