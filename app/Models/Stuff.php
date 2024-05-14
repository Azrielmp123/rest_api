<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stuff extends Model
{
    //jika di migrations menggunakan $table->softdeletes
    use SoftDeletes;

    //fillable / guarded
    //menentukan kolom wajib diisi (colum yg bisa diisi dr luar)
    protected $fillable = ["name","category"];
    //protected $guarded = ['id']

    // property opsional



    //relasi
    //nama function : samain kaya model, kata pertama huruf kecil
    //model yang PK : hasOne / hasMany
    //panggil namaModelRelasi::class
    public function stuffStock()
    {
        return $this->hasOne(StuffStock::class);

    }

    // relasi hasMany : nama func jamak
    public function inboundStuffs()
    {
        return $this->hasMany(InboundStuff::class);
    }
    
    public function lendings()
    {
        return $this->hasMany(lending::class);
    }
}
