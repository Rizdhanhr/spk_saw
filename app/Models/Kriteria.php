<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
    protected $table = 'kriteria';
    protected $fillable = ['kode','nama','bobot','tipe'];

    public function alternatif(){
        return $this->belongsToMany(Alternatif::class,'alternatif_kriteria')->withPivot('subkriteria_id');
    }

    public function subKriteria(){
        return $this->hasMany(SubKriteria::class);
    }
}
