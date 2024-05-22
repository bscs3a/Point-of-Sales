<!-- Start: Sidebar -->

<div class="fixed bg-sidebar left-0 top-0 w-64 h-full p-4 z-50 sidebar-menu transition-transform">

    <div route='/' class="flex items-center pb-4">
        <div class="w-12 h-12 rounded bg-cover bg-[url('../public/finance/img/logo_reports.png')]">

        </div>

        <span class="cursor-pointer text-4xl font-russo text-white ml-3">BSCS 3A</span>
    </div>

    <ul class="mt-3">

        <li class="mb-1 hover:bg-slate-400 rounded-xl">
            <a route="/fin/dashboard" class="flex items-center py-2 px-4 text-white hover:text-black">
                <i class="ri-speed-up-line mr-3 text-lg"></i>
                <span class="text-sm font-medium">Dashboard</span>
                <i class="ri-arrow-down-s-line ml-auto"></i>
            </a>
        </li>
        <li class="mb-1">
            <button
                class="toggle-ledger flex items-center py-2 px-4 w-full text-white hover:bg-slate-400 hover:text-black rounded-xl">
                <i class="ri-survey-fill mr-3 text-lg"></i>
                <span class="text-sm font-medium">Ledger</span>
                <i class="ri-arrow-down-s-line ml-auto"></i>
            </button>
            <ul id="ledger" class="ml-8 hidden">
                <li>
                    <a route='/fin/ledger/page=1' class="flex items-center py-2 px-4 text-white hover:text-black">

                        <span class="text-sm font-medium">General</span>
                        <i class="ri-arrow-right-s-line ml-auto"></i>
                    </a>
                </li>
                <li>
                    <a route='/fin/ledger/accounts/investors'
                        class="flex items-center py-2 px-4 text-white hover:text-black">

                        <span class="text-sm font-medium">Payables</span>
                        <i class="ri-arrow-right-s-line ml-auto"></i>
                    </a>
                </li>
            </ul>
        </li>

        <li class="mb-1">
            <a route="/fin/funds/finance/page=1" class="flex items-center py-2 px-4 text-white hover:text-black">
                <i class="ri-speed-up-line mr-3 text-lg"></i>
                <span class="text-sm font-medium">Funds per Department</span>
            </a>
        </li>


</div>

<div class="fixed top-0 left-0 w-full h-full z-40 md:hidden sidebar-overlay"></div>
<!-- button dropdown -->
<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelector('.toggle-ledger').addEventListener('click', function () {
            document.getElementById('ledger').classList.toggle('hidden');
            // document.getElementById('reports-button').classList.toggle('bg-slate-400');
        });
    });
</script>