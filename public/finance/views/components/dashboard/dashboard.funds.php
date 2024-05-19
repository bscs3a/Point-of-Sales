<?php 
require_once "public/finance/functions/pondo/generalPondo.php";
$department = $_SESSION['user']['role'];
$allowance = pondoForEveryone($department)['total'];
$pondoExpense = getExpensesPondo($department, 'Cash on hand') + getExpensesPondo($department, 'Cash on bank');
$pondoBalance = $allowance - $pondoExpense;
?>

<div class=" col-span-1 border-2 rounded-xl drop-shadow-md">
    <div class="mx-5 my-5 py-3 px-3">
        <h1 class="text-3xl font-bold">Funds</h1>
        <div class = "border-2 drop-shadow-sm flex flex-nowrap justify-between px-20 py-3 items-center rounded-md mb-4">
            <div class = "flex items-center gap-2">
                <img src="../public\finance\img\Stack of Coins.png" alt="" class = "bg-radial-gradient max-w-full h-auto py-2 px-1 rounded-full"> 
                <h3 class = "text-xl text-[#6C6C6C]">Allowance</h3>
            </div>
            <div class = "text-2xl text-[#F8B721]">₱ <?= $allowance ?></div>
        </div>
        <div class = "border-2 drop-shadow-sm flex flex-nowrap justify-between px-20 py-3 items-center p-3 rounded-md mb-4">
            <div class = "flex items-center gap-2">
                <img src="../public/finance/img/RequestMoney.png" alt="" class="bg-radial-gradient max-w-full h-[1.25rem] py-2 px-1 rounded-full"> 
                <h3 class="text-xl text-[#6C6C6C]">Expense</h3>
            </div>
            <div class = "text-2xl text-[#F8B721]">₱ <?= $pondoExpense ?></div>
        </div>
        <div class = "border-2 drop-shadow-sm flex flex-nowrap justify-between px-20 py-3 items-center p-3 rounded-md mb-4">
            <div class = "flex items-center gap-2">
                <img src="../public\finance\img\Cash in Hand.png" alt="" class = "bg-radial-gradient max-w-full h-auto py-2 px-1 rounded-full"> 
                <h3 class = "text-xl text-[#6C6C6C]">Remaining Funds</h3>
            </div>
            <div class = "text-2xl text-[#F8B721]">₱ <?= $pondoBalance ?></div>
        </div>
    </div>
</div>