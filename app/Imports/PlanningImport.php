<?php

namespace App\Imports;

use App\Models\Planning;
use App\Models\Stock;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class PlanningImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $stock = Stock::find($row['inventory_id']);
    
        if (!$stock) {
            // Log the error and skip this row
            Log::error('Invalid inventory_id: ' . $row['inventory_id']);
            return null; // Skip the row if inventory_id is invalid
        }
    
        // Create the Planning model if inventory_id exists
        $delivery = Planning::create([
            'inventory_id' => $row['inventory_id'],
            'Part_name'    => $row['part_name'],
            'Part_number'  => $row['part_number'],
            'min'          => $row['min'],
            'max'          => $row['max'],
        ]);
    
        return $delivery;  // Return the created model
    }
}
