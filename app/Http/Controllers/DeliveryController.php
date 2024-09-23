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
            'file' => 'required',
        ]);
    
        // Initialize the import class
        $import = new DeliveryImport;
    
        // Perform the import
        Excel::import($import, $request->file('file'));
    
        // Get the alert message from the import process
        $alertMessage = $import->getAlertMessage();
    
        // Return back with alert message and success message
        if ($alertMessage) {
            return back()->with('alert', $alertMessage); // If there's an alert, send it back
        }
    
        return back()->with('msg', 'Data delivery berhasil diupload dan stok diperbarui.');
    }
    
    



}
