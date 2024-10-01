<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Juan Rautenbach">
        <meta name="description" content="Reservation system technical assessment">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased relative">

    @if(Session::has('message'))
        <div class="absolute top-0 left-0 w-screen" id="toastBanner">
            <div class="flex justify-between bg-orange-500">
                <p class="flex bg-orange-500 justify-center text-white h-8 items-center font-bold w-full">{{ Session::get('message') }}</p>
                <button class="w-8 text-white md:mr-12 mr-2 font-bold hover:cursor-pointer hover:text-teal-200" id="closeBtn" onclick="closeToast()">x</button>
            </div>

        </div>
    @endif


        @inertia
    </body>

<script>

    function closeToast() {
        document.getElementById('toastBanner').classList.add('hidden');
    }

</script>
</html>
