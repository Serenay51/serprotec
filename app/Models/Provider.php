<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'address', 'cuit'];

    public function costs()
    {
        return $this->hasMany(Cost::class);
    }
}
