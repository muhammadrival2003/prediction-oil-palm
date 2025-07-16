@props([
    'active' => false,
    'activeChildItems' => false,
    'activeIcon' => null,
    'badge' => null,
    'badgeColor' => null,
    'badgeTooltip' => null,
    'childItems' => [],
    'first' => false,
    'grouped' => false,
    'icon' => null,
    'last' => false,
    'shouldOpenUrlInNewTab' => false,
    'sidebarCollapsible' => true,
    'subGrouped' => false,
    'url',
])

@php
    $sidebarCollapsible = $sidebarCollapsible && filament()->isSidebarCollapsibleOnDesktop();
@endphp

<li
    {{
        $attributes->class([
            'fi-sidebar-item',
            // @deprecated `fi-sidebar-item-active` has been replaced by `fi-active`.
            'fi-active fi-sidebar-item-active' => $active,
            'flex flex-col gap-y-1' => $active || $activeChildItems,
        ])
    }}
>
    <a
        {{ \Filament\Support\generate_href_html($url, $shouldOpenUrlInNewTab) }}
        x-on:click="window.matchMedia(`(max-width: 1024px)`).matches && $store.sidebar.close()"
        @if ($sidebarCollapsible)
            x-data="{ tooltip: false }"
            x-effect="
                tooltip = $store.sidebar.isOpen
                    ? false
                    : {
                          content: @js($slot->toHtml()),
                          placement: document.dir === 'rtl' ? 'left' : 'right',
                          theme: $store.theme,
                      }
            "
            x-tooltip.html="tooltip"
        @endif
        @class([
            'fi-sidebar-item-button relative flex items-center justify-center gap-x-3 rounded-xl px-3 py-2.5 transition-all duration-200 ease-in-out motion-reduce:transition-none motion-reduce:transform-none group',
            'hover:bg-gradient-to-r hover:from-emerald-50 hover:to-emerald-100/50 dark:hover:from-emerald-900/20 dark:hover:to-emerald-800/20 hover:shadow-sm hover:scale-[1.02] motion-reduce:hover:scale-100 motion-reduce:hover:shadow-none focus-visible:bg-emerald-100 dark:focus-visible:bg-emerald-900/30' => filled($url),
            'bg-gradient-to-r from-emerald-100 to-emerald-50 dark:from-emerald-900/30 dark:to-black-100 shadow-sm ring-emerald-200/50 dark:ring-emerald-700/50 motion-reduce:shadow-none' => $active,
        ])
    >
        @if (filled($icon) && ((! $subGrouped) || $sidebarCollapsible))
            <x-filament::icon
                :icon="($active && $activeIcon) ? $activeIcon : $icon"
                :x-show="($subGrouped && $sidebarCollapsible) ? '! $store.sidebar.isOpen' : false"
                @class([
                    'fi-sidebar-item-icon h-5 w-5 transition-all duration-200 ease-in-out',
                    'text-gray-500 dark:text-gray-400 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 group-hover:scale-110' => ! $active,
                    'text-emerald-600 dark:text-emerald-400 scale-110' => $active,
                ])
            />
        @endif

        @if ((blank($icon) && $grouped) || $subGrouped)
            <div
                @if (filled($icon) && $subGrouped && $sidebarCollapsible)
                    x-show="$store.sidebar.isOpen"
                @endif
                class="fi-sidebar-item-grouped-border relative flex h-6 w-6 items-center justify-center"
            >
                @if (! $first)
                    <div
                        class="absolute -top-1/2 bottom-1/2 w-px bg-gray-300 dark:bg-gray-600"
                    ></div>
                @endif

                @if (! $last)
                    <div
                        class="absolute -bottom-1/2 top-1/2 w-px bg-gray-300 dark:bg-gray-600"
                    ></div>
                @endif

                <div
                    @class([
                        'relative h-1.5 w-1.5 rounded-full',
                        'bg-emerald-400 dark:bg-emerald-500' => ! $active,
                        'bg-white-600 dark:bg-white-400' => $active,
                    ])
                ></div>
            </div>
        @endif

        <span
            @if ($sidebarCollapsible)
                x-show="$store.sidebar.isOpen"
                x-transition:enter="lg:transition lg:delay-100"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
            @endif
            @class([
                'fi-sidebar-item-label flex-1 truncate text-sm font-medium transition-colors duration-200 ease-in-out',
                'text-gray-700 dark:text-gray-200 group-hover:text-emerald-700 dark:group-hover:text-emerald-300' => ! $active,
                'text-emerald-700 dark:text-emerald-300 font-semibold' => $active,
            ])
        >
            {{ $slot }}
        </span>

        @if (filled($badge))
            <span
                @if ($sidebarCollapsible)
                    x-show="$store.sidebar.isOpen"
                    x-transition:enter="lg:transition lg:delay-100"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                @endif
            >
                <x-filament::badge
                    :color="$badgeColor"
                    :tooltip="$badgeTooltip"
                >
                    {{ $badge }}
                </x-filament::badge>
            </span>
        @endif
    </a>

    @if (($active || $activeChildItems) && $childItems)
        <ul class="fi-sidebar-sub-group-items flex flex-col gap-y-1">
            @foreach ($childItems as $childItem)
                <x-filament-panels::sidebar.item
                    :active="$childItem->isActive()"
                    :active-child-items="$childItem->isChildItemsActive()"
                    :active-icon="$childItem->getActiveIcon()"
                    :badge="$childItem->getBadge()"
                    :badge-color="$childItem->getBadgeColor()"
                    :badge-tooltip="$childItem->getBadgeTooltip()"
                    :first="$loop->first"
                    grouped
                    :icon="$childItem->getIcon()"
                    :last="$loop->last"
                    :should-open-url-in-new-tab="$childItem->shouldOpenUrlInNewTab()"
                    sub-grouped
                    :url="$childItem->getUrl()"
                >
                    {{ $childItem->getLabel() }}
                </x-filament-panels::sidebar.item>
            @endforeach
        </ul>
    @endif
</li>
