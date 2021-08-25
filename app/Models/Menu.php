<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function menuItems()
    {
        return $this->hasMany(Module::class)->doesntHave('parent')->orderBy('order','asc');
    }
}
