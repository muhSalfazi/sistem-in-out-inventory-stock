<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'tbl_stock';

    protected $fillable = [
        'id',
        'Id_kbi',
        'Part_name',
        'Part_number',
        'min',
        'max',
        'act_stock',
        'inventory_id',
        'status',
        'id_produksi',
        'id_delivery',
        'id_planning',
    ];

    // Relasi ke Produksi (Many to One)
    public function produksi()
    {
        return $this->belongsTo(Produksi::class, 'id_produksi');
    }

    public function planning()
    {
        return $this->hasOne(Planning::class, 'id_stock');
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'id_stock');
    }
}
