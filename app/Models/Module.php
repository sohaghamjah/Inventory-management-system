<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\NestableTrait;

class Module extends Model
{
    use HasFactory, NestableTrait;

    protected $guarded = [];

    public function menu(){
        $this->belongsTo(Menu::class);
    }

    public function parent(){
        return $this->belongsTo(Module::class,'parent_id','id');
    }

    public function children(){
        return $this->hasMany(Module::class,'parent_id','id');
    }

    public function submenu(){
        return $this->hasMany(Module::class, 'parent_id', 'id')
        ->orderBy('order', 'asc')
        ->with('permission:id,module_id,name');
    }

    public function permission(){
        return $this->hasMany(Permission::class);
    }

    public function module_role(){
        return $this->hasMany(ModuleRole::class);
    }
}
