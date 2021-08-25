<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function module_role(){
        return $this->belongsToMany(Module::class)->withTimestamps();
    }
    public function permission_role(){
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }
    public function users(){
        return $this->hasMany(User::class);
    }
}
