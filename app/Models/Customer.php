<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'customer_id', 'firstname', 'lastname', 'email', 'address'
    ];

    protected $appends = ['text'];

    public function getTextAttribute()
    {
        return $this->attributes['firstname']. ' - '.$this->attributes['lastname'];
    }
}