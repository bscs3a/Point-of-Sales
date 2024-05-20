<ul class="ml-auto flex items-center">

<div class="relative inline-block text-left">
    <div>
        <a class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-black bg-white rounded-md shadow-sm hover:bg-gray-50 focus:outline-none hover:cursor-pointer"
            id="options-menu" aria-haspopup="true" aria-expanded="true">
            <div class="text-black font-medium mr-4 ">
                <?= $_SESSION['user']['username']; ?>
            </div>
            <i class="ri-arrow-down-s-line"></i>
        </a>
    </div>

    <div class="origin-top-right absolute right-0 mt-4 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden"
        id="dropdown-menu" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
        <div class="py-1 w-100" role="none">
        <form action="/logout" method="post">
            <button type="submit" class="w-full block px-4 py-2 text-md text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                <i class="ri-logout-box-line"></i>
                Logout
            </button>
        </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('options-menu').addEventListener('click', function () {
        var dropdownMenu = document.getElementById('dropdown-menu');
        if (dropdownMenu.classList.contains('hidden')) {
            dropdownMenu.classList.remove('hidden');
        } else {
            dropdownMenu.classList.add('hidden');
        }
    });
</script>
</ul>