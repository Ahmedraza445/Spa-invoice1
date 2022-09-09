<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helper\HasManyRelation;

class Product extends Model

{
    use HasManyRelation;
    
    protected $fillable = [
        'vendor_id', 'description', 'unit_price','item_code'
    ];

    protected $appends = ['text'];

    public function getTextAttribute()
    {
        return $this->attributes['item_code'].' - '.$this->attributes['description'];
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}