<?php

namespace Modules\Purchase\Entities;

use Modules\Account\Entities\Payment;
use Modules\Base\Entities\BaseModel;
use Modules\Product\Entities\Product;
use Modules\Supplier\Entities\Supplier;

class Purchase extends BaseModel
{
    protected $guarded = [];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseProducts(){
        return $this->belongsToMany(Product::class, 'purchase_products', 'purchase_id', 'product_id', 'id' , 'id')
        ->withPivot('qty', 'received', 'unit_id', 'net_unit_cost', 'discount', 'tax_rate', 'tax', 'total')
        ->withTimestamps();
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    private $purchase_no;
    private $suplier_id;
    private $from_date;
    private $to_date;
    private $purchase_status;
    private $payment_status;

    public function setPurchaseNo($purchase_no){
        $this->purchase_no = $purchase_no;
    }
    public function setSuplierId($suplier_id){
        $this->suplier_id = $suplier_id;
    }
    public function setFromDate($from_date){
        $this->from_date = $from_date;
    }
    public function setToDate($to_date){
        $this->to_date = $to_date;
    }
    public function setPurchaseStatus($purchase_status){
        $this->purchase_status = $purchase_status;
    }
    public function setPaymentStatus($payment_status){
        $this->payment_status = $payment_status;
    }

    // user list query
    private function getDataTableQuery(){
        // column wise sorting
        if(permission('purchase-bulk-delete')){
            $this->column_order = [null,'id','purchase_no', 'supplier_id', 'item', 'total_qty', 'total_discount', 'total_tax', 'total_cost', 'total_tax_rate', 'order_tax', 'order_discount', 'shipping_cost', 'grand_total', 'paid_amount', null ,'purchase_status', 'payment_status','created_by','created_at',null];
        }else{
            $this->column_order = ['id','purchase_no', 'supplier_id', 'item', 'total_qty', 'total_discount', 'total_tax', 'total_cost', 'total_tax_rate', 'order_tax', 'order_discount', 'shipping_cost', 'grand_total', 'paid_amount', null ,'purchase_status', 'payment_status','created_by','created_at',null];
        }
        
        // user list query
        $query = self::with(['supplier']);

        // Menu data filter query
        if(!empty($this->purchase_no)){
            $query->where('purchase_no', 'like','%' .$this->purchase_no. '%');
        }
        if (!empty($this->from_date)) {
            $query->where('created_at', '>=',$this->from_date.' 00:00:00');
        }
        if (!empty($this->to_date)) {
            $query->where('created_at', '<=',$this->to_date.' 23:59:59');
        }
        if(!empty($this->suplier_id)){
            $query->where('suplier_id',  $this->suplier_id);
        }
        if(!empty($this->purchase_status)){
            $query->where('purchase_status', $this->purchase_status);
        }
        if(!empty($this->payment_status)){
            $query->where('payment_status', $this->payment_status);
        }

        // Sorting
        if(isset($this->orderValue) && isset($this->dirValue)){
            $query->orderBy($this->column_order[$this->orderValue], $this->dirValue);
        }else if(isset($this->order)){
            $query->orderBy(key($this->order), $this->order[key($this->order)]);
        }
        return $query;
    }

    public function getDataTableList()
    {
        $query = $this->getDataTableQuery();
        if ($this->lengthValue != -1) {
            $query->offset($this->startValue)->limit($this->lengthValue);
        }
        return $query->get();
    }

    // count function
    public function countFilter(){
        $query = $this->getDataTableQuery();
        return $query->get()->count();
    }

    public function countAll(){
        return self::toBase()->get()->count();
    }

}
