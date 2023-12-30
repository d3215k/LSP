<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Sertifikat {{ $title ?? config('app.name', 'LSP') }}</title>

        <!-- Inter web font from Google -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite('resources/css/app.css')

        <style type="text/css" media="print">
            body {
                margin: 0;
            }

            @media print {
              body {-webkit-print-color-adjust: exact;}
              .pagebreak { clear: both; page-break-before: always; }
            }
        </style>

        <!-- Scripts -->
        {{-- @vite('resources/js/app.js') --}}

    </head>
    <body
        {{-- onload="window.print()" --}}
    >
        <div class="font-sans antialiased text-gray-900">
            {{ $slot }}
        </div>
    </body>
</html>
