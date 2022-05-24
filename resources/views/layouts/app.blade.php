<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class=""
    prefix="og: http://ogp.me/ns#" x-cloak
      x-data="{darkMode: localStorage.getItem('dark') === 'true'}"
      x-init="$watch('darkMode', val => localStorage.setItem('dark', val))"
      x-bind:class="{'dark': darkMode}">
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
        <meta property="og:image" content="{{ asset('img/addressbook.jpg') }}" />

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
            var u="{{ env('MATOMO_URL') }}";
            _paq.push(['setTrackerUrl', u+'matomo.php']);
            _paq.push(['setSiteId', '{{ env('MATOMO_SITE', 0) }}']);
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
            g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
        })();
        </script>
        <!-- End Matomo Code -->
        @endif
    </head>

    <body class="antialiased font-sans bg-slate-100 text-black dark:bg-gray-700 dark:text-white" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <div id="addressbook" class="flex flex-col h-min-screen">
            <livewire:menu />

            <!-- Page Heading -->
            @if (isset($header))
            <header class="flex bg-white dark:bg-gray-900 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 w-full">
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
