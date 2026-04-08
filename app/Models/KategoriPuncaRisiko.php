<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPuncaRisiko extends Model
{
    protected $table = 'kategori_punca_risiko';
    protected $fillable = ['nama'];

    public function puncaRisikos()
    {
        return $this->hasMany(PuncaRisiko::class, 'kategori_punca_risiko_id');
    }

    public function daftarRisikos()
    {
        return $this->hasMany(DaftarRisiko::class, 'kategori_punca_risiko_id');
    }
}
