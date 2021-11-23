<?php

namespace Modules\Report\Entities;

use Modules\Base\Entities\BaseModel;
use Modules\Customer\Entities\Customer;

class CustomerReport extends BaseModel
{
    protected $table = "sales";

    protected $guarded = [];
    
    public function customer()
     {
         return $this->belongsTo(Customer::class);
     }

    protected $sale_no;
    protected $customer_id;
    protected $from_date;
    protected $to_date;

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

     // user list query
     private function getDataTableQuery(){
        // column wise sorting
        $this->column_order = ['id','customer_id','sale_no','created_at','grand_total','paid_amount',null];

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
        $query = self::toBase();
        if (!empty($this->customer_id)) {
            $query->where('customer_id', $this->customer_id);
        }
        return $query->get()->count();
    }
}
