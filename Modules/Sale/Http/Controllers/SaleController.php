<?php

namespace Modules\Sale\Http\Controllers;

use Modules\Base\Http\Controllers\BaseController;
use App\Traits\UploadAble;
use Modules\Customer\Entities\Customer;
use Modules\Account\Entities\Account;
use Modules\Sale\Entities\Sale;
use Modules\System\Entities\Tax;
use Modules\System\Entities\Warehouse;

class SaleController extends BaseController
{
    use UploadAble;

    public function __construct(Sale $model)
    {
        $this->model = $model;
    }

    public function create()
    {
        if(permission('sale-add')){
            $this->setPageData('Add Sale','Add Sale','fas fa-plus-square');
            $customers  = Customer::all();
            $warehouses = Warehouse::where('status',1)->get();
            $taxes      = Tax::where('status',1)->get();
            $accounts   = Account::where('status',1)->get();
            return view('sale::create',compact('customers','accounts','warehouses','taxes'));
        }else{
            return $this->unauthorized_access_blocked();
        }
    }
}
