<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Product::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
        }

        $products = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('admin.products.index', compact('products', 'search'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:products,code',
            'name' => 'required|string|max:150',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ], [
            'code.required' => 'El código es obligatorio.',
            'code.unique' => 'Ya existe un producto con este código.',
            'name.required' => 'El nombre es obligatorio.',
            'purchase_price.required' => 'El precio de compra es obligatorio.',
            'purchase_price.numeric' => 'El precio de compra debe ser un número.',
            'sale_price.required' => 'El precio de venta es obligatorio.',
            'sale_price.numeric' => 'El precio de venta debe ser un número.',
        ]);

        Product::create([
            'code' => $request->code,
            'name' => $request->name,
            'purchase_price' => $request->purchase_price,
            'sale_price' => $request->sale_price,
            'description' => $request->description,
        ]);

        if ($request->wantsTurboStream()) {
            session()->flash('success', 'Producto registrado correctamente.');
            return response()->turboStream()
                ->action('redirect')
                ->attributes(['url' => route('admin.product.index')]);
        }

        return redirect()->route('admin.product.index')
            ->with('success', 'Producto registrado correctamente.');
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('products', 'code')->ignore($product->id),
            ],
            'name' => 'required|string|max:150',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ], [
            'code.required' => 'El código es obligatorio.',
            'code.unique' => 'Ya existe un producto con este código.',
            'name.required' => 'El nombre es obligatorio.',
            'purchase_price.required' => 'El precio de compra es obligatorio.',
            'purchase_price.numeric' => 'El precio de compra debe ser un número.',
            'sale_price.required' => 'El precio de venta es obligatorio.',
            'sale_price.numeric' => 'El precio de venta debe ser un número.',
        ]);

        $product->update([
            'code' => $request->code,
            'name' => $request->name,
            'purchase_price' => $request->purchase_price,
            'sale_price' => $request->sale_price,
            'description' => $request->description,
        ]);

        if ($request->wantsTurboStream()) {
            session()->flash('success', 'Producto actualizado correctamente.');
            return response()->turboStream()
                ->action('redirect')
                ->attributes(['url' => route('admin.product.index')]);
        }

        return redirect()->route('admin.product.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->purchaseDetails()->exists() || $product->inventories()->exists()) {
            return redirect()->route('admin.product.index')
                ->with('error', 'No se puede eliminar el producto porque tiene compras o inventario asociados.');
        }

        $product->delete();

        return redirect()->route('admin.product.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
