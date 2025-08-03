<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'stock', 'category', 'image'];

    // Define any relationships or additional methods here
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function costs()
    {
        return $this->hasMany(Cost::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }   

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
