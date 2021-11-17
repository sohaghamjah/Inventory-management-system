<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Modules\Customer\Entities\Customer;
use Modules\Expense\Entities\Expense;
use Modules\HRM\Entities\Payroll;
use Modules\Purchase\Entities\Purchase;
use Modules\Sale\Entities\Sale;
use Modules\Supplier\Entities\Supplier;

class HomeController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->setPageData('Dashboard','Dashboard','fas fa-tachometer-alt');
        $start_date = date('Y-m').'-01';
        $end_date = date('Y-m').'-31';

        $sale = Sale::toBase()->whereDate('created_at','>=',$start_date)
        ->whereDate('created_at','<=',$end_date)->sum('grand_total');

        $purchase = Purchase::toBase()->whereDate('created_at','>=',$start_date)
        ->whereDate('created_at','<=',$end_date)->sum('grand_total');

        $customer = Customer::toBase()->whereDate('created_at','>=',$start_date)
        ->whereDate('created_at','<=',$end_date)->get()->count();

        $supplier = Supplier::toBase()->whereDate('created_at','>=',$start_date)
        ->whereDate('created_at','<=',$end_date)->get()->count();

        $expense = Expense::toBase()->whereDate('created_at','>=',$start_date)
        ->whereDate('created_at','<=',$end_date)->sum('amount');

        // Cash flow of last 6 months

        $start = strtotime(date('Y-m-01', strtotime('-6 month', strtotime(date('Y-m-d')))));
        $end = strtotime(date('Y-m-31'));

        $payment_received = [];
        $payment_sent = [];
        $month = [];

        while ($start < $end) {
            $start_date = date('Y-m', $start).'-01';
            $end_date = date('Y-m', $start).'-31';

            $received_amount =DB::table('payments')->whereNotNull('sale_id')->whereDate('created_at','>=',$start_date)
                ->whereDate('created_at','<=',$end_date)->sum('amount');

            $sent_amount = DB::table('payments')->whereNotNull('purchase_id')->whereDate('created_at','>=',$start_date)
                ->whereDate('created_at','<=',$end_date)->sum('amount');

            $expense_amount = Expense::toBase()->whereDate('created_at','>=',$start_date)
                ->whereDate('created_at','<=',$end_date)->sum('amount');

            $payroll_amount = Payroll::toBase()->whereDate('created_at','>=',$start_date)
            ->whereDate('created_at','<=',$end_date)->sum('amount');

            $sent_amount = $sent_amount + $expense_amount + $payroll_amount;

            $payment_received[]      = number_format($received_amount,2,'.','');
            $payment_sent    []      = number_format($sent_amount,2,'.','');
            $month           []      = date('F',strtotime($start_date));
            $start = strtotime('+1 month',$start);

        }

        // Yearly Report

        $start = strtotime(date('Y').'-01-01');
        $end = strtotime(date('Y').'-12-31');

        $yearly_sale_amount = [];
        $yearly_purchase_amount = [];

        while($start < $end){
            $start_date = date('Y').'-'.date('m',$start).'-01'; 
            $end_date = date('Y').'-'.date('m',$start).'-31';

            $sale_amount =DB::table('payments')->whereNotNull('sale_id')->whereDate('created_at','>=',$start_date)
                ->whereDate('created_at','<=',$end_date)->sum('amount');

            $purchase_amount = DB::table('payments')->whereNotNull('purchase_id')->whereDate('created_at','>=',$start_date)
                ->whereDate('created_at','<=',$end_date)->sum('amount');

            $yearly_sale_amount[] = number_format($sale_amount,2,'.','');
            $yearly_purchase_amount[] = number_format($purchase_amount,2,'.',''); 
            $start = strtotime('+1 month', $start);
        }

        $data = [
            'sale'                   => $sale,
            'purchase'               => $purchase,
            'profit'                 => ($sale - $purchase),
            'customer'               => $customer,
            'supplier'               => $supplier,
            'expense'                => $expense,
            'payment_received'       => $payment_received,
            'payment_sent'           => $payment_sent,
            'month'                  => $month,
            'yearly_sale_amount'     => $yearly_sale_amount,
            'yearly_purchase_amount' => $yearly_purchase_amount,
        ];

        return view('home', $data);
    }

    public function dashboardData($start_date, $end_date){
        if($start_date && $end_date){
            
            $sale = Sale::toBase()->whereDate('created_at','>=',$start_date)
            ->whereDate('created_at','<=',$end_date)->sum('grand_total');

            $purchase = Purchase::toBase()->whereDate('created_at','>=',$start_date)
            ->whereDate('created_at','<=',$end_date)->sum('grand_total');

            $customer = Customer::toBase()->whereDate('created_at','>=',$start_date)
            ->whereDate('created_at','<=',$end_date)->get()->count();

            $supplier = Supplier::toBase()->whereDate('created_at','>=',$start_date)
            ->whereDate('created_at','<=',$end_date)->get()->count();

            $expense = Expense::toBase()->whereDate('created_at','>=',$start_date)
            ->whereDate('created_at','<=',$end_date)->sum('amount');

            $data = [
                'sale'                   => number_format($sale, 2, '.', ','),
                'purchase'               => number_format($purchase, 2, '.', ','),
                'profit'                 => number_format(($sale - $purchase), 2, '.', ','),
                'customer'               => number_format($customer, 2, '.', ','),
                'supplier'               => number_format($supplier, 2, '.', ','),
                'expense'                => number_format($expense, 2, '.', ','),
            ];

            return response()->json($data);
        }
    }

    public function unauthorized()
    {
        $this -> setPageData('Unauthorized', 'Unauthorized', 'fas fa-ban');
        return view('unauthorized');
    }

}
