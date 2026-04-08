<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriRisiko extends Model
{
    protected $table = 'kategori_risiko';
    protected $fillable = ['nama'];

    public function subKategoriRisiko()
    {
        return $this->hasMany(SubKategoriRisiko::class, 'kategori_risiko_id');
    }

    public function puncaRisikos()
    {
        return $this->hasMany(PuncaRisiko::class, 'kategori_risiko_id');
    }

    public function daftarRisikos()
    {
        return $this->hasMany(DaftarRisiko::class, 'kategori_id');
    }
}
