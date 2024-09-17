<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planning;
use App\Models\Stock; 
class PlanningController extends Controller
{
    public function index()
    {
        $plannings = Planning::all();
        $inventories = Stock::all(); // Fetch all stock items
        return view('planning', compact('plannings', 'inventories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_stock' => 'required|exists:tbl_stock,id',
            'min' => 'required|numeric|min:1',
            'max' => 'required|numeric|min:1',
        ]);

        // Fetch stock details to autofill tbl_planning
        $stock = Stock::findOrFail($request->id_stock);

        // Check if a planning entry with the same stock already exists
        $existingPlanning = Planning::where('id_stock', $request->id_stock)->first();

        if ($existingPlanning) {
            return redirect()->back()->with('error', 'Entri Planning dengan ID inventaris ini sudah ada.');
        }

        // Create a new planning entry and autofill from stock
        $planning = Planning::create([
            'id_stock' => $request->id_stock,
            'inventory_id' => $stock->inventory_id, // Autofill from stock
            'Part_name' => $stock->Part_name,        // Autofill from stock
            'Part_number' => $stock->Part_number,    // Autofill from stock
            'min' => $request->min,
            'max' => $request->max,
        ]);

        // Update the stock's min and max values
        $stock->update([
            'min' => $request->min,
            'max' => $request->max,
        ]);

        // Check actual stock and update status
        $act_stock = $stock->act_stock;
        if ($act_stock < $stock->min) {
            $stock->update(['status' => 'danger']);
        } elseif ($act_stock >= $stock->min && $act_stock <= $stock->max) {
            $stock->update(['status' => 'okey']);
        } elseif ($act_stock > $stock->max) {
            $stock->update(['status' => 'over']);
        }

        return redirect()->back()->with('msg', 'Planning created successfully.');
    }
    
    
    public function update(Request $request, $id)
{
    // Validate the request
    $request->validate([
        'min' => 'required|numeric|min:1',
        'max' => 'required|numeric|min:1',
    ]);

    // Find the planning entry to be updated
    $planning = Planning::findOrFail($id);

    // Update the planning entry
    $planning->update([
        'min' => $request->min,
        'max' => $request->max,
    ]);

    // Also update the stock min and max
    $stock = Stock::find($planning->inventory_id);
    $stock->update([
        'min' => $request->min,
        'max' => $request->max,
    ]);

    // Get the actual stock value
    $act_stock = $stock->act_stock;

    // Update status based on the actual stock value
    if ($act_stock < $stock->min) {
        $stock->update(['status' => 'danger']);
    } elseif ($act_stock >= $stock->min && $act_stock <= $stock->max) {
        $stock->update(['status' => 'okey']);
    } elseif ($act_stock > $stock->max) {
        $stock->update(['status' => 'over']);
    }

    // Save the stock updates
    $stock->save();

    return redirect()->back()->with('msg', 'Planning updated successfully.');
}



public function destroy($id)
{
    $planning = Planning::findOrFail($id);

    // Find the corresponding stock entry
    $stock = Stock::find($planning->inventory_id);

    if ($stock) {
        // Reset min and max values in tbl_stock
        $stock->update([
            'min' => null, // Or set to default values if needed
            'max' => null ,
            'act_stock'=>null // Or set to default values if needed
        ]);

        // Update status berdasarkan nilai stok sebenarnya
        $act_stock = $stock->act_stock;

        if ($act_stock < $stock->min) {
            $stock->update(['status' => 'danger']);
        } elseif ($act_stock >= $stock->min && $act_stock <= $stock->max) {
            $stock->update(['status' => 'okey']);
        } elseif ($act_stock > $stock->max) {
            $stock->update(['status' => 'over']);
        }
    }

    // Delete the planning entry
    $planning->delete();

    return redirect()->route('planning.index')->with('msg', 'Planning and related stock values updated successfully.');
}

}
