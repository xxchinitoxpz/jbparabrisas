<x-app-layout>
    <x-slot:title>
        Modificar Stock
    </x-slot:title>

    <turbo-frame id="modal" data-modal-size="max-w-2xl">
        <div class="max-w-2xl mx-auto space-y-6 p-6 sm:p-8">
            <!-- Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <div>
                    <h3 class="text-lg font-bold text-usat-blue">Modificar Registro de Stock</h3>
                    <p class="text-xs text-gray-400">Edita los detalles del stock seleccionado.</p>
                </div>
                <button type="button" @click="typeof closeModal === 'function' ? closeModal() : window.location.href='{{ route('admin.inventory.index') }}'" class="text-gray-400 hover:text-gray-500 transition focus:outline-none">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.inventory.update', $inventory->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Product Select -->
                <div>
                    <x-input-label for="product_id" :value="__('Producto / Vidrio')" />
                    <select id="product_id" name="product_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm" required autofocus>
                        <option value="">-- Seleccionar Producto --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id', $inventory->product_id) == $product->id ? 'selected' : '' }}>
                                {{ $product->code }} - {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('product_id')" class="mt-1" />
                </div>

                <!-- Quantity & Stored Date -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="quantity" :value="__('Cantidad')" />
                        <x-text-input id="quantity" name="quantity" type="number" min="0" value="{{ old('quantity', $inventory->quantity) }}" placeholder="Ej. 10" class="block mt-1 w-full text-sm" required />
                        <x-input-error :messages="$errors->get('quantity')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="stored_date" :value="__('Fecha de Almacenamiento')" />
                        <x-text-input id="stored_date" name="stored_date" type="date" value="{{ old('stored_date', $inventory->stored_date) }}" class="block mt-1 w-full text-sm" required />
                        <x-input-error :messages="$errors->get('stored_date')" class="mt-1" />
                    </div>
                </div>

                <!-- Supplier Select -->
                <div>
                    <x-input-label for="supplier_id" :value="__('Proveedor')" />
                    <select id="supplier_id" name="supplier_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm" required>
                        <option value="">-- Seleccionar Proveedor --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id', $inventory->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->company_name }} (RUC/DNI: {{ $supplier->ruc_dni }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('supplier_id')" class="mt-1" />
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" @click="typeof closeModal === 'function' ? closeModal() : window.location.href='{{ route('admin.inventory.index') }}'" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition">
                        Cancelar
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-sm font-bold rounded-xl transition shadow-lg shadow-emerald-600/10">
                        Actualizar Stock
                    </button>
                </div>
            </form>
        </div>
    </turbo-frame>
</x-app-layout>
