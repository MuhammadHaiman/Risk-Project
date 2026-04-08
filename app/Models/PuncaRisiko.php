<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuncaRisiko extends Model
{
    protected $table = 'punca_risiko';
    protected $fillable = ['kategori_risiko_id', 'nama'];

    public function kategoriRisiko()
    {
        return $this->belongsTo(KategoriRisiko::class, 'kategori_risiko_id');
    }
}
