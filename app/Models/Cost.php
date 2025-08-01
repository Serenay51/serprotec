<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    protected $fillable = ['provider_id', 'file', 'filename'];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}