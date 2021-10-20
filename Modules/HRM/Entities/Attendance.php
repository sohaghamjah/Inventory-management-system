<?php

namespace Modules\HRM\Entities;

use Modules\Base\Entities\BaseModel;
use Modules\HRM\Entities\Employee;

class Attendance extends BaseModel
{
    protected $guarded = [];
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    protected $employee_id;
    protected $fromDate;
    protected $toDate;

    public function setEmployeeID($employee_id)
    {
        $this->employee_id = $employee_id;
    }
    public function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;
    }
    public function setToDate($toDate)
    {
        $this->toDate = $toDate;
    }

    // user list query
    private function getDataTableQuery(){
        // column wise sorting
        if(permission('attendance-bulk-delete')){
            $this->column_order = [null,'id','employee_id','check_in','check_out','date','status',null];
        }else{
            $this->column_order = ['id','employee_id','check_in','check_out','date','status',null];
        }
        
        // user list query
        $query = self::with('employee');

        // Menu data filter query
        if (!empty($this->employee_id)) {
            $query->where('employee_id',  $this->employee_id );
        }
        if (!empty($this->fromDate)) {
            $query->where('date',  '>=',$this->fromDate );
        }
        if (!empty($this->toDate)) {
            $query->where('date',  '<=',$this->toDate );
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
