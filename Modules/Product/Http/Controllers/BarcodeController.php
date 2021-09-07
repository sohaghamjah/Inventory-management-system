<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\BarcodeFormRequest;

class BarcodeController extends BaseController
{
    public function __construct(Product $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(permission('print-barcode-access')){
            $this -> setPageData('Barcode', 'Barcode', 'fab fa-barcode');
            $products = $this->model::all();
            return view('product::barcode.index', compact('products'));
        }else{
            return $this->unauthorizedAccessBlocked();
        }
       
    }

    public function generateBarcode(BarcodeFormRequest $request)
    {
        $data = [
            'name'              => $request->name,
            'code'              => $request->code,
            'barcode_symbology' => $request->barcode_symbology,
            'price'             => $request->price ? number_format($request->price,2) : '0.00',
            'barcode_qty'       => $request->barcode_qty,
            'row_qty'           => $request->row_qty,
            'width'             => $request->width,
            'height'            => $request->height,
            'unit'              => $request->unit,
        ];
        // return $data;
        return view('product::barcode.barcode', $data)->render();
    }
}
