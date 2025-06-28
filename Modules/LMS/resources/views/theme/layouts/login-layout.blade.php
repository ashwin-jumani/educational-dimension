@php
    $settings = [
        
    ];
@endphp

@include('theme::layouts.partials.head')

<body class="home-online-education">

    <main>
        {{ $slot }}
    </main>

    @include('theme::layouts.partials.footer-script', ['data' => []])
</body>

</html>
