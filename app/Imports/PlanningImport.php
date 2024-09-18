<?php
namespace App\Imports;

use App\Models\Planning;
use App\Models\Stock;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PlanningImport implements ToModel, WithHeadingRow, WithChunkReading
{
    protected $alertMessages = [];

    public function chunkSize(): int
    {
        return 1000;
    }

    public function model(array $row)
    {
        $hasErrors = false;

        if (!isset($row['inventory_id']) || empty($row['inventory_id'])) {
            $this->alertMessages[] = "Inventory ID Todak ada di dalam Kolom.";
            $hasErrors = true;
        } else {
            // Find the related stock using the inventory_id
            $stock = Stock::where('inventory_id', $row['inventory_id'])->first();

            if (!$stock) {
                $this->alertMessages[] = "Inventory ID {$row['inventory_id']} tidak ada di stock.";
                $hasErrors = true;
            } else {
                Planning::create([
                    'id_stock' => $stock->id,
                    'inventory_id' => $row['inventory_id'],
                    'Part_name' => $row['part_name'],
                    'Part_number' => $row['part_number'],
                    'min' => $row['min'],
                    'max' => $row['max'],
                ]);

                // Update the stock's min and max values
                $stock->update([
                    'min' => $row['min'],
                    'max' => $row['max'],
                ]);

                // Check actual stock and update status
                $act_stock = $stock->act_stock;
                if ($act_stock < $stock->min) {
                    $stock->update(['status' => 'danger']);
                } elseif ($act_stock >= $stock->min && $act_stock <= $stock->max) {
                    $stock->update(['status' => 'okey']);
                } elseif ($act_stock > $stock->max) {
                    $stock->update(['status' => 'over']);
                }
            }
        }
        
        // Skip row if errors are present
        if ($hasErrors) {
            return null;
        }
    }

    public function getAlertMessages()
    {
        // Filter unique messages
        return array_unique($this->alertMessages);
    }
}

