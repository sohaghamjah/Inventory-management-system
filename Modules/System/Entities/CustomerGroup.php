<?php

namespace Modules\System\Entities;

use Illuminate\Support\Facades\Cache;
use Modules\Base\Entities\BaseModel;

class CustomerGroup extends BaseModel
{
    protected $guarded = [];

    protected $group_name;

    public function setGroupName($group_name){
        $this->group_name = $group_name;
    }

    // user list query
    private function getDataTableQuery(){
        // column wise sorting
        if(permission('customer-group-bulk-delete')){
            $this->column_order = [null,'id','group_name','percentage','status',null];
        }else{
            $this->column_order = ['id','group_name','percentage','status',null];
        }
        
        // user list query
        $query = self::toBase();

        // Menu data filter query
        if(!empty($this->group_name)){
            $query->where('group_name', 'like','%' .$this->group_name. '%');
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

    //==================== Cache Data =========================

    private const ALL_CUSTOMER_GROUPS = '_all_customer_groups';
    private const ACTIVE_CUSTOMER_GROUPS = '_active_customer_groups';

    public static function allCustomerGroups()
    {
        return Cache::rememberForever(self::ALL_CUSTOMER_GROUPS, function () {
            return self::toBase()->get();
        });
    }
    public static function activeCustomerGroups()
    {
        return Cache::rememberForever(self::ACTIVE_CUSTOMER_GROUPS, function () {
            return self::toBase()->where('status',1)->get();
        });
    }

    public static function flushCache()
    {
        Cache::forget(self::ALL_CUSTOMER_GROUPS);
        Cache::forget(self::ACTIVE_CUSTOMER_GROUPS);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function(){
            self::flushCache();
        });
        static::updated(function(){
            self::flushCache();
        });
        static::deleted(function(){
            self::flushCache();
        });
    }
}
