<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Customer\Entities\Customer;
use Modules\Report\Entities\CustomerReport;

class CustomerReportController extends BaseController
{
    public function __construct(CustomerReport $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if(permission('customer-reprot-access')){
            $this->setPageData('Customer Report','Customer Report','fas fa-shoppingcart');
            $customers = Customer::all();
            return view('report::customer-report.index',compact('customers'));
        }else{
            return $this->unauthorizedAccessBlocked();
        }
    }

        /**
     * getDataTableData function
     *
     * @param Request $request
     * @return void
     */
    public function getDataTableData(Request $request){
        if(permission('customer-reprot-access')){
            if($request -> ajax()){
                // Filter datatable
                if (!empty($request->sale_no)) {
                    $this->model->setSaleNo($request->sale_no);
                }
                if (!empty($request->customer_id)) {
                    $this->model->setCustomerID($request->customer_id);
                }
                if (!empty($request->from_date)) {
                    $this->model->setFromDate($request->from_date);
                }
                if (!empty($request->to_date)) {
                    $this->model->setToDate($request->to_date);
                }


                // Show uer list
                $this->setDatatableDefalutlProperty($request);

                $list = $this->model->getDataTableList(); 

                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    $no++;
                    $row = [];
                    $row[] = $no;
                    $row[] = $value->customer->name.' - '.$value->customer->phone;
                    $row[] = $value->sale_no;
                    $row[] = date(config('settings.date_format'),strtotime($value->created_at));
                    $row[] = number_format($value->grand_total,2,'.',',');
                    $row[] = number_format($value->paid_amount,2,'.',',');
                    $row[] = number_format(($value->grand_total - $value->paid_amount),2,'.',',');
                    $data[] = $row;
                }
                return $this->datatableDraw($request->input('draw'), $this->model-> countFilter(), $this->model-> countAll(), $data);
            }else{
                $output = $this->accessBlocked();
            }
            return response()->json($output);
        }
    }

}
