<?php

namespace Modules\Sale\Entities;

use Modules\Base\Entities\BaseModel;

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
}
