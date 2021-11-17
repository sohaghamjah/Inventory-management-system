<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sale\Entities\Sale;
use Modules\System\Entities\Warehouse;

class SaleReportController extends Controller
{
    protected function setPageData($page_title, $sub_title, $page_icon){
        view()->share(['page_title' => $page_title, 'sub_title' => $sub_title, 'page_icon' => $page_icon]);
    }

    public function dailySale()
    {
        if(permission('daily-sale-access')){

            $this -> setPageData('Daily Sale Report', 'Daily Sale Report', 'fas fa-file-signature');
            $warehouses = Warehouse::where('status',1)->get();

            return view('report::sale.daily.index',  compact('warehouses'));

        }else{
            return redirect('unauthorized');
        }
    }

    public function dailySaleReport(Request $request){
        if($request->ajax()){
            $warehouse_id   = $request->warehouse_id;
            $month          = $request->month;
            $year           = $request->year;
            $start          = 1;
            $number_of_day  = cal_days_in_month(CAL_GREGORIAN,$month,$year);

            $total_discount = [];
            $order_discount = [];
            $total_tax      = [];
            $order_tax      = [];
            $shipping_cost  = [];
            $grand_total    = [];

            while ($start <= $number_of_day) {
                $date = ($start < 10) ? $year.'-'.$month.'-0'.$start : $year.'-'.$month.'-'.$start;

                $query = [
                    'SUM(total_discount) as total_discount',
                    'SUM(order_discount) as order_discount',
                    'SUM(total_tax) as total_tax',
                    'SUM(order_tax) as order_tax',
                    'SUM(shipping_cost) as shipping_cost',
                    'SUM(grand_total) as grand_total',
                ];

                $sale_data = Sale::whereDate('created_at', $date)->selectRaw(implode(',',$query));
                if($warehouse_id != 0){
                    $sale_data->where('warehouse_id', $warehouse_id)->get();
                }else{
                   $sale_data = $sale_data->get();
                }
                if($sale_data)
                {
                    $total_discount[$start] = $sale_data[0]->total_discount;
                    $order_discount[$start] = $sale_data[0]->order_discount;
                    $total_tax     [$start] = $sale_data[0]->total_tax;
                    $order_tax     [$start] = $sale_data[0]->order_tax;
                    $shipping_cost [$start] = $sale_data[0]->shipping_cost;
                    $grand_total   [$start] = $sale_data[0]->grand_total;
                }
                $start++;
            }

            $start_date  = date('w',strtotime($year.'-'.$month.'-01')) + 1;
            $prev_year  = date('Y',strtotime('-1 month',strtotime($year.'-'.$month.'-01')));
            $prev_month = date('m',strtotime('-1 month',strtotime($year.'-'.$month.'-01')));
            $next_year  = date('Y',strtotime('+1 month',strtotime($year.'-'.$month.'-01')));
            $next_month = date('m',strtotime('+1 month',strtotime($year.'-'.$month.'-01')));

            return view('report::sale.daily.report',compact('total_discount','order_discount','total_tax','order_tax','shipping_cost','grand_total',
            'start_date','year','month','number_of_day','prev_year','prev_month','next_year','next_month'))->render();
        }
    }

    public function monthlySale()
    {
        if(permission('monthly-sale-access')){

            $this -> setPageData('Monthly Sale Report', 'Monthly Sale Report', 'fas fa-file-signature');
            $warehouses = Warehouse::where('status',1)->get();

            return view('report::sale.monthly.index',  compact('warehouses'));

        }else{
            return redirect('unauthorized');
        }
    }

    public function monthlySaleReport(Request $request){
        if($request->ajax()){

            $warehouse_id = $request->warehouse_id;
            $year         = $request->year;
            $start = strtotime($year.'-01-01');
            $end = strtotime($year.'-12-31');

            $total_discount = [];
            $order_discount = [];
            $total_tax = [];
            $order_tax = [];
            $shipping_cost = [];
            $grand_total = [];

            while ($start <= $end) {
                $start_date = $year.'-'.date('m',$start).'-'.'01';
                $end_date = $year.'-'.date('m',$end).'-'.'31';

                $temp_total_discount = Sale::whereDate('created_at','>=',$start_date)->whereDate('created_at','<=',$end_date);
                $temp_order_discount = Sale::whereDate('created_at','>=',$start_date)->whereDate('created_at','<=',$end_date);
                $temp_total_tax = Sale::whereDate('created_at','>=',$start_date)->whereDate('created_at','<=',$end_date);
                $temp_order_tax = Sale::whereDate('created_at','>=',$start_date)->whereDate('created_at','<=',$end_date);
                $temp_shipping_cost = Sale::whereDate('created_at','>=',$start_date)->whereDate('created_at','<=',$end_date);
                $temp_grand_total = Sale::whereDate('created_at','>=',$start_date)->whereDate('created_at','<=',$end_date);

                if($warehouse_id  != 0)
                {
                    $temp_total_discount->where('warehouse_id',$warehouse_id);
                    $temp_order_discount->where('warehouse_id',$warehouse_id);
                    $temp_total_tax->where('warehouse_id',$warehouse_id);
                    $temp_order_tax->where('warehouse_id',$warehouse_id);
                    $temp_shipping_cost->where('warehouse_id',$warehouse_id);
                    $temp_grand_total->where('warehouse_id',$warehouse_id);
                }

                $temp_total_discount = $temp_total_discount->sum('total_discount');
                $total_discount[] = number_format((float)$temp_total_discount,2,'.',',');

                $temp_order_discount = $temp_order_discount->sum('order_discount');
                $order_discount[] = number_format((float)$temp_order_discount,2,'.',',');

                $temp_total_tax = $temp_total_tax->sum('total_tax');
                $total_tax[] = number_format((float)$temp_total_tax,2,'.',',');

                $temp_order_tax =  $temp_order_tax->sum('order_tax');
                $order_tax[] = number_format((float)$temp_order_tax,2,'.',',');

                $temp_shipping_cost =  $temp_shipping_cost->sum('shipping_cost');
                $shipping_cost[] = number_format((float)$temp_shipping_cost,2,'.',',');

                $temp_grand_total =  $temp_grand_total->sum('grand_total');
                $grand_total[] = number_format((float)$temp_grand_total,2,'.',',');

                $start = strtotime('+1 month',$start);
            }

            return view('report::sale.monthly.report',compact('year','total_discount','order_discount','total_tax','order_tax','shipping_cost','grand_total'))->render();
        }
    }

}
