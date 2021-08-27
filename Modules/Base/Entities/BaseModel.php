<?php

namespace Modules\Base\Entities;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $order = ['id'=>'desc'];
    protected $column_order;

    protected $orderValue;
    protected $dirValue;
    protected $startValue;
    protected $lengthVlaue;

    public function setOrderValue($orderValue)
    {
        $this->orderValue = $orderValue;
    }
    public function setDirValue($dirValue)
    {
        $this->dirValue = $dirValue;
    }
    public function setStartValue($startValue)
    {
        $this->startValue = $startValue;
    }
    public function setLengthValue($lengthValue)
    {
        $this->lengthValue = $lengthValue;
    }
}
