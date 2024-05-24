<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="src/tailwind.css" rel="stylesheet">

</head>


<body class="bg-slate-400">

    <div class="flex flex-col items-center justify-center h-screen">
        <br>
        <div class="flex flex-wrap -mx-2">
            <div class="w-1/2 px-2">
                <p>Group1</p>
                <button route='/po/login' class="px-6 py-3 mb-2 text-white bg-sidebar rounded hover:bg-blue-700">ProductOrder</button><br>
                <p>Group3</p>
                <script>
                    var basePath = window.location.pathname.split('/').slice(0, -1).join('/');
                </script>
                <button route='/sls/Dashboard' class="px-6 py-3 mb-2 text-white  bg-sidebar rounded hover:bg-blue-700">Sales Page</button><br>
                <p>Group5</p>
                <button route='/fin/dashboard' class="px-6 py-3 mb-2 text-white  bg-sidebar rounded hover:bg-blue-700">Finance Page</button><br>
            </div>
            <div class="w-1/2 px-2">
                <p>Group2</p>
                <button route='/hr/dashboard' class="px-6 py-3 mb-2 text-white bg-sidebar rounded hover:bg-blue-700 whitespace-nowrap">Human
                    Resources Page</button><br>
                <p>Group4</p>
                <button route='/inv/main' class="px-6 py-3 mb-2 text-white  bg-sidebar rounded hover:bg-blue-700 whitespace-nowrap">Inventory
                    & Product Order Page</button><br>
                <p>Group6</p>
                <button route='/dlv/dashboard'
                    class="px-6 py-3 mb-2 text-white  bg-sidebar rounded hover:bg-blue-700">Delivery Page</button><br>
            </div>



        </div>
      </div>

      <!-- right panel -->
      <div class="flex flex-col h-screen w-1/2 justify-center items-center">
        <p class="text-6xl font-sans font-bold">Login</p>
        <p class="mt-3 text-sm text-gray-400">
          Welcome Back! Please enter your details
        </p>
        
        <?php 
        if(isset($_GET['error'])){
        ?>
        <p class="mt-3 text-sm text-red-400 ">
            Invalid Credentials
        </p>
        <?php
        } ?>
        <!-- user info form -->
        <form class="mt-3 w-72 mx-auto" method="post" action="/login">
          <div class="mb-5">
            <label
              for="username"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
              >Username</label
            >
            <input
              type="text"
              id="username"
              name = "username"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              placeholder="user@gmail.com"
              required
            />
          </div>
          <div class="mb-5">
            <label
              for="password"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
              >Password</label
            >
            <input
              type="password"
              id="password"
              name="password"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              required
            />
          </div>

          <button
            type="submit"
            class="text-white bg-[#262261] hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
          >
            Login
          </button>
        </form>
      </div>
    </div>

    
    <script  src="./src/route.js"></script>
    <script  src="./src/form.js"></script>
</body>

</html>