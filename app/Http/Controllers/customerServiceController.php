<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class customerServiceController extends Controller
{
    //
    public function getSelaeRepByEmployee($id)
    {
        $customers = DB::table('customers')
        ->join('employees','customers.salesRepEmployeeNumber',"=",'employees.employeeNumber')
        ->where('employees.employeeNumber',$id)
        ->get(['customerNumber','customerName','salesRepEmployeeNumber','employeeNumber','lastName','firstName','jobTitle']);
        return $customers;
    }

    public function getTotalEachOrderByCustomer($id)
    {
        $results = DB::select(DB::raw("
        SELECT customers.customerNumber,
            orders.orderNumber,orders.status,
            sum(orderdetails.priceEach)
        From customers
            JOIN orders on orders.customerNumber = customers.customerNumber
            JOIN orderdetails on orderdetails.orderNumber = orders.orderNumber
        WHERE customers.customerNumber = ".$id."
        GROUP BY orders.orderNumber
        "));
        return $results;
    }
}
