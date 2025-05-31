<x-filament-panels::page>
    <!-- Header dengan Tombol Create -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Menu Pekerjaan</h1>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('filament.admin.pages.afdeling.menu', ['afdeling_id' => $afdeling_id]) }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 p-4">
        <!-- Card Rencana Pemupukan -->
        <a href="{{ route('filament.admin.pages.blok-pemupukan', ['afdeling_id' => $this->afdeling_id]) }}"
            class="group relative block rounded-xl bg-white dark:bg-gray-800 p-6 transition-all 
                  hover:shadow-lg hover:-translate-y-1 border border-gray-200 dark:border-gray-700
                  shadow-sm hover:border-emerald-500 dark:hover:border-emerald-400 duration-300">

            <div class="flex items-start justify-between gap-2">
                <!-- Text Content -->
                <div class="space-y-3">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 
                              group-hover:text-emerald-600 dark:group-hover:text-emerald-400">
                        Rencana Pemupukan
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Rencana dan Realisasi Pemupukan sesuai dengan Blok Tanam
                    </p>
                </div>

                <!-- Icon -->
                <div class="p-3 bg-emerald-100 dark:bg-emerald-900/30 group-hover:opacity-0 rounded-lg transition duration-150 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600 dark:text-emerald-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                    </svg>
                </div>
            </div>

            <!-- Hover Indicator -->
            <div class="absolute bottom-16 right-9 opacity-0 group-hover:opacity-100 transition-opacity transition duration-150 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </div>
        </a>
    </div>
</x-filament-panels::page>