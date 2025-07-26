@props([
    'title',
    'subtitle' => null,
    'backUrl' => null,
    'backText' => 'Kembali'
])

<div>
    <!-- Enhanced Header with Gradient Background -->
    <div class="flex items-center justify-between">
        <div class="border-l-4 border-emerald-500 dark:border-emerald-700 ps-4 py-2">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h1>
            @if($subtitle)
                <p class="text-sm text-emerald-600 dark:text-emerald-400 mt-1">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
        
        @if($backUrl)
            <div>
                <a href="{{ $backUrl }}" 
                   class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-emerald-200 dark:border-emerald-800 rounded-lg text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-colors duration-300 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    {{ $backText }}
                </a>
            </div>
        @endif
    </div>
</div>