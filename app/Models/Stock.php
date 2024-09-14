<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table ='tbl_stock';

    protected $fillable = [
        'Id_kbi',
        'Part_name',
        'Part_number',
        'min',
        'max',
        'act_stock',
        'id_produksi',
        'inventory_id'
    ];

    // Relasi ke Produksi (Many to One)
    public function produksi()
    {
        return $this->belongsTo(Produksi::class, 'id_produksi');
    }

    // // Relasi ke Delivery (Many to One)
    // public function delivery()
    // {
    //     return $this->belongsTo(Delivery::class, 'id_delivery');
    // }
}
