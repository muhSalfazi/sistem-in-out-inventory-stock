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


    //  protected static function booted()
    //  {
    //      // Event ketika produksi dibuat
    //      static::created(function ($produksi) {
    //          // Buat data di tbl_stock saat produksi terisi
    //          Stock::create([
    //              'Id_kbi' => $produksi->Id_kbi,
    //              'id_produksi' => $produksi->id,
    //              'Part_name' => $produksi->Part_name,
    //              'Part_number' => $produksi->Part_number,
    //              'act_stock' => $produksi->Qty, // Awalnya act_stock = Qty dari produksi
    //              'status' => 'okey' // Atur status default, bisa diubah sesuai kebutuhan
    //          ]);
    //      });
 
    //       // Event ketika produksi diupdate
    //     static::updated(function ($produksi) {
    //         // Cek apakah ada stok terkait produksi ini
    //         $stock = Stock::where('id_produksi', $produksi->id)->first();

    //         if ($stock) {
    //             // Jika stok sudah ada, tambahkan perbedaan qty
    //             $qtyDifference = $produksi->Qty - $produksi->getOriginal('Qty');
    //             $stock->act_stock += $qtyDifference;
    //         } else {
    //             // Jika stok belum ada, buat stok baru
    //             $stock = Stock::create([
    //                 'Id_kbi' => $produksi->Id_kbi,
    //                 'Part_number' => $produksi->Part_number,
    //                 'act_stock' => $produksi->Qty, // Set Qty awal dari produksi
    //                 'id_produksi' => $produksi->id,
    //                 'status' => 'okey', // Set status default
    //             ]);
    //         }

    //         // Simpan perubahan
    //         $stock->save();
    //     });
    //  }
}
