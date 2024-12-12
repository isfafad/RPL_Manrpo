<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calon_mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'calon_mahasiswa';
    protected $fillable = [
        'user_id',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp',
        'no_wa',
        'kelamin',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',
        'foto_profile',
        'jurusan_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
    public function ijazah()
    {
        return $this->hasOne(Ijazah::class);
    }
    public function self_assessment_camaba()
    {
        return $this->hasOne(Self_assessment_camaba::class);
    }
    public function assessment()
    {
        return $this->hasOne(Assessment::class);
    }
}
