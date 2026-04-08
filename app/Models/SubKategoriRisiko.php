<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKategoriRisiko extends Model
{
    protected $table = 'sub_kategori_risiko';
    protected $fillable = ['kategori_risiko_id', 'nama'];

    public function kategoriRisiko()
    {
        return $this->belongsTo(KategoriRisiko::class, 'kategori_risiko_id');
    }

    public function risikos()
    {
        return $this->hasMany(Risiko::class, 'sub_kategori_risiko_id');
    }

    public function daftarRisikos()
    {
        return $this->hasMany(DaftarRisiko::class, 'sub_kategori_risiko_id');
    }
}
