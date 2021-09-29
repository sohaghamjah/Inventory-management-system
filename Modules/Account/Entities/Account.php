<?php

namespace Modules\Account\Entities;

use Modules\Base\Entities\BaseModel;

class Account extends BaseModel
{
    protected $guarded = [];

    protected $account_no;
    protected $name;

    public function setAccountNo($account_no){
        $this->account_no = $account_no;
    }
    public function setName($name){
        $this->name = $name;
    }

    // user list query
    private function getDataTableQuery(){
        // column wise sorting
        if(permission('account-bulk-delete')){
            $this->column_order = [null,'id','account_no','name','initial_balance','note','status',null];
        }else{
            $this->column_order = ['id','account_no','name','initial_balance','note','status',null];
        }
        
        // user list query
        $query = self::toBase();

        // Menu data filter query
        if(!empty($this->account_no)){
            $query->where('account_no', 'like','%' .$this->account_no. '%');
        }
        if(!empty($this->name)){
            $query->where('name', 'like','%' .$this->name. '%');
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
