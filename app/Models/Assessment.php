<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $table = 'assessment';
    protected $fillable = [
        'calon_mahasiswa_id',
        'jurusan_id',
        'assessor_id_1',
        'assessor_id_2',
        'assessor_id_3'
    ];
    public function calon_mahasiswa()
    {
        return $this->belongsTo(Calon_mahasiswa::class, 'calon_mahasiswa_id');
    }
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
    Public function assessor1()
    {
        return $this->belongsTo(Assessor::class, 'assessor_id_1');
    }
    public function assessor2()
    {
        return $this->belongsTo(Assessor::class, 'assessor_id_2');
    }
    public function assessor3()
    {
        return $this->belongsTo(Assessor::class, 'assessor_id_3');
    }
}