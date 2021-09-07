<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Purchase\Entities\Purchase;
use Modules\Supplier\Entities\Supplier;
use Modules\System\Entities\Tax;
use Modules\System\Entities\Warehouse;

class PurchaseController extends BaseController
{
    public function __construct(Purchase $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if(permission('purchase-access')){
            $this -> setPageData('Manage Purchase ', 'Manage Purchase ', 'fab fa-box');
            return view('purchase::index');
        }else{
            return $this->unauthorizedAccessBlocked();
        }
    }
    public function create()
    {
        if(permission('purchase-add')){
            $this -> setPageData('Add Purchase', 'Add Purchase', 'fab fa-plus-square');
            $data=[
                'suppliers'=>Supplier::where('status',1)->get(),
                'warehouses'=>Warehouse::where('status',1)->get(),
                'taxes'=>Tax::where('status',1)->get(),
            ];
            return view('purchase::create',$data);
        }else{
            return $this->unauthorizedAccessBlocked();
        }
    }
}
