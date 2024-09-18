<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasFactory;

protected $table = 'tbl_planning';

protected $fillable = ['id_stock', 'inventory_id', 'Part_name', 'Part_number', 'min', 'max'];


public function stock()
{
    return $this->belongsTo(Stock::class, 'id_stock');
}
    
}
