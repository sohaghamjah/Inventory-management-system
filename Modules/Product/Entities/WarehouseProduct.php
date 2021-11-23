<?php

namespace Modules\Product\Entities;

use Illuminate\Support\Facades\DB;
use Modules\Base\Entities\BaseModel;

class WarehouseProduct extends BaseModel
{
    protected $table = 'warehouse_products';  
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    protected $order = ['p.id'=>'asc'];
    private $name;
    private $warehouse_id;

    public function setName($name){
        $this->name = $name;
    }
    public function setWarehouseId($warehouse_id){
        $this->warehouse_id = $warehouse_id;
    }

    // user list query
    private function getDataTableQuery(){
        // column wise sorting
        $this->column_order = ['p.id','w.name','p.name','p.code', 'c.name','p.unit_id', 'wp.qty'];
        
        // user list query
        $query = DB::table('warehouse_products as wp')
                ->selectRaw('wp.qty,w.name as warehouse_name, p.name,p.code,c.name as category_name,u.unit_name')
                ->join('warehouses as w','wp.warehouse_id','=','w.id')
                ->join('products as p','wp.product_id','=','p.id')
                ->join('categories as c','p.category_id','=','c.id')
                ->join('units as u','p.unit_id','=','u.id');
        
        if($this->warehouse_id != 0){
            $query->where('wp.warehouse_id', $this->warehouse_id);
        }
        if (!empty($this->name)) {
            $query->where('p.name', 'like', '%' . $this->name . '%');
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
        $query = DB::table('warehouse_products as wp')
        ->selectRaw('wp.qty,w.name as warehouse_name, p.name,p.code,c.name as category_name,u.unit_name')
        ->join('warehouses as w','wp.warehouse_id','=','w.id')
        ->join('products as p','wp.product_id','=','p.id')
        ->join('categories as c','p.category_id','=','c.id')
        ->join('units as u','p.unit_id','=','u.id');

        if($this->warehouse_id != 0){
            $query->where('wp.warehouse_id', $this->warehouse_id);
        }

        return $query->get()->count();
    }

}
