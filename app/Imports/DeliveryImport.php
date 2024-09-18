<?php

namespace App\Imports;

use App\Models\Stock;
use App\Models\Delivery;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DeliveryImport implements ToModel, WithHeadingRow
{
    private $lastImportTimestamp;
    public $alertMessage = null; 

    public function __construct()
    {
        $this->lastImportTimestamp = now();
    }

    public function model(array $row)
    {
        if (!isset($row['inventory_id_kbi']) || empty($row['inventory_id_kbi'])) {
            $this->alertMessage = "Inventory ID KBI tidak ada didalam Kolom.";
            return null; // Skip this row
        }

        $inventoryIdKbi = $this->convertScientificNotation($row['inventory_id_kbi']);
        $jobNoCustomer = $this->convertScientificNotation($row['job_no_customer']);

        if (!isset($row['manifest_no']) || empty($row['manifest_no'])) {
            $this->alertMessage = "Manifest No is missing for job_no_customer: " . $jobNoCustomer;
            return null; // Skip this row
        }

        $inventoryPrefix = substr($inventoryIdKbi, 0, 6);
        $stock = Stock::where('inventory_id', 'like', $inventoryPrefix . '%')->first();

        if (!$stock) {
            $this->alertMessage = "Tidak ditemukan stok untuk Id Inventaris KBI " . $inventoryIdKbi;
            return null;
        }

        // Clear the alert message if stock is found
        $this->alertMessage = null;

        $delivery = Delivery::create([
            'manifest_no' => $row['manifest_no'],
            'job_no_customer' => $jobNoCustomer,
            'scandate' => $row['scandate'],
            'user' => $row['user'],
            'inventory_id_kbi' => $inventoryIdKbi,
            'id_stock' => $stock->id,
        ]);

        $matchingDeliveries = Delivery::where('inventory_id_kbi', $inventoryIdKbi)
            ->where('job_no_customer', $jobNoCustomer)
            ->where('created_at', '>=', $this->lastImportTimestamp)
            ->count();

        $stock->act_stock -= $matchingDeliveries;
        $stock->save();

        return $delivery;
    }

    private function convertScientificNotation($value)
    {
        if (preg_match('/E\+/', $value)) {
            return sprintf('%.0f', floatval($value));
        }
        return $value;
    }

    public function getAlertMessage()
    {
        return $this->alertMessage;
    }
}

