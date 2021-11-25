<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Category\Entities\Category;
use Modules\Report\Entities\ProductQuantityAlert;
use Modules\System\Entities\Brand;
use Modules\System\Entities\Unit;

class ProductQuantityALertController extends BaseController
{
    public function __construct(ProductQuantityAlert $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(permission('product-quantity-alert-access')){
            $this -> setPageData('Product Quantity Alert', 'Product Quantity Alert', 'fab fa-box');
            $data = [
                'brands' => Brand::toBase()->get(),
                'categories' => Category::toBase()->get(),
                'units' => Unit::toBase()->get(),
            ];
            return view('report::product-quantity-alert.index', $data);
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
        if(permission('product-quantity-alert-access')){
             if($request -> ajax()){
                             // Filter datatable
            if(!empty($request->name)){
                $this->model->setName($request->name);
            }
            if(!empty($request->code)){
                $this->model->setCode($request->code);
            }
            if(!empty($request->brand_id)){
                $this->model->setBrandId($request->brand_id);
            }
            if(!empty($request->category_id)){
                $this->model->setCategoryId($request->category_id);
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
                $row []    = tableImage($value->image,PRODUCT_IMAGE_PATH,$value->name);
                $row []    = $value->name;
                $row []    = $value->code; 
                $row []    = $value->brand->name;
                $row []    = $value->category->name;
                $row []    = $value->unit->unit_name;
                $row []    = number_format($value->qty, 2);
                $row []    = $value->alert_qty ? number_format($value->alert_qty, 2) : 0;
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
