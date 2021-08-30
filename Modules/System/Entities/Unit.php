<?php

namespace Modules\System\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Support\Facades\Cache;

class Unit extends BaseModel
{
    protected $guarded = [];

    public function baseUnit(){
        return $this->belongsTo(Unit::class, 'base_unit','id')->withDefault(['unit_name'=>'N/A']);
    }

    protected $unit_name;

    public function setUnitName($unit_name){
        $this->unit_name = $unit_name;
    }

    // user list query
    private function getDataTableQuery(){
        // column wise sorting
        if(permission('unit-group-bulk-delete')){
            $this->column_order = [null,'id','unit_code','unit_name','base_unit','operator','operation_value','status',null];
        }else{
            $this->column_order = ['id','unit_code','unit_name','base_unit','operator','operation_value','status',null];
        }
        
        // user list query
        $query = self::with('baseUnit');

        // Menu data filter query
        if (!empty($this->unit_name)) {
            $query->where('unit_name', 'like', '%' . $this->unit_name . '%');
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

    private const ALL_UNITS = '_all_units';
    private const ACTIVE_UNITS = '_active_units';

    public static function allCustomerGroups()
    {
        return Cache::rememberForever(self::ALL_UNITS, function () {
            return self::toBase()->get();
        });
    }
    public static function activeCustomerGroups()
    {
        return Cache::rememberForever(self::ACTIVE_UNITS, function () {
            return self::toBase()->where('status',1)->get();
        });
    }

    public static function flushCache()
    {
        Cache::forget(self::ALL_UNITS);
        Cache::forget(self::ACTIVE_UNITS);
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
