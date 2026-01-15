<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'meja',
        'stand_id',
        'status',
        'total_harga'
    ];

    // relasi ke detail pesanan
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
