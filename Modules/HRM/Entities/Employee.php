<?php

namespace Modules\HRM\Entities;

use Modules\Base\Entities\BaseModel;
use Modules\HRM\Entities\Department;

class Employee extends BaseModel
{
    protected $guarded = [];

    public function department(){
        return $this->belongsTo(Department::class);
    }

    private $name;
    private $phone;
    private $department_id;

    public function setName($name){
        $this->name = $name;
    }
    public function setPhone($phone){
        $this->phone = $phone;
    }
    public function setDepartmentId($department_id){
        $this->department_id = $department_id;
    }

    // user list query
    private function getDataTableQuery(){
        // column wise sorting
        if(permission('customer-bulk-delete')){
            $this->column_order = [null,'id','image','name','phone','department_id','address','city','state','postal_code','country','status',null];
        }else{
            $this->column_order = ['id','image','name','phone','department_id','address','city','state','postal_code','country','status',null];
        }
        
        // user list query
        $query = self::with('department');

        // Menu data filter query
        if(!empty($this->name)){
            $query->where('name', 'like','%' .$this->name. '%');
        }
        if(!empty($this->department_id)){
            $query->where('department_id', 'like','%' .$this->department_id. '%');
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
