<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bukti extends Model
{
    use HasFactory;

    protected $table = 'bukti';
    protected $fillable = [
        'nama',
        'jenis_bukti',
        'file'
    ];

    public function self_assessment_camaba()
    {
        return $this->hasOne(Self_assessment_camaba::class);
    }
}
