<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sektor extends Model
{
    protected $table = 'sektor';
    protected $fillable = ['nama'];

    public function agencies()
    {
        return $this->hasMany(Agency::class, 'sektor_id');
    }
}
