<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Money Keep') }} - @yield('title')</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js" defer></script>
    @yield('js-bottom')
</head>

<body class="bg-gray-100 antialiased font-sans text-gray-600">
<main class="flex w-100 flex-col min-h-screen" id="app">
    @include('partials.navbar.one.top')

    <div class="main flex-1">
        @if (Session::has('success'))
            <div class="md:max-w-5xl mx-auto">
                @component('components.alert', [
                'variant' => 'success',
                'icon' => true,
                'classes' => 'my-2',
                'close' => 'true'
                ])
                    {{ Session::get('success') }}
                @endcomponent
            </div>
        @endif

        @yield('content')
    </div>

    <footer class=" mx-auto px-4 py-6 border-t">
        <div class="container text-center mx-auto">
            Copyrights &copy; {{ date('Y') }}.
        </div>
    </footer>

</main>
@stack('scripts')
</body>

</html>
