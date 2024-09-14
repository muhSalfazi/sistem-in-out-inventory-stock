<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\delivery ;
use App\Imports\DeliveryImport;
use Maatwebsite\Excel\Facades\Excel;
class DeliveryController extends Controller
{
    //
    public function index(){

        $deliveries = delivery::all();
        return view('delivery', ['deliveries' => $deliveries]);
    }

    
    // method insert
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'manifest_no' => 'required|max:255',
            'job_no_customer' => 'required|max:255',
            'Qty' => 'required|integer',
        ]);

        delivery::create($validatedData);
        return redirect()->route('product.index')->with('msg', 'Delivery created successfully!');
    }

    public function uploadDelivery(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    Excel::import(new DeliveryImport, $request->file('file'));

    return back()->with('success', 'Data delivery berhasil diupload dan stok diperbarui.');
}


}
