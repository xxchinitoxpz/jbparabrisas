<x-app-layout>
    <x-slot:title>
        Dashboard de Gestión JB Parabrisas
    </x-slot:title>

    <div class="space-y-8">
        <!-- Welcome Header -->
        <div class="bg-gradient-to-r from-usat-blue to-blue-950 rounded-2xl p-6 md:p-8 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="text-2xl md:text-3xl font-extrabold tracking-tight">¡Bienvenido de vuelta, {{ Auth::user()->name }}!</h3>
                <p class="text-blue-100 mt-2 text-sm md:text-base max-w-xl">
                    Este es el panel central de JB Parabrisas. Aquí puedes controlar el inventario de vidrios, registrar nuevas ventas, y supervisar las órdenes de servicio e instalaciones en tiempo real.
                </p>
            </div>
            <!-- Decorative SVG circles -->
            <div class="absolute right-0 bottom-0 translate-y-1/4 translate-x-1/4 opacity-10 pointer-events-none">
                <svg class="w-80 h-80 fill-current" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="40" />
                </svg>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card: Parabrisas en Stock -->
            <div class="bg-white p-6 rounded-2xl border-t-4 border-emerald-500 shadow-md border border-gray-100 flex flex-col justify-between hover:shadow-lg transition duration-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Stock Disponible</p>
                        <h4 class="text-3xl font-extrabold text-gray-800 mt-1">342 und</h4>
                    </div>
                    <span class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </span>
                </div>
                <div class="mt-4 flex items-center text-xs">
                    <span class="text-emerald-500 font-bold flex items-center me-2">
                        <svg class="w-3.5 h-3.5 me-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path></svg>
                        +5%
                    </span>
                    <span class="text-gray-400 font-medium">Ingresos de esta semana</span>
                </div>
            </div>

            <!-- Card: Ventas del Mes -->
            <div class="bg-white p-6 rounded-2xl border-t-4 border-usat-gold shadow-md border border-gray-100 flex flex-col justify-between hover:shadow-lg transition duration-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Ventas del Mes</p>
                        <h4 class="text-3xl font-extrabold text-gray-800 mt-1">S/. 14,850</h4>
                    </div>
                    <span class="p-3 bg-amber-50 text-usat-gold rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </span>
                </div>
                <div class="mt-4 flex items-center text-xs">
                    <span class="text-emerald-500 font-bold flex items-center me-2">
                        <svg class="w-3.5 h-3.5 me-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path></svg>
                        +12.4%
                    </span>
                    <span class="text-gray-400 font-medium">vs mes anterior</span>
                </div>
            </div>

            <!-- Card: Órdenes Pendientes -->
            <div class="bg-white p-6 rounded-2xl border-t-4 border-usat-blue shadow-md border border-gray-100 flex flex-col justify-between hover:shadow-lg transition duration-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Servicios Activos</p>
                        <h4 class="text-3xl font-extrabold text-gray-800 mt-1">6 Órdenes</h4>
                    </div>
                    <span class="p-3 bg-blue-50 text-usat-blue rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </span>
                </div>
                <div class="mt-4 flex items-center text-xs">
                    <span class="text-usat-blue font-bold me-2">Taller Principal</span>
                    <span class="text-gray-400 font-medium">Instalación / Reparación</span>
                </div>
            </div>

            <!-- Card: Servicios Realizados -->
            <div class="bg-white p-6 rounded-2xl border-t-4 border-emerald-600 shadow-md border border-gray-100 flex flex-col justify-between hover:shadow-lg transition duration-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Completados (Mes)</p>
                        <h4 class="text-3xl font-extrabold text-gray-800 mt-1">94 Trabajos</h4>
                    </div>
                    <span class="p-3 bg-green-50 text-emerald-700 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </span>
                </div>
                <div class="mt-4 flex items-center text-xs">
                    <span class="text-emerald-600 font-bold me-2">98.5% Éxito</span>
                    <span class="text-gray-400 font-medium">Calificación de clientes</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Activities Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left 2 Cols: Recent Activity Table -->
            <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100 lg:col-span-2">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-lg font-bold text-usat-blue">Últimas Órdenes de Servicio</h4>
                    <a href="#" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 transition">Ver todo &rarr;</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 text-gray-400 font-semibold text-xs uppercase">
                                <th class="pb-3">Cliente / Vehículo</th>
                                <th class="pb-3">Servicio / Detalle</th>
                                <th class="pb-3 text-right">Monto</th>
                                <th class="pb-3 text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-gray-700">
                            <tr>
                                <td class="py-4">
                                    <div class="font-bold">Juan Pérez</div>
                                    <div class="text-xs text-gray-400">Toyota Hilux (Placa: ABC-123)</div>
                                </td>
                                <td class="py-4 font-medium text-gray-900">Instalación de Parabrisas Delantero</td>
                                <td class="py-4 text-right font-bold text-emerald-600">S/. 380.00</td>
                                <td class="py-4 text-center">
                                    <span class="px-2.5 py-1 text-[11px] font-bold bg-emerald-50 text-emerald-700 rounded-full">Completado</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4">
                                    <div class="font-bold">María Ramos</div>
                                    <div class="text-xs text-gray-400">Hyundai Accent (Placa: XYZ-789)</div>
                                </td>
                                <td class="py-4 font-medium text-gray-900">Reparación de Trizadura Lateral</td>
                                <td class="py-4 text-right font-bold text-emerald-600">S/. 95.00</td>
                                <td class="py-4 text-center">
                                    <span class="px-2.5 py-1 text-[11px] font-bold bg-emerald-50 text-emerald-700 rounded-full">Completado</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-4">
                                    <div class="font-bold">Carlos Mendoza</div>
                                    <div class="text-xs text-gray-400">Nissan Sentra (Placa: MNP-456)</div>
                                </td>
                                <td class="py-4 font-medium text-gray-900">Cambio de Luneta Trasera</td>
                                <td class="py-4 text-right font-bold text-emerald-600">S/. 290.00</td>
                                <td class="py-4 text-center">
                                    <span class="px-2.5 py-1 text-[11px] font-bold bg-amber-50 text-amber-700 rounded-full">En Proceso</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right 1 Col: Quick Actions -->
            <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100 space-y-6 flex flex-col justify-between">
                <div>
                    <h4 class="text-lg font-bold text-usat-blue mb-2">Acciones Rápidas</h4>
                    <p class="text-xs text-gray-400">Administra inventario y nuevas ventas rápidamente.</p>
                </div>

                <div class="space-y-4">
                    <!-- Action: Nueva Venta -->
                    <button class="w-full bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold py-3.5 px-4 rounded-xl flex items-center justify-center space-x-2 transition shadow-lg shadow-emerald-600/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span>Registrar Venta</span>
                    </button>

                    <!-- Action: Nueva Orden de Trabajo -->
                    <button class="w-full bg-usat-gold hover:bg-amber-600 active:bg-amber-700 text-white font-bold py-3.5 px-4 rounded-xl flex items-center justify-center space-x-2 transition shadow-lg shadow-amber-600/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <span>Nueva Orden de Trabajo</span>
                    </button>

                    <!-- Action: Consultar Stock -->
                    <button class="w-full bg-usat-blue hover:bg-blue-800 active:bg-blue-900 text-white font-bold py-3.5 px-4 rounded-xl flex items-center justify-center space-x-2 transition shadow-lg shadow-blue-900/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <span>Consultar Stock</span>
                    </button>
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400">
                    <span>Estado de Base de Datos</span>
                    <span class="flex items-center text-emerald-500 font-bold">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 me-1.5 animate-pulse"></span>
                        Conectado
                    </span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
