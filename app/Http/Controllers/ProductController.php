<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produksi;
use App\Models\Stock;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;

class ProductController extends Controller
{
    public function index()
    {
        $product = Produksi::all();
        return view('product', ['products' => $product]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'Inv_id' => 'nullable|max:255',
            'Part_name' => 'nullable|max:255',
            'Part_number' => 'nullable|string|max:255',
            'Qty' => 'sometimes|integer',
            'Wo_no' => 'sometimes|max:255',
            'inventory_id' => 'sometimes|integer|max:255'
        ]);

        $produksi = Produksi::findOrFail($id);
        $data = $request->only(['Inv_id', 'Part_name', 'Part_number', 'Qty', 'Wo_no', 'inventory_id']);

        foreach ($data as $key => $value) {
            if (is_null($value)) {
                unset($data[$key]);
            }
        }

        $produksi->update($data);

        if (isset($data['Qty'])) {
            $newQty = $data['Qty'];
            $stock = Stock::where('id_produksi', $produksi->id)->first();

            if ($stock) {
                $stock->act_stock += $newQty;
                $stock->save();
            } else {
                Stock::create([
                    'Inv_id' => $produksi->Inv_id,
                    'Part_name' => $produksi->Part_name,
                    'Part_number' => $produksi->Part_number,
                    'act_stock' => $newQty,
                    'id_produksi' => $produksi->id,
                ]);
            }
        }

        return redirect()->route('product.index')->with('msg', 'Produksi updated successfully.');
    }

    public function destroy($id)
    {
        // Temukan record Produksi berdasarkan ID
        $produksi = Produksi::find($id);

        // Pastikan Produksi ditemukan
        if (!$produksi) {
            return redirect()->route('product.index')
                ->with('msg', 'Produksi tidak ditemukan')
                ->with('error', 'true'); // Set 'true' agar error flag bisa digunakan
        }

        // Hapus semua Stock terkait berdasarkan id_produksi
        $produksi->stocks()->delete(); // Menggunakan relasi hasMany untuk menghapus semua stock terkait

        // Hapus Produksi
        $produksi->delete();

        return redirect()->route('product.index')->with('msg', 'Produksi dan stok terkait berhasil dihapus!');
    }


    public function importExcelProduct(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $import = new ProductImport;
        Excel::import($import, $request->file('file'));

        $alertMessages = $import->getAlertMessages();
        $alertMessagesall = $import->getAlertMessagesall();

        if (!empty($alertMessagesall)) {
            return redirect()->back()->with('pesan', $alertMessagesall); // Return to previous page with global alerts
        }

        if (!empty($alertMessages)) {
            return redirect()->back()->with('alerts', $alertMessages); // Return to previous page with row-specific alerts
        }

        return redirect()->route('product.index')->with('msg', 'Product imported successfully!');
    }
}
