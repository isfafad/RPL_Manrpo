<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian_assessor extends Model
{
    use HasFactory;

    protected $table = 'penilaian_assessor';
    protected $fillable = [
        'nilai',
        'cpmk_id',
        'assessor_id'
    ];
}
