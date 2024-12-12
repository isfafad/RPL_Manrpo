<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Self_assessment_camaba extends Model
{
    use HasFactory;

    protected $table = 'self_assessment_camaba';
    protected $fillable = [
        'nilai',
        'calon_mahasiswa_id',
        'cpmk_id',
        'bukti_id',
        'file'
    ];
    public function calon_mahasiswa()
    {
        return $this->belongsTo(Calon_mahasiswa::class);
    }
    public function cpmk()
    {
        return $this->belongsTo(Cpmk::class);
    }
    public function bukti()
    {
        return $this->belongsTo(Bukti::class);
    }
    
}
