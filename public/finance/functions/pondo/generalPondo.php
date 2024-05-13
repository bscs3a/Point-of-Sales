<?php 

    require_once 'public/finance/functions/supportingFunctions/supportingPondo.php';
    require_once 'public/finance/functions/generalFunctions.php';
    


    function pondoForEveryone($department){
        if (!acceptableDepartment($department)){
            throw new Exception("Department does not exist");
        }
        $year = date('Y', strtotime('"first day of last month"'));
        $month = date('m', strtotime('"first day of last month"'));

        $balance = getAccountBalanceV2('Cash on hand',true, $year, $month) + getAccountBalanceV2('Cash on bank',true, $year, $month);
        $savings = $balance * 0.2;

        $PO = $balance * 0.2;
        $HR = $balance * 0.2;
        $Finance = $balance * 0.1;
        $Sales = $balance * 0.1;
        $Delivery = $balance * 0.1;
        $Inventory = $balance * 0.1;

        switch ($department) {
            case 'Product Order':
                return $PO;
            case 'Human Resources':
                return $HR;
            case 'Finance':
                return $Finance;
            case 'Point of Sales':
                return $Sales;
            case 'Delivery':
                return $Delivery;
            case 'Inventory':
                return $Inventory;
            case 'Savings':
                return $savings;
            default:
                throw new Exception("Department does not exist");
        }
    }


    function getExpensesPondo($department){
        $total = 0;
        if (!acceptableDepartment($department)){
            throw new Exception("Department does not exist");
        }
        $year = date('Y');
        $month = date('m');

        $db = Database::getInstance();
        $conn = $db->connect();

        $cashOnhand = getLedgerCode('Cash on hand');
        $cashOnbank = getLedgerCode('Cash on bank');

        $sql = "SELECT 
        (SUM(
            CASE 
                WHEN lt.LedgerNo_Dr = :cashOnHand OR lt.LedgerNo_Dr = :cashInBank THEN amount 
                ELSE 0 
            END) 
        -
        SUM(
            CASE 
                WHEN lt.LedgerNo = :cashOnHand OR lt.LedgerNo = :cashInBank THEN amount 
                ELSE 0 
            END)) 
        as balance
        FROM funds_transaction as ft
        JOIN ledgertransaction as lt ON ft.lt_id = lt.LedgerXactID
        JOIN employees as e ON ft.employee_id = e.id
        WHERE YEAR(datetime) = :year AND MONTH(datetime) = :month AND e.department = :department";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cashOnHand', $cashOnhand);
        $stmt->bindParam(':cashInBank', $cashOnbank);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':month', $month);
        $stmt->bindParam(':department', $department);
        $stmt->execute();
        $result = $stmt->fetch();
        $total = $result['balance'];

        return $total;
    }

    function getRemainingPondo($department){
        return pondoForEveryone($department) - getExpensesPondo($department);
    }

    //available are "'Product Order','Human Resources','Point of Sales', 'Inventory','Finance','Delivery', 'Savings'"
    function acceptableDepartment($department){
        $acceptable = array('Product Order','Human Resources','Point of Sales', 'Inventory','Finance','Delivery', 'Savings');
        if (!in_array($department, $acceptable)){
            return false;
        }
        return true;
    }

    // pass savings if you want to return all departments
    function getAllTransactions($department, $page = 1, $itemsPerPage = 10, $year = null, $month = null){
        if (!acceptableDepartment($department)){
            throw new Exception("Department does not exist");
        }
    
        if(($year === null) XOR ($month === null)){
            throw new Exception("Please provide both year and month");
        }
    
        $db = Database::getInstance();
        $conn = $db->connect();
    
        // Calculate the offset
        $offset = ($page - 1) * $itemsPerPage;
    
        if ($department == 'Savings') {
            $sql = "SELECT ft.id as id, l.name as details, lt.amount as amount, e.department as department, lt.datetime as datetime FROM funds_transaction as ft
            JOIN ledgertransaction as lt ON ft.lt_id = lt.LedgerXactID
            JOIN employees as e ON ft.employee_id = e.id
            JOIN ledger as l ON lt.LedgerNo_Dr = l.LedgerNo";
            if (is_numeric($year) && is_numeric($month) && $month > 0 && $month < 13) {
                $sql .= " WHERE YEAR(lt.datetime) = ? AND MONTH(lt.datetime) = ?";
                $stmt = $conn->prepare($sql . " ORDER BY lt.datetime DESC LIMIT ? OFFSET ?");
                $stmt->execute([$year, $month, $itemsPerPage, $offset]);
            } else {
                $stmt = $conn->prepare($sql . " ORDER BY lt.datetime DESC LIMIT ? OFFSET ?");
                $stmt->execute([$itemsPerPage, $offset]);
            }
        } else {
            $sql = "SELECT ft.id as id, l.name as details, lt.amount as amount, e.department as department, lt.datetime as datetime FROM funds_transaction as ft
            JOIN ledgertransaction as lt ON ft.lt_id = lt.LedgerXactID
            JOIN employees as e ON ft.employee_id = e.id
            JOIN ledger as l ON lt.LedgerNo_Dr = l.LedgerNo WHERE e.department = ?";
            if (is_numeric($year) && is_numeric($month) && $month > 0 && $month < 13) {
                $sql .= " AND YEAR(lt.datetime) = ? AND MONTH(lt.datetime) = ?";
                $stmt = $conn->prepare($sql . " ORDER BY lt.datetime DESC LIMIT ? OFFSET ?");
                $stmt->execute([$department, $year, $month, $itemsPerPage, $offset]);
            } else {
                $stmt = $conn->prepare($sql . " ORDER BY lt.datetime DESC LIMIT ? OFFSET ?");
                $stmt->execute([$department, $itemsPerPage, $offset]);
            }
        }
    
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
?>