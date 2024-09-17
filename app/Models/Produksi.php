<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stock;
class Produksi extends Model
{
    use HasFactory;

    protected $table  = 'tbl_produksi';

    protected $fillable = [
        'Id_kbi',
        'Part_name',
        'Part_number',
        'wo_no',
        'inventory_id',
        'line',
        'Qty',
        'waktu',
        'user'

    ];

     // Relasi ke model Kategori
     public function stocks()
     {
         return $this->hasMany(Stock::class, 'id_produksi');
     }


    
}
