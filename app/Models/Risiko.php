<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Risiko extends Model
{
    protected $table = 'risiko';
    protected $fillable = ['sub_kategori_risiko_id', 'nama'];

    public function subKategoriRisiko()
    {
        return $this->belongsTo(SubKategoriRisiko::class, 'sub_kategori_risiko_id');
    }

    public function daftarRisikos()
    {
        return $this->hasMany(DaftarRisiko::class, 'risiko_id');
    }
}
