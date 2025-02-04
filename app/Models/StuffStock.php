<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StuffStock extends Model
{
    use SoftDeletes;

    protected $fillable = ['stuff_id', 'total_available', 'total_defec'];
    
    // model FK : belongsTo
    // panggil namaModelPK::class
    public function stuff()
    {
        return $this->belongsTo(stuff::class);
    }
}
