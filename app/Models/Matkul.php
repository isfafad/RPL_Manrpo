<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'nama_matkul',
        'jurusan_id'
    ];
    protected $table = 'matkul';

    public $timestamps = false;

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class,'jurusan_id','id');
    }
    public function cpmk()
    {
        return $this->hasOne(Cpmk::class);
    }
    
}
