<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'address', 'cuit'];

    // Define any relationships or additional methods here
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }
    public function costs()
    {
        return $this->hasMany(Cost::class);
    }
}
