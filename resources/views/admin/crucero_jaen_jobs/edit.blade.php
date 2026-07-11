<x-app-layout>
    <x-slot:title>
        Editar Trabajo Crucero Jaén
    </x-slot:title>

    <turbo-frame id="modal" data-modal-size="max-w-2xl">
        <div class="max-w-2xl mx-auto space-y-6 p-6 sm:p-8">
            <!-- Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <div>
                    <h3 class="text-lg font-bold text-usat-blue">Editar Trabajo Crucero Jaén</h3>
                    <p class="text-xs text-gray-400">Modifica la información, el estado o las fotos del trabajo.</p>
                </div>
                <button type="button" @click="typeof closeModal === 'function' ? closeModal() : window.location.href='{{ route('admin.crucero_jaen_job.index') }}'" class="text-gray-400 hover:text-gray-500 transition focus:outline-none">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.crucero_jaen_job.update', $job->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Date Field -->
                <div>
                    <x-input-label for="job_date" :value="__('Fecha del Trabajo')" />
                    <x-text-input id="job_date" name="job_date" type="date" value="{{ old('job_date', $job->job_date->format('Y-m-d')) }}" class="block mt-1 w-full text-sm" required autofocus />
                    <x-input-error :messages="$errors->get('job_date')" class="mt-1" />
                </div>

                <!-- Description Field -->
                <div>
                    <x-input-label for="description" :value="__('Descripción del Trabajo')" />
                    <textarea id="description" name="description" rows="4" placeholder="Describe a detalle el trabajo realizado..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm" required>{{ old('description', $job->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>

                <!-- Status Field -->
                <div>
                    <x-input-label for="status" :value="__('Estado')" />
                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm" required>
                        <option value="pendiente" {{ old('status', $job->status) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="cancelado" {{ old('status', $job->status) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        <option value="cobrado" {{ old('status', $job->status) == 'cobrado' ? 'selected' : '' }}>Cobrado</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-1" />
                </div>

                <!-- Current Photos Section -->
                @if($job->photos && count($job->photos) > 0)
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Fotos actuales (Pasa el cursor y marca para eliminar):</label>
                        <div class="grid grid-cols-3 sm:grid-cols-4 gap-4">
                            @foreach($job->photos as $photo)
                                <div class="relative group border border-gray-200 rounded-xl overflow-hidden shadow-sm bg-gray-50 aspect-square">
                                    <img src="{{ \App\Support\PublicImageStorage::url($photo) }}" alt="Foto del trabajo" class="w-full h-full object-cover" />
                                    <!-- Hover overlay to remove -->
                                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition duration-150 flex items-center justify-center">
                                        <label class="flex flex-col items-center cursor-pointer text-white select-none">
                                            <input type="checkbox" name="remove_photos[]" value="{{ $photo }}" class="rounded text-red-600 focus:ring-red-500 w-4 h-4" />
                                            <span class="text-[10px] mt-1.5 font-bold tracking-wider uppercase">Eliminar</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Upload New Photos Field -->
                <div>
                    <x-input-label for="photos" :value="__('Subir Más Fotos')" />
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-emerald-400 transition cursor-pointer relative">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="photos-upload" class="relative cursor-pointer bg-white rounded-md font-semibold text-emerald-600 hover:text-emerald-500 focus-within:outline-none">
                                    <span>Selecciona archivos</span>
                                    <input id="photos-upload" name="photos[]" type="file" multiple accept="image/*" class="sr-only" onchange="updateFileList(this)" />
                                </label>
                            </div>
                            <p class="text-xs text-gray-400">PNG, JPG, JPEG, GIF, WEBP hasta 4MB cada uno</p>
                            <div id="file-list" class="mt-2 text-xs font-semibold text-emerald-600"></div>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('photos')" class="mt-1" />
                    <x-input-error :messages="$errors->get('photos.*')" class="mt-1" />
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" @click="typeof closeModal === 'function' ? closeModal() : window.location.href='{{ route('admin.crucero_jaen_job.index') }}'" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition">
                        Cancelar
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-sm font-bold rounded-xl transition shadow-lg shadow-emerald-600/10">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>

        <script>
            function updateFileList(input) {
                const fileListDiv = document.getElementById('file-list');
                fileListDiv.innerHTML = '';
                if (input.files.length > 0) {
                    const count = input.files.length;
                    fileListDiv.innerText = `${count} archivo(s) seleccionado(s): ` + Array.from(input.files).map(f => f.name).join(', ');
                }
            }
        </script>
    </turbo-frame>
</x-app-layout>
