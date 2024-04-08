<!doctype html>
<html>
<head>
    <title>{{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @filamentStyles
    @vite('resources/css/app.css')

    <style>
        figcaption {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Page Container -->
<div
    x-data="{ userDropdownOpen: false, mobileNavOpen: false }"
    id="page-container"
    class="mx-auto flex min-h-dvh w-full min-w-[320px] flex-col bg-gray-100 dark:bg-gray-800/50 dark:text-gray-100"
    >
    <!-- Page Header -->
    <header id="page-header" class="z-1 flex flex-none items-center bg-primary-900">
    <div class="container mx-auto px-4 lg:px-8 xl:max-w-7xl">
        <div class="flex flex-col md:flex-row gap-2 justify-between py-4">
            <!-- Left Section -->
            <div class="dark flex items-center space-x-2 lg:space-x-6">
                <!-- Logo -->
                <a
                href="#"
                class="group inline-flex items-center space-x-2 text-lg font-bold tracking-wide text-gray-900 hover:text-gray-600 dark:text-gray-100 dark:hover:text-gray-300"
                >
                    <span>{{ config('app.name') }}</span>
                </a>
                <!-- END Logo -->

                <!-- Desktop Navigation -->
                <nav class="hidden items-center space-x-2 lg:flex">
                    {{-- <x-nav-link :href="route('pendaftar.dashboard')" :active="request()->routeIs('pendaftar.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link> --}}

                </nav>
                <!-- END Desktop Navigation -->
            </div>
            <!-- END Left Section -->

            <!-- Right Section -->
            <div class="flex items-center space-x-2">
                {{-- <span class="text-white font-semibold">{{ auth()->user()->name }}</span> --}}
            </div>
            <!-- END Right Section -->
        </div>

    </div>
    </header>
    <!-- END Page Header -->

    <!-- Page Content -->
    <main id="page-content" class="flex max-w-full flex-auto flex-col">
    <!-- Page Heading -->
    <div class="dark h-32 bg-primary-900 text-gray-100">
        <div class="container mx-auto px-4 lg:px-8 xl:max-w-7xl">
            <div class="flex items-center py-4">
                {{ $heading ?? '' }}
            </div>
        </div>
    </div>
    <!-- END Page Heading -->

    <!-- Page Section -->
    <div class="container mx-auto -mt-16 p-4 lg:-mt-20 lg:p-8 xl:max-w-7xl">
        <div class="space-y-12">
            <!--

            ADD YOUR MAIN CONTENT BELOW

            -->

            {{ $slot }}

            <!--

            ADD YOUR MAIN CONTENT ABOVE

            -->
        </div>
    </div>
    <!-- END Page Section -->
    </main>
    <!-- END Page Content -->

    <!-- Page Footer -->
    <footer
    id="page-footer"
    class="flex flex-none items-center bg-white dark:bg-gray-800"
    >
        <div
            class="container mx-auto px-4 text-center text-sm"
        >
            <div class="pb-1 pt-4 md:pb-4">
                ©
                {{ date('Y') }}
                <span
                    class="font-medium text-primary-600 hover:text-primary-400 dark:text-primary-400 dark:hover:text-primary-300"
                    >{{ config('app.name') }}</
                >

            </div>
        </div>
    </footer>

    {{-- <div class="fixed p-4 text-white bg-green-500 rounded-full shadow-lg right-4 bottom-6">
        <a href="https://wa.me/6285624114625" target="_blank">
            <svg class="w-6 h-6" fill="currentColor" stroke="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.824 11.824 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"></path>
            </svg>
        </a>
    </div> --}}

    <!-- END Page Footer -->
    </div>
    <!-- END Page Container -->

    <x-impersonate::banner/>

    @livewire('notifications')
    @filamentScripts
    @vite('resources/js/app.js')
</body>
</html>
