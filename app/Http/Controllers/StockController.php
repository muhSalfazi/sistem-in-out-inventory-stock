<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;


class StockController extends Controller
{

    // method view stock a stock
    public function index()
    {
        $stocks = Stock::all();
        return view('stock', ['stocks' => $stocks]);
    }

    // method store as a stock
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Inv_id' => 'required|integer',
            'Part_name' => 'required|max:255',
            'Part_number' => 'required|string|max:255',
            'min' => 'required|integer',
            'max' => 'required|integer',
            'act_stock' => 'required|integer',
        ]);

        Stock::create($validatedData);

        return redirect()->route('stock.index')->with('msg', 'stock created successfully!');
    }

    // method update as a stock
    public function update(Request $request, $id)
    {
        $request->validate([
            'Part_name' => 'sometimes|max:255',
            'InvID' => 'sometimes|integer',
            'Part_number' => 'sometimes|integer',
            'min' => 'sometimes|integer',
            'max' => 'sometimes|integer',
            'act_stock' => 'sometimes|integer',
        ]);

        $stock = Stock::findOrFail($id);

        $data = $request->only(['part_name', 'InvID', 'Part_number', 'min', 'max', 'act_stock']);

        foreach ($data as $key => $value) {
            if (is_null($value)) {
                unset($data[$key]);
            }
        }

        $stock->update($data);

        return redirect()->route('donasi.index')->with('msg', 'Donasi updated successfully.')->with('error', false);
    }

    // method deletes a stock
    public function destroy($id)
    {
        $stock = Stock::find($id);

        if (!$stock) {
            return redirect()->route('stock.index')
                ->with('msg', 'Stok tidak di temukan')
                ->with('error', 'false');
        }
        $stock->delete();
        return redirect()->route('stock.index')->with('msg', 'Stock deleted successfully!');
    }


    // method import excel 

  

}
