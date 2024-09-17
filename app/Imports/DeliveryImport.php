<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\Stock;
use App\Models\Delivery;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DeliveryImport implements ToModel, WithHeadingRow
{
    private $lastImportTimestamp;

    public function __construct()
    {
        // Set timestamp to check against during import
        $this->lastImportTimestamp = now(); // Or set to a specific time if required
    }

    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        // Convert scientific notation to real number
        $inventoryIdKbi = $this->convertScientificNotation($row['inventory_id_kbi']);
        $jobNoCustomer = $this->convertScientificNotation($row['job_no_customer']);

        // Simpan data ke tabel tbl_delivery
        $delivery = Delivery::create([
            'manifest_no' => $row['manifest_no'],
            'job_no_customer' => $jobNoCustomer,
            'scandate' => $row['scandate'],
            'user' => $row['user'],
            'inventory_id_kbi' => $inventoryIdKbi,
        ]);

        // Ambil enam digit pertama dari inventory_id untuk pencocokan
        $inventoryPrefix = substr($inventoryIdKbi, 0, 6);

        // Cari stok berdasarkan enam digit pertama dari inventory_id_kbi
        $stock = Stock::where('inventory_id', 'like', $inventoryPrefix . '%')->first();

        // Jika stok ditemukan, kurangi act_stock berdasarkan jumlah job_no_customer yang memiliki inventory_id_kbi yang sama
        if ($stock) {
            // Hitung jumlah job_no_customer yang memiliki inventory_id_kbi yang sama dan dibuat setelah timestamp import
            $matchingDeliveries = Delivery::where('inventory_id_kbi', $inventoryIdKbi)
                ->where('job_no_customer', $jobNoCustomer)
                ->where('created_at', '>=', $this->lastImportTimestamp)
                ->count();

            // Kurangi act_stock dengan jumlah job_no_customer yang sesuai
            $stock->act_stock -= $matchingDeliveries;

            // Tentukan status berdasarkan nilai act_stock
            if ($stock->act_stock > 100) {
                $stock->status = 'over';
            } elseif ($stock->act_stock >= 10) {
                $stock->status = 'okey';
            } else {
                $stock->status = 'danger';
            }

            $stock->save();
        }
    }

    /**
     * Convert scientific notation to real number.
     *
     * @param string $value
     * @return string
     */
    private function convertScientificNotation($value)
    {
        // Check if value is in scientific notation
        if (preg_match('/E\+/', $value)) {
            // Convert scientific notation to float and then to string
            return sprintf('%.0f', floatval($value));
        }

        return $value;
    }
}
