<?php

namespace Modules\Report\Entities;

use Modules\Base\Entities\BaseModel;
use Modules\Supplier\Entities\Supplier;

class SupplierReport extends BaseModel
{
    protected $table = 'purchases';
    protected $guarded = [];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    private $purchase_no;
    private $suplier_id;
    private $from_date;
    private $to_date;

    public function setPurchaseNo($purchase_no){
        $this->purchase_no = $purchase_no;
    }
    public function setSuplierId($suplier_id){
        $this->suplier_id = $suplier_id;
    }
    public function setFromDate($from_date){
        $this->from_date = $from_date;
    }
    public function setToDate($to_date){
        $this->to_date = $to_date;
    }

    // user list query
    private function getDataTableQuery(){
        // column wise sorting
        $this->column_order = ['id','supplier_id','purchase_no','created_at','grand_total','paid_amount',null];
        
        // user list query
        $query = self::with(['supplier']);

        // Menu data filter query
        if(!empty($this->purchase_no)){
            $query->where('purchase_no', 'like','%' .$this->purchase_no. '%');
        }
        if (!empty($this->from_date)) {
            $query->where('created_at', '>=',$this->from_date.' 00:00:00');
        }
        if (!empty($this->to_date)) {
            $query->where('created_at', '<=',$this->to_date.' 23:59:59');
        }
        if(!empty($this->suplier_id)){
            $query->where('suplier_id',  $this->suplier_id);
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
        if(!empty($this->suplier_id)){
            $query->where('supplier_id', $this->suplier_id);
        }
        return $query->get()->count();
    }
}
