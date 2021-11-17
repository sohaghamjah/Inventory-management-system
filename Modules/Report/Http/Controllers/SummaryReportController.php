<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Expense\Entities\Expense;
use Modules\HRM\Entities\Payroll;
use Modules\Product\Entities\WarehouseProduct;
use Modules\Purchase\Entities\Purchase;
use Modules\Sale\Entities\Sale;
use Modules\System\Entities\Warehouse;

class SummaryReportController extends Controller
{

    protected function setPageData($page_title, $sub_title, $page_icon){
        view()->share(['page_title' => $page_title, 'sub_title' => $sub_title, 'page_icon' => $page_icon]);
    }

    public function index()
    {
        if(permission('summary-report-access')){
            $this -> setPageData('Summary Report', 'Summary Report', 'fas fa-file-signature');
            return view('report::summary-report.index');
        }else{
            return redirect('unauthorized');
        }
    }

    public function details(Request $request){
        $start_date = $request->start_date ? $request->start_date : date("Y-m").'-01';
        $end_date = $request->end_date ? $request->end_date : date("Y-m-d");

        $query1 = ['SUM(grand_total) AS grand_total, SUM(paid_amount) AS paid_amount, SUM(total_tax + order_tax) AS tax'];
        $query2 = ['SUM(grand_total) AS grand_total, SUM(total_tax + order_tax) AS tax'];

        $purchase = Purchase::whereDate('created_at', '>=', $start_date)
                            ->whereDate('created_at', '<=', $end_date)
                            ->selectRaw(implode(',',$query1))->get();

        $total_purchase = Purchase::whereDate('created_at', '>=', $start_date)
                            ->whereDate('created_at', '<=', $end_date)->count();

        $sale = Sale::whereDate('created_at', '>=', $start_date)
                            ->whereDate('created_at', '<=', $end_date)
                            ->selectRaw(implode(',',$query1))->get();

        $total_sale = sale::whereDate('created_at', '>=', $start_date)
                            ->whereDate('created_at', '<=', $end_date)->count();

        $expense = Expense::whereDate('created_at','>=',$start_date)
                 ->whereDate('created_at','<=',$end_date)->sum('amount');

        $total_expense = Expense::whereDate('created_at','>=',$start_date)
                            ->whereDate('created_at','<=',$end_date)->count();

        $payroll = Payroll::whereDate('created_at','>=',$start_date)
                            ->whereDate('created_at','<=',$end_date)->sum('amount');

        $total_payroll = Payroll::whereDate('created_at','>=',$start_date)
                            ->whereDate('created_at','<=',$end_date)->count();

        $total_item = DB::table('warehouse_products as wp')
                    ->join('products as p','wp.product_id','=','p.id')
                    ->where([
                        ['p.status',1],
                        ['wp.qty','>',0]
                    ])->count();
        
        $payment_received_number = DB::table('payments')->whereNotNull('sale_id')
                                ->whereDate('created_at','>=',$start_date)
                                ->whereDate('created_at','<=',$end_date)
                                ->count(); 

        $payment_received = DB::table('payments')->whereNotNull('sale_id')
                                ->whereDate('created_at','>=',$start_date)
                                ->whereDate('created_at','<=',$end_date)
                                ->sum('amount');

        $cash_payment_sale = DB::table('payments')->where('payment_method',6)->whereNotNull('sale_id')
                                ->whereDate('created_at','>=',$start_date)
                                ->whereDate('created_at','<=',$end_date)
                                ->sum('amount');

        $cheque_payment_sale = DB::table('payments')->where('payment_method',7)->whereNotNull('sale_id')
                                ->whereDate('created_at','>=',$start_date)
                                ->whereDate('created_at','<=',$end_date)
                                ->sum('amount');

        $mobile_payment_sale = DB::table('payments')->where('payment_method',3)->whereNotNull('sale_id')
                                ->whereDate('created_at','>=',$start_date)
                                ->whereDate('created_at','<=',$end_date)
                                ->sum('amount');

        $payment_paid_number = DB::table('payments')->whereNotNull('purchase_id')
                                ->whereDate('created_at','>=',$start_date)
                                ->whereDate('created_at','<=',$end_date)->count(); 

        $payment_paid = DB::table('payments')->whereNotNull('purchase_id')
                                ->whereDate('created_at','>=',$start_date)
                                ->whereDate('created_at','<=',$end_date)
                                ->sum('amount');

        $cash_payment_purchase = DB::table('payments')->where('payment_method',1)
                                ->whereNotNull('purchase_id')
                                ->whereDate('created_at','>=',$start_date)
                                ->whereDate('created_at','<=',$end_date)
                                ->sum('amount');

         $cheque_payment_purchase = DB::table('payments')->where('payment_method',2)
                                ->whereNotNull('purchase_id')
                                ->whereDate('created_at','>=',$start_date)
                                ->whereDate('created_at','<=',$end_date)
                                ->sum('amount');

         $mobile_payment_purchase = DB::table('payments')->where('payment_method',3)
                                ->whereNotNull('purchase_id')
                                ->whereDate('created_at','>=',$start_date)
                                ->whereDate('created_at','<=',$end_date)
                                ->sum('amount');
                                
        $warehouses = Warehouse::where('status',1)->get();
        $warehouse_name = [];
        $warehouse_sale = [];
        $warehouse_purchase = [];
        $warehouse_expense = [];

        if(!$warehouses->isEmpty())
        {
            foreach ($warehouses as $warehouse) {
                $warehouse_name[] = $warehouse->name;
                $warehouse_sale[] = Sale::where('warehouse_id',$warehouse->id)
                                        ->whereDate('created_at','>=',$start_date)
                                        ->whereDate('created_at','<=',$end_date)
                                        ->selectRaw(implode(',',$query1))->get();

                $warehouse_purchase[] = Purchase::where('warehouse_id',$warehouse->id)
                                        ->whereDate('created_at','>=',$start_date)
                                        ->whereDate('created_at','<=',$end_date)
                                        ->selectRaw(implode(',',$query1))->get();

                $warehouse_expense[] = Expense::where('warehouse_id',$warehouse->id)
                                        ->whereDate('created_at','>=',$start_date)
                                        ->whereDate('created_at','<=',$end_date)
                                        ->sum('amount');
            }
        }

        return view('report::summary-report.report', compact('purchase','total_purchase','sale','total_sale','expense',
        'total_expense','payroll','total_payroll','total_item','payment_received_number','payment_received','cash_payment_sale','cheque_payment_sale','mobile_payment_sale',
        'payment_paid_number','payment_paid','cash_payment_purchase','cheque_payment_purchase','mobile_payment_purchase','warehouse_name','warehouse_sale','warehouse_purchase','warehouse_expense'))->render();

    }
    

}
