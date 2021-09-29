<?php

namespace Modules\Account\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function account(){
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
}
