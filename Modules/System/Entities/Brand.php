<?php

namespace Modules\System\Entities;

use Modules\Base\Entities\BaseModel;

class Brand extends BaseModel
{
    protected $fillable = ['name','image','status','created_bu','updated_by'];

    public $name;

    public function setName($name){
        $this->name = $name;
    }

    // user list query
    private function getDataTableQuery(){
        // column wise sorting
        if(permission('brand-bulk-delete')){
            $this->column_order = [null,'id','id','name','status',null];
        }else{
            $this->column_order = ['id','id','name','status',null];
        }
        
        // user list query
        $query = self::toBase();

        // Menu data filter query
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
