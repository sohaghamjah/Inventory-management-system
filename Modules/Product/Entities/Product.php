<?php

namespace Modules\Product\Entities;

use Modules\Base\Entities\BaseModel;
use Modules\Category\Entities\Category;
use Modules\System\Entities\Brand;
use Modules\System\Entities\Tax;
use Modules\System\Entities\Unit;

class Product extends BaseModel
{

    protected $guarded = [];

    public function brand(){
        return $this->belongsTo(Brand::class)->withDefault(['name'=>'No Brand']);
    }
    public function category(){ 
        return $this->belongsTo(Category::class);
    }
    public function unit(){
        return $this->belongsTo(Unit::class);
    }
    public function purchaseUnit(){
        return $this->belongsTo(Unit::class, 'purchase_unit_id', 'id');
    }
    public function saleUnit(){
        return $this->belongsTo(Unit::class, 'sale_unit_id', 'id');
    }
    public function tax(){
        return $this->belongsTo(Tax::class)->withDefault(['name'=>'No tax', 'tax' => 0]);
    }

    private $_name;
    private $code;
    private $brand_id;
    private $category_id;

    public function setName($name){
        $this->_name = $name;
    }
    public function setCode($code){
        $this->code = $code;
    }
    public function setBrandId($brand_id){
        $this->$brand_id = $brand_id;
    }
    public function setCategoryId($category_id){
        $this->$category_id = $category_id;
    }

    // user list query
    private function getDataTableQuery(){
        // column wise sorting
        if(permission('product-bulk-delete')){
            $this->column_order = [null,'id','id','name','code','brand_id','category_id','unit_id','cost','price','qty','alert_qty','tax_id','tax_method','status',null];
        }else{
            $this->column_order = ['id','id','name','code','brand_id','category_id','unit_id','cost','price','qty','alert_qty','tax_id','tax_method','status',null];
        }
        
        // user list query
        $query = self::with(['brand','category','unit','purchaseUnit','saleUnit','tax']);

        // Menu data filter query
        if(!empty($this->_name)){
            $query->where('name', 'like','%' .$this->_name. '%');
        }
        if(!empty($this->code)){
            $query->where('code', 'like','%' .$this->code. '%');
        }
        if(!empty($this->brand_id)){
            $query->where('brand_id', $this->brand_id);
        }
        if(!empty($this->category_id)){
            $query->where('category_id', $this->category_id);
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
