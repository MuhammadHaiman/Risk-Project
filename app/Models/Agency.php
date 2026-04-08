<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $fillable = [
        'nama_agensi',
        'no_tel_agensi',
        'website',
        'nama_pic',
        'notel_pic',
        'emel_pic',
        'sektor_id',
        'jenis_agensi'
    ];

    public function sektor()
    {
        return $this->belongsTo(Sektor::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class, 'agensi_id');
    }

    public function daftarRisikos()
    {
        return $this->hasMany(DaftarRisiko::class, 'agensi_id');
    }
}
