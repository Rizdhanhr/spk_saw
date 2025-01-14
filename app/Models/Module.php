<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'module';
    protected $fillable = ['name'];

    public function permission(){
        return $this->hasMany(Permission::class);
    }
}
