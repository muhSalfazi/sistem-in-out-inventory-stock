<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class delivery extends Model
{
    use HasFactory;

    protected  $table ="tbl_delivery";

    protected $fillable = [
        'manifest_no',
        'job_no_customer',
        'scandate',
        'user',
        'inventory_id_kbi',
        'id_stock'
    ];
    public function stock()
    {
        return $this->belongsTo(Stock::class, 'id_stock');
    }

}
