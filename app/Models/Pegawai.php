<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function mutasi(): HasMany
    {
        return $this->hasMany(MutasiPesertaBaru::class, 'no_peg');
    }
}
