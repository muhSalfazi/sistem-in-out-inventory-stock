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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Inv_id' => 'required|max:255',
            'Part_name' => 'required|max:255',
            'Part_number' => 'required|string|max:255',
            'Qty' => 'required|integer',
        ]);

        Produksi::create($validatedData);
        return redirect()->route('product.index')->with('msg', 'Produksi created successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Inv_id' => 'nullable|max:255',
            'Part_name' => 'nullable|max:255',
            'Part_number' => 'nullable|string|max:255',
            'Qty' => 'sometimes|integer',
        ]);

        $produksi = Produksi::findOrFail($id);
        $data = $request->only(['Inv_id', 'Part_name', 'Part_number', 'Qty']);

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
        $produksi = Produksi::find($id);

        if (!$produksi) {
            return redirect()->route('product.index')
                ->with('msg', 'Produksi tidak ditemukan')
                ->with('error', 'false');
        }

        $produksi->delete();
        return redirect()->route('product.index')->with('msg', 'Produksi deleted successfully!');
    }

    public function importExcelProduct(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new ProductImport, $request->file('file'));
        return redirect()->route('product.index')->with('msg', 'Product imported successfully!');
    }
}
