<?php

namespace Modules\Stock\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\WarehouseProduct;
use Modules\System\Entities\Warehouse;

class StockController extends Controller
{
    public function __construct(WarehouseProduct $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(permission('atock-access')){
            $this -> setPageData('Manage Stock', 'Manage Stock', 'fab fa-boxes');
            $data = [
                'warehouse' => Warehouse::toBase()->pluch('name','id')
            ];
            return view('stock::index', $data);
        }else{
            return $this->unauthorizedAccessBlocked();
        }
    }

    public function getDataTableData(Request $request){
        if(permission('atock-access')){
             if($request -> ajax()){
                             // Filter datatable
            if(!empty($request->name)){
                $this->model->setName($request->name);
            }
            if(!empty($request->warehouse_id)){
                $this->model->setWarehouseId($request->warehouse_id);
            }

            // Show uer list
            $this->setDatatableDefalutlProperty($request);

            $list = $this->model->getDataTableList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $row = [];  
                $row []    = $no;
                $row []    = $value->warehouse_name;
                $row []    = $value->name;
                $row []    = $value->code; 
                $row []    = $value->category_name;
                $row []    = $value->unit_name;
                $row []    = number_format($value->qty, 2);
                $data[]    = $row;
            }
            return $this->datatableDraw($request->input('draw'), $this->model-> countFilter(), $this->model-> countAll(), $data);
             }else{
                 $output = $this->accessBlocked();
             }
             return response()->json($output);
        }
    }
}
