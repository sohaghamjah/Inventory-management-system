<?php

namespace Modules\Expense\Entities;

use Modules\Account\Entities\Account;
use Modules\Base\Entities\BaseModel;
use Modules\System\Entities\Warehouse;
use Modules\Expense\Entities\ExpenseCategory;

class Expense extends BaseModel
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class,'expense_category_id','id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class,'warehouse_id','id');
    }
    public function account()
    {
        return $this->belongsTo(Account::class,'account_id','id');
    }

    protected $catgeory_id;
    protected $warehouse_id;
    protected $account_id;

    public function setCategoryID($catgeory_id)
    {
        $this->catgeory_id = $catgeory_id;
    }
    public function setWarehouseID($warehouse_id)
    {
        $this->warehouse_id = $warehouse_id;
    }
    public function setAccountID($account_id)
    {
        $this->account_id = $account_id;
    }

    // user list query
    private function getDataTableQuery(){

        if(permission('expense-bulk-delete')){
            $this->column_order = [null,'id','expense_category_id', 'warehouse_id', 'account_id', 'amount', 'note', 'status',null];
        }else{
            $this->column_order = ['id','expense_category_id', 'warehouse_id', 'account_id', 'amount', 'note', 'status',null];
        }

        $query = self::with('category:id,name','warehouse:id,name','account:id,name,account_no');

        // Menu data filter query
        if(!empty($this->catgeory_id)){
            $query->where('expense_catgeory_id', $this->catgeory_id);
        }
        if(!empty($this->warehouse_id)){
            $query->where('warehouse_id', $this->warehouse_id);
        }
        if(!empty($this->account_id)){
            $query->where('account_id', $this->account_id);
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
