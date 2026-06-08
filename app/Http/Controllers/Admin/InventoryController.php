<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Inventory::with(['product', 'supplier']);

        if ($search) {
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%');
            })->orWhereHas('supplier', function ($q) use ($search) {
                $q->where('company_name', 'like', '%' . $search . '%');
            });
        }

        $inventories = $query->orderBy('stored_date', 'desc')->paginate(10)->withQueryString();

        return view('admin.inventories.index', compact('inventories', 'search'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        $suppliers = Supplier::orderBy('company_name')->get();

        return view('admin.inventories.create', compact('products', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
            'stored_date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
        ], [
            'product_id.required' => 'El producto es obligatorio.',
            'product_id.exists' => 'El producto seleccionado no es válido.',
            'quantity.required' => 'La cantidad es obligatoria.',
            'quantity.integer' => 'La cantidad debe ser un número entero.',
            'quantity.min' => 'La cantidad no puede ser negativa.',
            'stored_date.required' => 'La fecha de almacenamiento es obligatoria.',
            'stored_date.date' => 'La fecha ingresada no es válida.',
            'supplier_id.required' => 'El proveedor es obligatorio.',
            'supplier_id.exists' => 'El proveedor seleccionado no es válido.',
        ]);

        Inventory::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'stored_date' => $request->stored_date,
            'supplier_id' => $request->supplier_id,
        ]);

        if ($request->wantsTurboStream()) {
            session()->flash('success', 'Registro de inventario guardado correctamente.');
            return response()->turboStream()
                ->action('redirect')
                ->attributes(['url' => route('admin.inventory.index')]);
        }

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Registro de inventario guardado correctamente.');
    }

    public function edit(string $id)
    {
        $inventory = Inventory::findOrFail($id);
        $products = Product::orderBy('name')->get();
        $suppliers = Supplier::orderBy('company_name')->get();

        return view('admin.inventories.edit', compact('inventory', 'products', 'suppliers'));
    }

    public function update(Request $request, string $id)
    {
        $inventory = Inventory::findOrFail($id);

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
            'stored_date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
        ], [
            'product_id.required' => 'El producto es obligatorio.',
            'product_id.exists' => 'El producto seleccionado no es válido.',
            'quantity.required' => 'La cantidad es obligatoria.',
            'quantity.integer' => 'La cantidad debe ser un número entero.',
            'quantity.min' => 'La cantidad no puede ser negativa.',
            'stored_date.required' => 'La fecha de almacenamiento es obligatoria.',
            'stored_date.date' => 'La fecha ingresada no es válida.',
            'supplier_id.required' => 'El proveedor es obligatorio.',
            'supplier_id.exists' => 'El proveedor seleccionado no es válido.',
        ]);

        $inventory->update([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'stored_date' => $request->stored_date,
            'supplier_id' => $request->supplier_id,
        ]);

        if ($request->wantsTurboStream()) {
            session()->flash('success', 'Registro de inventario actualizado correctamente.');
            return response()->turboStream()
                ->action('redirect')
                ->attributes(['url' => route('admin.inventory.index')]);
        }

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Registro de inventario actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Registro de inventario eliminado correctamente.');
    }
}
