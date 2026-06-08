<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Supplier::query();

        if ($search) {
            $query->where('company_name', 'like', '%' . $search . '%')
                  ->orWhere('ruc_dni', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
        }

        $suppliers = $query->orderBy('company_name')->paginate(10)->withQueryString();

        return view('admin.suppliers.index', compact('suppliers', 'search'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:150',
            'ruc_dni' => 'required|string|max:20|unique:suppliers,ruc_dni',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ], [
            'company_name.required' => 'La razón social es obligatoria.',
            'ruc_dni.required' => 'El RUC/DNI es obligatorio.',
            'ruc_dni.unique' => 'Ya existe un proveedor registrado con este RUC/DNI.',
        ]);

        Supplier::create([
            'company_name' => $request->company_name,
            'ruc_dni' => $request->ruc_dni,
            'phone' => $request->phone,
            'description' => $request->description,
        ]);

        if ($request->wantsTurboStream()) {
            session()->flash('success', 'Proveedor registrado correctamente.');
            return response()->turboStream()
                ->action('redirect')
                ->attributes(['url' => route('admin.supplier.index')]);
        }

        return redirect()->route('admin.supplier.index')
            ->with('success', 'Proveedor registrado correctamente.');
    }

    public function edit(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, string $id)
    {
        $supplier = Supplier::findOrFail($id);

        $request->validate([
            'company_name' => 'required|string|max:150',
            'ruc_dni' => [
                'required',
                'string',
                'max:20',
                Rule::unique('suppliers', 'ruc_dni')->ignore($supplier->id),
            ],
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ], [
            'company_name.required' => 'La razón social es obligatoria.',
            'ruc_dni.required' => 'El RUC/DNI es obligatorio.',
            'ruc_dni.unique' => 'Ya existe un proveedor registrado con este RUC/DNI.',
        ]);

        $supplier->update([
            'company_name' => $request->company_name,
            'ruc_dni' => $request->ruc_dni,
            'phone' => $request->phone,
            'description' => $request->description,
        ]);

        if ($request->wantsTurboStream()) {
            session()->flash('success', 'Proveedor actualizado correctamente.');
            return response()->turboStream()
                ->action('redirect')
                ->attributes(['url' => route('admin.supplier.index')]);
        }

        return redirect()->route('admin.supplier.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);

        if ($supplier->purchases()->exists() || $supplier->inventories()->exists()) {
            return redirect()->route('admin.supplier.index')
                ->with('error', 'No se puede eliminar el proveedor porque tiene compras o inventario asociados.');
        }

        $supplier->delete();

        return redirect()->route('admin.supplier.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }
}
