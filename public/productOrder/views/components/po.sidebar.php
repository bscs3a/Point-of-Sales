<!-- sidebar -->
<div class="flex flex-col w-64 bg-gray-800">
  <div class="flex items-center justify-end h-16 bg-violet-950 p-6">
    <span onclick="location.href='/Master'" class="text-white font-bold uppercase text-4xl">BSCS 3A</span>
  </div>
  <div class="flex flex-col flex-1 overflow-y-auto">
    <nav class="flex-1 px-2 py-4 bg-violet-950">
      <a
        route='/po/dashboard'
        class="flex justify-between items-center px-4 py-2 text-gray-100 hover:bg-violet-300">
        <span class="flex items-center">
          <span class="mx-4 font-normal">Dashboard</span>
        </span>

        <span>
          <svg
            class="h-4 w-4"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-6 h-6">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="m8.25 4.5 7.5 7.5-7.5 7.5" />
          </svg>
        </span>
      </a>

      <a
        route="/po/dashboard"
        class="flex justify-between items-center px-4 py-2 text-gray-100 hover:bg-violet-300">
        <span class="flex items-center">
          <span class="mx-4 font-normal">Audit Trail</span>
        </span>

        <span>
          <svg
            class="h-4 w-4"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-6 h-6">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="m8.25 4.5 7.5 7.5-7.5 7.5" />
          </svg>
        </span>
      </a>

      <a
        route='/po/suppliers'
        class="flex justify-between items-center px-4 py-2 text-gray-100 hover:bg-violet-300">
        <span class="flex items-center">
          <span class="mx-4 font-normal">Suppliers</span>
        </span>

        <span>
          <svg
            class="h-4 w-4"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-6 h-6">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="m8.25 4.5 7.5 7.5-7.5 7.5" />
          </svg>
        </span>
      </a>

      <a
        route='/po/items'
        class="flex justify-between items-center px-4 py-2 text-gray-100 hover:bg-violet-300">
        <span class="flex items-center">
          <span class="mx-4 font-normal">Items</span>
        </span>

        <span>
          <svg
            class="h-4 w-4"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-6 h-6">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="m8.25 4.5 7.5 7.5-7.5 7.5" />
          </svg>
        </span>
      </a>

      <a
        route='/po/orderRequest'
        class="flex justify-between items-center px-4 py-2 text-gray-100 hover:bg-violet-300">
        <span class="flex items-center">
          <span class="mx-4 font-normal">Order Request</span>
        </span>

        <span>
          <svg
            class="h-4 w-4"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-6 h-6">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="m8.25 4.5 7.5 7.5-7.5 7.5" />
          </svg>
        </span>
      </a>

      <a
        route='/po/transactionHistory'
        class="flex justify-between items-center px-4 py-2 text-gray-100 hover:bg-violet-300">
        <span class="flex items-center">
          <span class="mx-4 font-normal">Transaction History</span>
        </span>

        <span>
          <svg
            class="h-4 w-4"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-6 h-6">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="m8.25 4.5 7.5 7.5-7.5 7.5" />
          </svg>
        </span>
      </a>

      <a
        route="/po/dashboard"
        class="flex justify-between items-center px-4 py-2 text-gray-100 hover:bg-violet-300">
        <span class="flex items-center">
          <span class="mx-4 font-normal">Request History</span>
        </span>

        <span>
          <svg
            class="h-4 w-4"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="w-6 h-6">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="m8.25 4.5 7.5 7.5-7.5 7.5" />
          </svg>
        </span>
      </a>
    </nav>
  </div>
</div>

<script  src="./../src/route.js"></script>