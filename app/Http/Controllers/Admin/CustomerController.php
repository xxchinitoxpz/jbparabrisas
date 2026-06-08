<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Customer::query();

        if ($search) {
            $query->where('company_name', 'like', '%' . $search . '%')
                  ->orWhere('ruc_dni', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
        }

        $customers = $query->orderBy('company_name')->paginate(10)->withQueryString();

        return view('admin.customers.index', compact('customers', 'search'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:150',
            'ruc_dni' => 'required|string|max:20|unique:customers,ruc_dni',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ], [
            'company_name.required' => 'La razón social es obligatoria.',
            'ruc_dni.required' => 'El RUC/DNI es obligatorio.',
            'ruc_dni.unique' => 'Ya existe un cliente registrado con este RUC/DNI.',
        ]);

        Customer::create([
            'company_name' => $request->company_name,
            'ruc_dni' => $request->ruc_dni,
            'phone' => $request->phone,
            'description' => $request->description,
        ]);

        if ($request->wantsTurboStream()) {
            session()->flash('success', 'Cliente registrado correctamente.');
            return response()->turboStream()
                ->action('redirect')
                ->attributes(['url' => route('admin.customer.index')]);
        }

        return redirect()->route('admin.customer.index')
            ->with('success', 'Cliente registrado correctamente.');
    }

    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, string $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'company_name' => 'required|string|max:150',
            'ruc_dni' => [
                'required',
                'string',
                'max:20',
                Rule::unique('customers', 'ruc_dni')->ignore($customer->id),
            ],
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ], [
            'company_name.required' => 'La razón social es obligatoria.',
            'ruc_dni.required' => 'El RUC/DNI es obligatorio.',
            'ruc_dni.unique' => 'Ya existe un cliente registrado con este RUC/DNI.',
        ]);

        $customer->update([
            'company_name' => $request->company_name,
            'ruc_dni' => $request->ruc_dni,
            'phone' => $request->phone,
            'description' => $request->description,
        ]);

        if ($request->wantsTurboStream()) {
            session()->flash('success', 'Cliente actualizado correctamente.');
            return response()->turboStream()
                ->action('redirect')
                ->attributes(['url' => route('admin.customer.index')]);
        }

        return redirect()->route('admin.customer.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customer.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}
