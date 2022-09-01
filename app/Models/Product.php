<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'description', 'unit_price','item_code'
    ];

    protected $appends = ['text'];

    public function getTextAttribute()
    {
        return $this->attributes['item_code'].' - '.$this->attributes['description'];
    }
}