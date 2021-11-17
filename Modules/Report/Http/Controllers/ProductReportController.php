<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\WarehouseProduct;
use Modules\Purchase\Entities\PurchaseProduct;
use Modules\Sale\Entities\SaleProduct;
use Modules\System\Entities\Warehouse;

class ProductReportController extends Controller
{
    protected function setPageData($page_title, $sub_title, $page_icon){
        view()->share(['page_title' => $page_title, 'sub_title' => $sub_title, 'page_icon' => $page_icon]);
    }

    public function index(Request $request)
    {
        if(permission('product-report-access')){
            $this -> setPageData('Product Report', 'Product Report', 'fas fa-file-signature');

            $data = $request->all();

            if($data){
                $start_date   = $data['start_date'] ? $data['start_date'] : date('Y-m').'-01';
                $end_date     = $data['end_date'] ? $data['end_date'] : date('Y-m-d');
                $warehouse_id = $data['warehouse_id'] ? $data['warehouse_id'] : 0;
            }else{
                $start_date   = date('Y-m').'-01';
                $end_date     = date('Y-m-d');
                $warehouse_id = 0;
            }

            $warehouses = Warehouse::where('status', 1)->get();
            $product_all = Product::select('id','name','qty')->where('status',1)->get();

            $product_id   = [];
            $product_name = [];
            $product_qty  = [];

            if(!$product_all->isEmpty()){
                foreach ($product_all as $product) {
                    $product_purchase_data = null;
                    if($warehouse_id == 0){
                        $product_purchase_data = PurchaseProduct::where('product_id', $product -> id)
                                                ->whereDate('created_at','>=',$start_date)
                                                ->whereDate('created_at','<=',$end_date)
                                                ->first();
                    }else{
                        $product_purchase_data = DB::table('purchases as p')
                        ->join('purchase_products as pp','p.id','=','pp.purchase_id')
                        ->where([
                            ['pp.product_id',$product->id],
                            ['p.warehouse_id',$warehouse_id],
                        ])
                        ->whereDate('p.created_at','>=',$start_date)
                        ->whereDate('p.created_at','<=',$end_date)
                        ->first();
                    }

                    if($product_purchase_data){
                        $product_id[] = $product -> id;
                        $product_name[] = $product -> name;
                        if($warehouse_id == 0)
                        {
                            $product_qty[] = $product->qty;
                        }else{
                            $product_qty[] = WarehouseProduct::where([
                                ['product_id',$product->id],
                                ['warehouse_id',$warehouse_id],
                            ])->sum('qty');
                        }
                    }else{
                        if($warehouse_id == 0)
                        {
                            $product_sale_data = SaleProduct::where('product_id',$product->id)
                                                        ->whereDate('created_at','>=',$start_date)
                                                        ->whereDate('created_at','<=',$end_date)
                                                        ->first();
                        }else{
                            $product_sale_data = DB::table('sales as s')
                            ->join('sale_products as sp','s.id','=','sp.sale_id')
                            ->where([
                                ['sp.product_id',$product->id],
                                ['s.warehouse_id',$warehouse_id],
                            ])
                            ->whereDate('s.created_at','>=',$start_date)
                            ->whereDate('s.created_at','<=',$end_date)
                            ->first();

                        }
                        if($product_sale_data){
                            $product_id[]=$product->id;
                            $product_name[]=$product->name;
                            if($warehouse_id == 0)
                            {
                                $product_qty[] = $product->qty;
                            }else{
                                $product_qty[] = WarehouseProduct::where([
                                    ['product_id',$product->id],
                                    ['warehouse_id',$warehouse_id],
                                ])->sum('qty');
                            }
                        }
                    }
                }
            }

            return view('report::product-report.index', compact('warehouses','product_id',
            'product_name','product_qty','start_date','end_date','warehouse_id'));
        }else{
            return redirect('unauthorized');
        }
    }
}
