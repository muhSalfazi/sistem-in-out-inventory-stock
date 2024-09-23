<?php

namespace App\Imports;

use App\Models\Produksi;
use App\Models\Stock;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon; // Add Carbon for datetime handling

class ProductImport implements ToCollection, WithHeadingRow
{
    protected $alertMessages = [];
    protected $alertMessagesall = [];
    protected $hasValidRows = false;

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            try {
                // Convert row to array if it's an object
                $row = $row->toArray();

                // Check for the presence of 'id_kbi'
                if (!array_key_exists('id_kbi', $row) || empty($row['id_kbi'])) {
                    $this->alertMessages[] = "Id KBI tidak ada didalam Kolom pada baris " . ($index + 1) . ".";
                    continue; // Skip this row
                }

                $this->hasValidRows = true; // Mark that we have at least one valid row

                // Convert waktu from Excel date serial to a proper datetime format
                $waktu = $this->convertExcelDateToDateTime($row['waktu']);

                // Cek apakah produksi dengan id_kbi sudah ada
                $produksi = Produksi::where('Id_kbi', $row['id_kbi'])->first();

                if ($produksi) {
                    // Jika sudah ada, update qty dan stok
                    // $produksi->Qty += $row['qty'];
                    $produksi->save();

                    // Update tabel stock
                    $stock = Stock::where('id_produksi', $produksi->id)->first();
                    if ($stock) {
                        $stock->act_stock += $row['qty'];
                        $stock->status = null; // Correctly set status to null
                        $stock->save();

                        $stock = Produksi::create([
                            'Id_kbi' => $row['id_kbi'],
                            'Part_name' => $row['part_name'],
                            'Part_number' => $row['part_no'],
                            'Qty' => $row['qty'],
                            'wo_no' => $row['wo_no'],
                            'inventory_id' => $row['inventory_id'],
                            'line' => $row['line'],
                            'waktu' => $waktu,
                            'user' => $row['user'],
                        ]);
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
                        'waktu' => $waktu,
                        'user' => $row['user'],
                    ]);

                    $actStock = $row['qty'];

                    // Buat record baru di tabel Stock
                    Stock::create([
                        'Id_kbi' => $row['id_kbi'],
                        'id_produksi' => $produksi->id,
                        'Part_name' => $row['part_name'],
                        'Part_number' => $row['part_no'],
                        'act_stock' => $actStock,
                        'inventory_id' => $row['inventory_id'],
                        'status' => null, // Status set to null
                    ]);
                }
            } catch (\Exception $e) {
                // Handle exception, log it, or add to alert messages
                $this->alertMessages[] = "Error pada baris " . ($index + 1) . ": " . $e->getMessage();
            }
        }

        // If no valid rows were found, set a global alert message
        if (!$this->hasValidRows) {
            $this->alertMessagesall[] = "Semua baris tidak memiliki Id KBI.";
        }
    }

    /**
     * Convert Excel date serial to a Carbon datetime object.
     *
     * @param mixed $excelDate
     * @return \Carbon\Carbon
     */
    private function convertExcelDateToDateTime($excelDate)
    {
        if (is_numeric($excelDate)) {
            // Convert Excel date serial number to a Carbon date
            return Carbon::createFromFormat('Y-m-d H:i:s', gmdate('Y-m-d H:i:s', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($excelDate)));
        }
    
        // Fallback: Return the current time or any default date
        return Carbon::now(); // Or throw an exception, based on your needs
    }

    public function getAlertMessagesall()
    {
        return $this->alertMessagesall;
    }

    public function getAlertMessages()
    {
        return $this->alertMessages;
    }
}
