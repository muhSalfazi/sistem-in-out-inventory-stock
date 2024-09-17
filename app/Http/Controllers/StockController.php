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
        // Validasi input dari user untuk 'min' dan 'max' saja
        $request->validate([
            'min' => 'sometimes|integer|max:100|min:1',
            'max' => 'sometimes|integer|max:100|min:1',
        ]);
    
        // Temukan data stock berdasarkan ID
        $stock = Stock::findOrFail($id);
    
        // Ambil data yang hanya diisi dari request
        $data = $request->only(['min', 'max']);
    
        // Hapus data yang nilainya null dari array
        foreach ($data as $key => $value) {
            if (is_null($value)) {
                unset($data[$key]);
            }
        }
    
        // Perbarui data stock
        $stock->update($data);
    
        // Setelah update, ambil nilai terbaru act_stock
        $act_stock = $stock->act_stock;
        $min = $stock->min;
        $max = $stock->max;
    
        // Update status berdasarkan nilai akhir dari act_stock
        if ($act_stock < $min) {
            $stock->update(['status' => 'danger']);
        } elseif ($act_stock >= $min && $act_stock <= $max) {
            $stock->update(['status' => 'okey']);
        } elseif ($act_stock > $max) {
            $stock->update(['status' => 'over']);
        }
    
        // Redirect kembali ke halaman index stock dengan pesan sukses
        return redirect()->route('stock.index')->with('msg', 'Stock updated successfully.')->with('error', false);
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
