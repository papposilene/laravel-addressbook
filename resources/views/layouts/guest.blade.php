<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>

        @if (App::environment(['prod', 'production']))
        <!-- Matomo -->
        <script type="opt-in" data-type="application/javascript" data-name="matomo">
        var _paq = window._paq = window._paq || [];
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u="{{ config('app.matomo_url') }}";
            _paq.push(['setTrackerUrl', u+'matomo.php']);
            _paq.push(['setSiteId', '{{ config('app.matomo_site') }}']);
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
            g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
        })();
        </script>
        <!-- End Matomo Code -->
        @endif
    </head>
    <body>
        <div class="antialiased font-sans bg-slate-100 text-black dark:bg-gray-700 dark:text-white">
            {{ $slot }}
        </div>

        @if (App::environment(['prod', 'production']))
        <!-- Matomo -->
        <noscript>
            <img type="opt-in" data-type="application/javascript" data-name="matomo" data-src="{{ config('app.matomo_url') }}/matomo.php?idsite={{ config('app.matomo_site') }}&amp;rec=1" style="border:0;" alt="" />
        </noscript>
        @endif
    </body>
</html>
