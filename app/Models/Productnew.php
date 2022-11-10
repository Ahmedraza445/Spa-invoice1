<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helper\HasManyRelation;

class Productnew extends Model

{
    use HasManyRelation;
    
    protected $fillable = [
        'product_desc','vendor','price','quantity'
    ];

    public function invoice_item(){
        return $this->hasMany(Invoice_new_Item::class);
    }

    protected $appends = ['text','stock'];

    public function getTextAttribute()
    {
        return $this->attributes['id'].' - '.$this->attributes['product_desc'];
    }

    public function getStockAttribute()
    {
        return $this->hasMany(Invoice_new_Item::class)->sum('qty');
    }
}