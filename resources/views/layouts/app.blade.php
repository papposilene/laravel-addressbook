<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    prefix="og: http://ogp.me/ns#">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') - {{ config('app.name', 'My Address Book') }}</title>

        <!-- Social Networks -->
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:site" content="{{ __('meta.twitter') }}" />
        <meta name="twitter:creator" content="{{ __('meta.twitter') }}" />
        <meta property="og:title" content="@yield('title') - {{ config('app.name', 'My Address Book') }}" />
        <meta property="og:description" content="{{ __('meta.description') }}" />
        <meta property="og:image" content="{{ asset('images/lexporateur.jpg') }}" />

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>

        @if (App::environment(['prod', 'production']))
        <!-- Matomo -->
        <script type="opt-in" data-type="application/javascript" data-name="matomo">
        var _paq = window._paq = window._paq || [];
        _paq.push(["setDomains", ["*.map.psln.nl"]]);
        _paq.push(["setDoNotTrack", true]);
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u="//pwk.psln.nl/";
            _paq.push(['setTrackerUrl', u+'matomo.php']);
            _paq.push(['setSiteId', '8']);
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
            g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
        })();
        </script>
        <!-- End Matomo Code -->
        @endif
    </head>
    <body class="antialiased font-sans bg-gray-700 text-white" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <div id="addressbook" class="flex flex-col h-min-screen">
            <livewire:menu />

            <!-- Page Heading -->
            @if (isset($header))
            <header class="flex bg-gray-800 shadow">
                <div class="flex max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endif

            <!-- Page Content -->
            <main class="h-min-screen w-full">
                {{ $slot }}
            </main>
        </div>

        <livewire:footer />

        @stack('modals')

        @livewireScripts
        @stack('scripts')

        @if (App::environment(['prod', 'production']))
        <!-- Matomo -->
        <noscript>
            <img type="opt-in" data-type="application/javascript" data-name="matomo" data-src="//pwk.psln.nl/matomo.php?idsite=8&amp;rec=1" style="border:0;" alt="" />
        </noscript>
        @endif
    </body>
</html>
