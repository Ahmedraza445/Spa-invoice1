<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helper\HasManyRelation;

class Invoice_new extends Model
{
    use HasFactory;
    use HasManyRelation;

    protected $fillable = [
        'customer', 'date', 'due_date', 'items' ,'discount', 'terms_and_conditions', 'reference'
    ];

    protected $guarded = [
        'number', 'sub_total', 'total'
    ];

    public function items() {
        return $this->hasMany(Invoice_new_Item::class);
    }

    public function setSubTotalAttribute($value) {
        $this->attributes['sub_total'] = $value;
        $discount = $this->attributes['discount'];
        $this->attributes['total'] = $value - $discount;
    }
}
