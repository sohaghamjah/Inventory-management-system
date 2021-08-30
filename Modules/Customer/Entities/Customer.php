<?php

namespace Modules\Customer\Entities;

use Modules\Base\Entities\BaseModel;
use Modules\System\Entities\CustomerGroup;

class Customer extends BaseModel
{
    protected $guarded = [];

    public function customerGroup(){
        return $this->belongsTo(CustomerGroup::class);
    }

    protected $customer_group_id;
    protected $name;
    protected $phone;
    protected $emeil;

    public function setName($name){
        $this->name = $name;
    }
    public function customerGroupId($customer_group_id){
        $this->customer_group_id = $customer_group_id;
    }
    public function setPhone($phone){
        $this->phone = $phone;
    }
    public function setEmail($email){
        $this->email = $email;
    }

    // user list query
    private function getDataTableQuery(){
        // column wise sorting
        if(permission('customer-bulk-delete')){
            $this->column_order = [null,'id','customer_group_id','name','phone','company_name','tax_number','email','address','city','state','postal_code','country','status',null];
        }else{
            $this->column_order = ['id','customer_group_id','name','phone','company_name','tax_number','email','address','city','state','postal_code','country','status',null];
        }
        
        // user list query
        $query = self::with('customerGroup');

        // Menu data filter query
        if(!empty($this->name)){
            $query->where('name', 'like','%' .$this->name. '%');
        }
        if(!empty($this->customer_group_id)){
            $query->where('customer_group_id', $this->customer_group_id);
        }
        if(!empty($this->email)){
            $query->where('email', 'like','%' .$this->email. '%');
        }
        if(!empty($this->phone)){
            $query->where('phone', 'like','%' .$this->phone. '%');
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
