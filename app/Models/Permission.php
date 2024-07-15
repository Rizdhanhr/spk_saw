<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permission';
    protected $fillable = ['name','slug','module_id'];

    public function module(){
        return $this->belongsTo(Module::class,'module_id');
    }

    public function role(){
        return $this->belongsToMany(Role::class,'role_permission','permission_id','role_id')->withPivot('role_id', 'permission_id');
    }
}
