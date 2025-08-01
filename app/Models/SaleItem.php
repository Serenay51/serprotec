<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $fillable = ['sale_id', 'product_id', 'quantity', 'price', 'subtotal'];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function quotationItem()
    {
        return $this->belongsTo(QuotationItem::class);
    }
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
    public function costs()
    {
        return $this->hasMany(Cost::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
