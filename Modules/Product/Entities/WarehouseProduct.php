<?php

namespace Modules\Product\Entities;

use Modules\Base\Entities\BaseModel;

class WarehouseProduct extends BaseModel
{
    protected $table = 'warehouse_products';  
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
