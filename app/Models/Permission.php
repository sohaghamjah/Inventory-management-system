<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function module(){
        return $this->belongsTo(Module::class);
    }

    public function permission_role(){
        return $this->hasMany(PermissionRole::class);
    }
}
