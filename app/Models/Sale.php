<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'client_id',
        'product_id',
        'quotation_id',
        'number',
        'date',
        'subtotal',
        'total',
        'status',
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
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class);
    }
    public function costs()
    {
        return $this->hasMany(Cost::class);
    }
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

}