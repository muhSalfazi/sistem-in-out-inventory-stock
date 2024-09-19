<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class StockController extends Controller
{
    public function index()
    { // Ambil semua data stok
        $stocks = Stock::all();
    
        // Jika request-nya datang dari AJAX, kirim data JSON
        if (request()->ajax()) {
            return response()->json($stocks);
        }
    
        // Jika bukan AJAX, tampilkan view
        return view('stock', ['stocks' => $stocks]);
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
         // Cek apakah pengguna adalah admin
    if (Auth::user()->role !== 'admin') {
        return redirect()->route('admin.stock.index')->with('error', 'Anda tidak memiliki izin untuk menghapus stok.');
    }
        // Find the stock by its ID
        $stock = Stock::find($id);
    
        // Check if stock exists
        if (!$stock) {
            return redirect()->route('stock.index')
                ->with('msg', 'Stock not found')
                ->with('error', 'false');
        }
    
        // Delete the associated production data
        if ($stock->produksi) {
            $stock->produksi()->delete();
        }
        if ($stock->deliveries) {
            $stock->deliveries()->delete();
        }
    
        // Find the related delivery by matching the first 6 digits of inventory_id_kbi with inventory_id
        $delivery = Delivery::where('id_stock', $stock->id)->first();
    
        // Delete the delivery if it exists
        if ($delivery) {
            $delivery->delete();
        }
    
        // Delete the stock itself
        $stock->delete();
    
        return redirect()->route('stock.index')->with('msg', 'Stock deleted successfully!');
    }
    
    



  

}
