<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\delivery ;

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

}
