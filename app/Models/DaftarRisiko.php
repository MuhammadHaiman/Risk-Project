<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarRisiko extends Model
{
    protected $table = 'daftar_risiko';
    protected $fillable = [
        'agensi_id',
        'aset_id',
        'kategori_id',
        'sub_kategori_risiko_id',
        'risiko_id',
        'punca_risiko_id',
        'kategori_punca_risiko_id',
        'impak',
        'kebarangkalian',
        'skor_risiko',
        'tahap_risiko',
        'kawalan_sediada',
        'plan_mitigasi',
        'pemilik_risiko'
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class, 'agensi_id');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'aset_id');
    }

    public function kategoriRisiko()
    {
        return $this->belongsTo(KategoriRisiko::class, 'kategori_id');
    }

    public function subKategoriRisiko()
    {
        return $this->belongsTo(SubKategoriRisiko::class, 'sub_kategori_risiko_id');
    }

    public function risiko()
    {
        return $this->belongsTo(Risiko::class, 'risiko_id');
    }

    public function kategoriPuncaRisiko()
    {
        return $this->belongsTo(KategoriPuncaRisiko::class, 'kategori_punca_risiko_id');
    }

    public function puncaRisiko()
    {
        return $this->belongsTo(PuncaRisiko::class, 'punca_risiko_id');
    }
}
