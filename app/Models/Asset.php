<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'agensi_id',
        'id_jenis_aset',
        'nama_aset'
    ];

    public function agency()
    {
        return $this->belongsTo(Agency::class, 'agensi_id');
    }

    public function jenisAset()
    {
        return $this->belongsTo(JenisAset::class, 'id_jenis_aset');
    }

    public function daftarRisikos()
    {
        return $this->hasMany(DaftarRisiko::class, 'aset_id');
    }
}
