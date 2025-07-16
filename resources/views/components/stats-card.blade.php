@props([
    'title',
    'value',
    'icon',
    'lastUpdated',
    'color' => 'emerald'
])

<div class="bg-gradient-to-br from-white to-{{ $color }}-50 dark:from-gray-800 dark:to-{{ $color }}-900/20 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1 border border-gray-200/50 dark:border-gray-700/50">
    <div class="p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $title }}</p>
                <p class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $value }}
                </p>
            </div>
            <div class="p-3 rounded-full bg-{{ $color }}-100 dark:bg-{{ $color }}-800/50 text-{{ $color }}-600 dark:text-{{ $color }}-300">
                {!! $icon !!}
            </div>
        </div>
    </div>
    @if($lastUpdated)
    <div class="bg-gray-50 dark:bg-gray-700/30 px-6 py-3 text-sm text-gray-500 dark:text-gray-400 border-t border-gray-200/50 dark:border-gray-700/50">
        <span class="flex items-center">
            <span class="w-2 h-2 rounded-full bg-{{ $color }}-500 mr-2"></span>
            Update terakhir: {{ $lastUpdated }}
        </span>
    </div>
    @endif
</div>