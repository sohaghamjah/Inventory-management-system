<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Purchase\Entities\Purchase;
use Modules\Report\Entities\SupplierReport;
use Modules\Supplier\Entities\Supplier;

class SupplierReportController extends BaseController
{
    public function __construct(SupplierReport $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if(permission('supplier-report-access')){
            $this -> setPageData('Supplier Report ', 'Supplier Report ', 'fab fa-box');
            $suppliers = Supplier::all();
            return view('report::supplier-report.index', compact('suppliers'));
        }else{
            return $this->unauthorizedAccessBlocked();
        }
    }

    public function getDataTableData(Request $request){
        if(permission('supplier-report-access')){
            if($request -> ajax()){
                // Filter datatable
                if(!empty($request->purchase_no)){
                    $this->model->setPurchaseNo($request->purchase_no);
                }
                if(!empty($request->suplier_id)){
                    $this->model->setSuplierId($request->suplier_id);
                }
                if(!empty($request->from_date)){
                    $this->model->setFromDate($request->from_date);
                }
                if(!empty($request->to_date)){
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
                    $row[] = $value->supplier->name.' - '.$value->supplier->phone;
                    $row[] = $value->purchase_no;
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
