<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuids
{
    protected static function bootHasUuids()
    {
        static::creating(function ($model) {
            $model->nomor_pengajuan_hidden = (string) Str::uuid();
        });
    }
}
