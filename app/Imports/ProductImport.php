<?php

namespace App\Imports;

use App\Models\Produksi;
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
        return new Produksi([
            'Id_kbi'      => $row['id_kbi'],      
            'Part_name'  => $row['part_name'],
            'Part_number'=> $row['part_no'],
            'inventory_id'=> $row['inventory_id'],
            'Qty'=>$row['qty']
        ]);
    }
}
