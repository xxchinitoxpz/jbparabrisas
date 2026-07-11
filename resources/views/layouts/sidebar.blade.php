<!-- Sidebar Container -->
<aside :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" 
       x-data="{ 
           openInventory: false,
           openCustomers: false
       }"
       class="fixed inset-y-0 left-0 z-50 w-64 bg-usat-blue text-white transition-transform duration-300 ease-in-out transform lg:translate-x-0 lg:static lg:inset-0 flex flex-col shadow-2xl border-r border-blue-950">
    
    <!-- Sidebar Header / Logo -->
    <div class="h-16 flex items-center px-6 border-b border-blue-800/50 bg-blue-950/40">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
            <!-- Glass/Windshield Themed SVG Icon -->
            <svg class="w-9 h-9 text-emerald-400 group-hover:scale-105 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 16V8a2 2 0 00-1.35-1.9l-7-2.33a2 2 0 00-1.3 0l-7 2.33A2 2 0 003 8v8a2 2 0 001.35 1.9l7 2.33a2 2 0 001.3 0l7-2.33A2 2 0 0021 16z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8h18M12 3v18" />
            </svg>
            <div>
                <h1 class="font-extrabold text-lg tracking-tight leading-none text-white">JB <span class="text-emerald-400">Parabrisas</span></h1>
                <span class="text-[10px] text-blue-300 font-semibold tracking-wider uppercase">Ventas y Servicios</span>
            </div>
        </a>
    </div>

    <!-- Navigation Items -->
    <nav class="flex-1 px-3 py-6 space-y-1.5 overflow-y-auto">
        <!-- Item: Dashboard -->
        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-xl transition duration-150 {{ request()->routeIs('dashboard') ? 'bg-emerald-500/10 text-emerald-400 border-l-4 border-emerald-500' : 'text-blue-100 hover:bg-blue-850 hover:text-white' }}">
            <svg class="w-5 h-5 me-3 {{ request()->routeIs('dashboard') ? 'text-emerald-400' : 'text-blue-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path>
            </svg>
            Dashboard
        </a>

        <!-- Item: Trabajos Ángel Divino -->
        <a href="{{ route('admin.divine_angel_job.index') }}" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-xl transition duration-150 {{ request()->routeIs('admin.divine_angel_job.*') ? 'bg-emerald-500/10 text-emerald-400 border-l-4 border-emerald-500' : 'text-blue-100 hover:bg-blue-850 hover:text-white' }}">
            <svg class="w-5 h-5 me-3 {{ request()->routeIs('admin.divine_angel_job.*') ? 'text-emerald-400' : 'text-blue-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            Trabajos Ángel Divino
        </a>

        <!-- Item: Trabajos Crucero Jaén -->
        <a href="{{ route('admin.crucero_jaen_job.index') }}" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-xl transition duration-150 {{ request()->routeIs('admin.crucero_jaen_job.*') ? 'bg-emerald-500/10 text-emerald-400 border-l-4 border-emerald-500' : 'text-blue-100 hover:bg-blue-850 hover:text-white' }}">
            <svg class="w-5 h-5 me-3 {{ request()->routeIs('admin.crucero_jaen_job.*') ? 'text-emerald-400' : 'text-blue-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            Trabajos Crucero Jaén
        </a>

        <!-- Section: Gestión de Inventario (Collapsible) -->
        <div class="space-y-1">
            <button @click="openInventory = !openInventory" 
                    class="w-full flex items-center justify-between px-4 py-2.5 text-sm font-semibold rounded-xl text-blue-100 hover:bg-blue-850 hover:text-white transition duration-150 focus:outline-none">
                <div class="flex items-center">
                    <svg class="w-5 h-5 me-3 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Gestión de Inventario</span>
                </div>
                <svg :class="{'rotate-180': openInventory}" class="w-4 h-4 text-blue-300 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            
            <div x-show="openInventory" x-transition.opacity class="ps-8 pe-2 py-1 space-y-1" style="display: none;">
                <a href="{{ route('admin.product.index') }}" class="block py-2 px-3 text-xs font-bold rounded-lg text-blue-200 hover:text-white hover:bg-blue-850 {{ request()->routeIs('admin.product.*') ? 'bg-blue-850 text-white' : '' }}">
                    • Parabrisas / Vidrios
                </a>
                <a href="{{ route('admin.inventory.index') }}" class="block py-2 px-3 text-xs font-bold rounded-lg text-blue-200 hover:text-white hover:bg-blue-850 {{ request()->routeIs('admin.inventory.*') ? 'bg-blue-850 text-white' : '' }}">
                    • Control de Inventario
                </a>
                <a href="{{ route('admin.supplier.index') }}" class="block py-2 px-3 text-xs font-bold rounded-lg text-blue-200 hover:text-white hover:bg-blue-850 {{ request()->routeIs('admin.supplier.*') ? 'bg-blue-850 text-white' : '' }}">
                    • Proveedores
                </a>
            </div>
        </div>

        <!-- Section: Directorio (Collapsible) -->
        <div class="space-y-1">
            <button @click="openCustomers = !openCustomers" 
                    class="w-full flex items-center justify-between px-4 py-2.5 text-sm font-semibold rounded-xl text-blue-100 hover:bg-blue-850 hover:text-white transition duration-150 focus:outline-none">
                <div class="flex items-center">
                    <svg class="w-5 h-5 me-3 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>Directorio</span>
                </div>
                <svg :class="{'rotate-180': openCustomers}" class="w-4 h-4 text-blue-300 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openCustomers" x-transition.opacity class="ps-8 pe-2 py-1 space-y-1" style="display: none;">
                <a href="{{ route('admin.customer.index') }}" class="block py-2 px-3 text-xs font-bold rounded-lg text-blue-200 hover:text-white hover:bg-blue-850 {{ request()->routeIs('admin.customer.*') ? 'bg-blue-850 text-white' : '' }}">
                    • Clientes
                </a>
            </div>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-blue-800/50 bg-blue-950/20 text-xs text-blue-300 text-center">
        &copy; 2026 JB Parabrisas
    </div>
</aside>

<!-- Background Overlay for Mobile Sidebar -->
<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/50 lg:hidden" x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
