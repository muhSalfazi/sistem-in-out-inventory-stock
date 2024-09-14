<?php

namespace App\Imports;

use App\Models\Produksi;
use App\Models\Stock;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Cek apakah produksi dengan id_kbi sudah ada
        $produksi = Produksi::where('Id_kbi', $row['id_kbi'])->first();

        if ($produksi) {
            // Jika sudah ada, update qty dan stok
            $produksi->Qty += $row['qty'];
            $produksi->save();

            // Update tabel stock
            $stock = Stock::where('id_produksi', $produksi->id)->first();
            if ($stock) {
                $stock->act_stock += $row['qty'];
                $stock->save();
            }
        } else {
            // Jika belum ada, buat record baru di Produksi dan Stock
            $produksi = Produksi::create([
                'Id_kbi' => $row['id_kbi'],
                'Part_name' => $row['part_name'],
                'Part_number' => $row['part_no'],
                'Qty' => $row['qty'],
                'wo_no' => $row['wo_no'],
                'inventory_id' => $row['inventory_id'],
                'line' => $row['line'],
                'waktu' => now(),
                'user' =>$row['user'],
            ]);

            Stock::create([
                'Id_kbi' => $row['id_kbi'],
                'id_produksi' => $produksi->id,
                'Part_name' => $row['part_name'],
                'Part_number' => $row['part_no'],
                'act_stock' => $row['qty'],
                'inventory_id' => $row['inventory_id'],
                'status' => 'okey',
            ]);
        }
    }
}
