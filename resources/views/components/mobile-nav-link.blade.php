@props(['active'])

@php
$classes = ($active ?? false)
            ? 'group flex items-center space-x-2 rounded-lg border border-primary-50 bg-primary-50 px-3 py-2 text-sm font-semibold text-primary-600 dark:border-transparent dark:bg-primary-700/75 dark:text-white'
            : 'group flex items-center space-x-2 rounded-lg border border-transparent px-3 py-2 text-sm font-medium text-gray-800 hover:bg-primary-50 hover:text-primary-600 active:border-primary-100 dark:text-gray-200 dark:hover:bg-white/10 dark:hover:text-white dark:active:border-white/20';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} wire:navigate>
    {{ $slot }}
</a>
