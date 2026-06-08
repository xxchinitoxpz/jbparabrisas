<x-app-layout>
    <x-slot:title>
        Nuevo Cliente
    </x-slot:title>

    <turbo-frame id="modal" data-modal-size="max-w-2xl">
        <div class="max-w-2xl mx-auto space-y-6 p-6 sm:p-8">
            <!-- Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <div>
                    <h3 class="text-lg font-bold text-usat-blue">Registrar Cliente</h3>
                    <p class="text-xs text-gray-400">Registra un nuevo cliente en el sistema.</p>
                </div>
                <button type="button" @click="typeof closeModal === 'function' ? closeModal() : window.location.href='{{ route('admin.customer.index') }}'" class="text-gray-400 hover:text-gray-500 transition focus:outline-none">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.customer.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Company Name Field -->
                <div>
                    <x-input-label for="company_name" :value="__('Nombre / Razón Social')" />
                    <x-text-input id="company_name" name="company_name" type="text" value="{{ old('company_name') }}" placeholder="Ej. Juan Pérez o Inversiones del Norte S.A.C." class="block mt-1 w-full text-sm" required autofocus />
                    <x-input-error :messages="$errors->get('company_name')" class="mt-1" />
                </div>

                <!-- RUC/DNI Field -->
                <div>
                    <x-input-label for="ruc_dni" :value="__('RUC / DNI')" />
                    <x-text-input id="ruc_dni" name="ruc_dni" type="text" value="{{ old('ruc_dni') }}" placeholder="Ej. 10456789012 o 45678901" class="block mt-1 w-full text-sm" required />
                    <x-input-error :messages="$errors->get('ruc_dni')" class="mt-1" />
                </div>

                <!-- Phone Field -->
                <div>
                    <x-input-label for="phone" :value="__('Teléfono')" />
                    <x-text-input id="phone" name="phone" type="text" value="{{ old('phone') }}" placeholder="Ej. 987654321 o (074) 456789" class="block mt-1 w-full text-sm" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                </div>

                <!-- Description Field -->
                <div>
                    <x-input-label for="description" :value="__('Dirección / Detalles (Opcional)')" />
                    <textarea id="description" name="description" rows="3" placeholder="Dirección del cliente u otras observaciones..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" @click="typeof closeModal === 'function' ? closeModal() : window.location.href='{{ route('admin.customer.index') }}'" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition">
                        Cancelar
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-sm font-bold rounded-xl transition shadow-lg shadow-emerald-600/10">
                        Guardar Cliente
                    </button>
                </div>
            </form>
        </div>
    </turbo-frame>
</x-app-layout>
