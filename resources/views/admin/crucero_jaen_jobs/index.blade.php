<x-app-layout>
    <x-slot:title>
        Trabajos Crucero Jaén
    </x-slot:title>

    <div class="space-y-6" x-data="{
        carouselOpen: false,
        photos: [],
        currentIndex: 0,
        openCarousel(jobPhotos) {
            this.photos = jobPhotos;
            this.currentIndex = 0;
            this.carouselOpen = true;
        },
        closeCarousel() {
            this.carouselOpen = false;
            this.photos = [];
        },
        next() {
            if (this.photos.length > 0) {
                this.currentIndex = (this.currentIndex + 1) % this.photos.length;
            }
        },
        prev() {
            if (this.photos.length > 0) {
                this.currentIndex = (this.currentIndex - 1 + this.photos.length) % this.photos.length;
            }
        }
    }">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div>
                <h3 class="text-lg font-bold text-usat-blue">Trabajos Crucero Jaén</h3>
                <p class="text-xs text-gray-400">Administra los trabajos de Crucero Jaén, sus fechas, estados y evidencias fotográficas.</p>
            </div>
            <div>
                <a href="{{ route('admin.crucero_jaen_job.create') }}" data-turbo-frame="modal" class="inline-flex items-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-emerald-600/10">
                    <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nuevo Trabajo
                </a>
            </div>
        </div>

        <!-- Filter & Table Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Filters -->
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <form action="{{ route('admin.crucero_jaen_job.index') }}" method="GET" class="flex flex-col md:flex-row w-full gap-4">
                    <div class="flex-1">
                        <x-text-input type="text" name="search" value="{{ $search }}" placeholder="Buscar por descripción..." class="w-full text-sm" />
                    </div>
                    <div class="w-full md:w-48">
                        <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm">
                            <option value="">Todos los estados</option>
                            <option value="pendiente" {{ $status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="cancelado" {{ $status == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                            <option value="cobrado" {{ $status == 'cobrado' ? 'selected' : '' }}>Cobrado</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-usat-blue hover:bg-blue-800 text-white text-sm font-bold rounded-xl transition">
                            Buscar / Filtrar
                        </button>
                        @if($search || $status)
                            <a href="{{ route('admin.crucero_jaen_job.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-bold rounded-xl transition flex items-center">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="border-b border-gray-150 text-gray-400 font-bold text-xs uppercase bg-gray-50/70">
                            <th class="py-3.5 px-6" width="120">Fecha</th>
                            <th class="py-3.5 px-6">Descripción</th>
                            <th class="py-3.5 px-6" width="120">Estado</th>
                            <th class="py-3.5 px-6" width="160">Fotos</th>
                            <th class="py-3.5 px-6 text-center" width="120">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($jobs as $job)
                            <tr class="hover:bg-gray-50/40 transition">
                                <td class="py-3.5 px-6 font-bold text-gray-900">
                                    {{ $job->job_date->format('d/m/Y') }}
                                </td>
                                <td class="py-3.5 px-6 text-gray-700 font-medium whitespace-pre-line">{{ $job->description }}</td>
                                <td class="py-3.5 px-6">
                                    @if($job->status == 'pendiente')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            Pendiente
                                        </span>
                                    @elseif($job->status == 'cancelado')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Cancelado
                                        </span>
                                    @elseif($job->status == 'cobrado')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                            Cobrado
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-6">
                                    @if($job->photos && count($job->photos) > 0)
                                        @php
                                            $photoUrls = array_map(function($photo) {
                                                return \App\Support\PublicImageStorage::url($photo);
                                            }, $job->photos);
                                        @endphp
                                        <button type="button" 
                                                @click="openCarousel(@js($photoUrls))" 
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-usat-blue hover:bg-blue-100 hover:text-blue-800 text-xs font-semibold rounded-lg transition duration-150 shadow-sm border border-blue-100">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Ver Fotos ({{ count($job->photos) }})
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Sin fotos adjuntas</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-6">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.crucero_jaen_job.edit', $job->id) }}" data-turbo-frame="modal" class="p-2 bg-amber-50 text-usat-gold hover:bg-amber-100 rounded-lg transition duration-150" title="Editar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.crucero_jaen_job.destroy', $job->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar este trabajo? Se borrarán permanentemente sus fotos.');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg transition duration-150" title="Eliminar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-405">
                                    <div class="flex flex-col items-center justify-center space-y-2 text-gray-400">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        <span>No se encontraron trabajos registrados.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($jobs->hasPages())
                <div class="p-6 border-t border-gray-100">
                    {{ $jobs->links() }}
                </div>
            @endif
        </div>

        <!-- Modal de Carrusel de Fotos -->
        <div x-show="carouselOpen" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             @keydown.escape.window="closeCarousel()"
             role="dialog" 
             aria-modal="true"
        >
            <!-- Backdrop -->
            <div x-show="carouselOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black/85 backdrop-blur-md transition-opacity"
                 @click="closeCarousel()"
            ></div>

            <!-- Modal Content Wrapper (Centered) -->
            <div class="fixed inset-0 flex items-center justify-center p-4 z-50">
                <div x-show="carouselOpen"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="relative max-w-4xl w-full bg-gray-900 rounded-3xl overflow-hidden shadow-2xl border border-gray-800 flex flex-col max-h-[90vh]"
                     @click.outside="closeCarousel()"
                >
                    <!-- Close button in upper right -->
                    <button @click="closeCarousel()" type="button" class="absolute top-4 right-4 z-50 p-2 bg-gray-800/80 hover:bg-gray-700/80 text-gray-400 hover:text-white rounded-full transition focus:outline-none focus:ring-2 focus:ring-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    <!-- Carousel/Image Area -->
                    <div class="relative flex-1 flex items-center justify-center min-h-[300px] sm:min-h-[450px] p-6 bg-black/40">
                        <!-- Navigation Arrows (only show if photos > 1) -->
                        <div x-show="photos.length > 1">
                            <!-- Prev Button -->
                            <button @click="prev()" type="button" class="absolute left-4 top-1/2 -translate-y-1/2 z-10 p-3 bg-gray-800/60 hover:bg-gray-700/80 text-white rounded-full transition focus:outline-none backdrop-blur-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <!-- Next Button -->
                            <button @click="next()" type="button" class="absolute right-4 top-1/2 -translate-y-1/2 z-10 p-3 bg-gray-800/60 hover:bg-gray-700/80 text-white rounded-full transition focus:outline-none backdrop-blur-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Active Image -->
                        <div class="w-full h-full flex items-center justify-center">
                            <template x-for="(photo, index) in photos" :key="index">
                                <div x-show="currentIndex === index" 
                                     x-transition:enter="transition ease-out duration-300 absolute"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-200 absolute"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="max-w-full max-h-[60vh] flex items-center justify-center"
                                >
                                    <img :src="photo" alt="Imagen del trabajo" class="max-w-full max-h-[60vh] object-contain rounded-lg shadow-md" />
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Footer/Pagination Dots (only show if photos > 1) -->
                    <div class="p-6 bg-gray-950 flex flex-col items-center justify-center gap-4">
                        <div class="text-gray-400 text-xs font-semibold">
                            Imagen <span class="text-white" x-text="currentIndex + 1"></span> de <span class="text-white" x-text="photos.length"></span>
                        </div>
                        
                        <div class="flex items-center justify-center gap-2" x-show="photos.length > 1">
                            <template x-for="(photo, index) in photos" :key="index">
                                <button @click="currentIndex = index" 
                                        type="button"
                                        class="w-2.5 h-2.5 rounded-full transition-all duration-300 focus:outline-none"
                                        :class="currentIndex === index ? 'bg-emerald-500 w-6' : 'bg-gray-600 hover:bg-gray-400'"
                                ></button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
