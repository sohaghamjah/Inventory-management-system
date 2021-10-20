<?php

namespace Modules\Sale\Entities;

use Modules\Base\Entities\BaseModel;
use Modules\Customer\Entities\Customer;
use Modules\Product\Entities\Product;
use Modules\Account\Entities\Payment;

class Sale extends BaseModel
{
    protected $guarded = [];
    
    public function customer()
     {
         return $this->belongsTo(Customer::class);
     }

     public function sale_products()
     {
         return $this->belongsToMany(Product::class,'sale_products','sale_id','product_id','id','id')
                    ->withPivot(['qty', 'sale_unit_id', 
                    'net_unit_price', 'discount', 'tax_rate', 'tax', 'total'])
                    ->withTimestamps();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class,'sale_id','id');
    }

    protected $sale_no;
    protected $customer_id;
    protected $from_date;
    protected $to_date;
    protected $sale_status;
    protected $payment_status;

    public function setSaleNo($sale_no)
    {
        $this->sale_no = $sale_no;
    }
    public function setCustomerID($customer_id)
    {
        $this->customer_id = $customer_id;
    }
    public function setFromDate($from_date)
    {
        $this->from_date = $from_date;
    }
    public function setToDate($to_date)
    {
        $this->to_date = $to_date;
    }
    public function setSaleStatus($sale_status)
    {
        $this->sale_status = $sale_status;
    }
    public function setPaymentStatus($payment_status)
    {
        $this->payment_status = $payment_status;
    }

     // user list query
     private function getDataTableQuery(){
        // column wise sorting
        if(permission('sale-bulk-delete')){
            $this->column_order = [null,'id','sale_no', 'customer_id', 'item', 'total_qty', 
            'total_discount', 'total_tax', 'total_price', 'order_tax_rate', 'order_tax', 'order_discount',
            'shipping_cost', 'grand_total', 'paid_amount', null,'sale_status', 'payment_status','created_by','created_at',null];
        }else{
            $this->column_order = ['id','sale_no', 'customer_id', 'item', 'total_qty', 
            'total_discount', 'total_tax', 'total_price', 'order_tax_rate', 'order_tax', 'order_discount',
            'shipping_cost', 'grand_total', 'paid_amount', null,'sale_status', 'payment_status','created_by','created_at',null];
        }

        $query = self::with('customer');

        /*****************
         * *Search Data **
         ******************/
        if (!empty($this->sale_no)) {
            $query->where('sale_no', 'like', '%' . $this->sale_no . '%');
        }
        if (!empty($this->customer_id)) {
            $query->where('customer_id', $this->customer_id);
        }
        if (!empty($this->from_date)) {
            $query->where('created_at', '>=',$this->from_date.' 00:00:00');
        }
        if (!empty($this->to_date)) {
            $query->where('created_at', '<=',$this->to_date.' 23:59:59');
        }
        if (!empty($this->sale_status)) {
            $query->where('sale_status', $this->sale_status);
        }
        if (!empty($this->payment_status)) {
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
