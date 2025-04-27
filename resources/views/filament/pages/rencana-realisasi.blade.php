<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        <!-- Card Many Gawangan Manual -->
        <a href="{{ url('/admin/many-gawangan-manuals') }}"
            class="group relative block overflow-hidden rounded-xl bg-white p-6 shadow-lg transition-all duration-300 hover:shadow-xl hover:-translate-y-1 border border-gray-200">

            <!-- Icon -->
            <!-- <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-primary-100 text-primary-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div> -->

            <!-- Title -->
            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-primary-600">
                Many Gawangan Manual
            </h3>

            <!-- Description -->
            <p class="mt-2 text-sm text-gray-500">
                Kelola data gawangan secara manual
            </p>

            <!-- Arrow indicator -->
            <div class="mt-4 flex items-center text-sm font-medium text-primary-600">
                Buka menu
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </div>
        </a>

        <!-- Anda bisa menambahkan card lainnya di sini dengan pola yang sama -->
        <!--
        <a href="{{ url('/admin/other-menu') }}" class="...">
            ...
        </a>
        -->
    </div>
</x-filament-panels::page>