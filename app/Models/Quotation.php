<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = [
        'client_id',
        'number',
        'date',
        'total',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }


}
