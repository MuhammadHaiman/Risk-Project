<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisAset extends Model
{
    protected $table = 'jenis_aset';
    protected $fillable = ['nama'];

    public function assets()
    {
        return $this->hasMany(Asset::class, 'id_jenis_aset');
    }
}
