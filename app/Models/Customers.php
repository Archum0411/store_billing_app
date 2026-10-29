<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'email',
        'status',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id','id');
    }
    
}
