<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>My Mate</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="mask-icon" href="/favicon.svg" color="#10b981">
    <meta name="theme-color" content="#060608">
    {{-- Max dude.db upload size (KB), so the import form can pre-check a file before
         uploading instead of failing server-side after a long transfer. --}}
    <meta name="mymate:max-upload-kb" content="{{ (int) config('mymate.import.max_upload_kb') }}">

    {{-- Link-preview Open Graph card --}}
    <meta name="description" content="My Mate - live network monitoring, the modern way. A web-based replacement for MikroTik's The Dude: live topology map, up/down pings, SNMP/RouterOS throughput.">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="My Mate">
    <meta property="og:title" content="My Mate - Network Mate">
    <meta property="og:description" content="Live network monitoring, the modern way. Live topology map, up/down pings, and SNMP/RouterOS throughput with a green->red utilisation ramp.">
    {{-- Use the current request scheme so plain HTTP installs don't emit broken HTTPS links, while
         proxied HTTPS still stays secure because the app trusts X-Forwarded-Proto. --}}
    <meta property="og:url" content="{{ url(request()->path()) }}">
    <meta property="og:image" content="{{ url('/og-image.png') }}">
    @if(request()->isSecure())
        <meta property="og:image:secure_url" content="{{ url('/og-image.png') }}">
    @endif
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/png">
    {{-- Demo mode (sales site): expose the flag + the public read-only viewer creds via
         META TAGS (not an inline <script> - the CSP is `script-src 'self'`, which blocks
         inline scripts). Read from the DOM by features/demo/lib/demo.ts. Only emitted
         when demo mode is on - a real monitoring instance ships nothing here. --}}
    @if((bool) config('mymate.demo.enabled'))
        <meta name="mymate:demo" content="1">
        <meta name="mymate:demo-email" content="{{ config('mymate.demo.email') }}">
        <meta name="mymate:demo-password" content="{{ config('mymate.demo.password') }}">
    @endif
    {{-- Public wallboard (GitHub #15): the /wall/{token} route sets these so the SPA boots straight
         into a read-only, no-login view of one map. Only emitted on that route. --}}
    @isset($wallToken)
        <meta name="mymate:wall-token" content="{{ $wallToken }}">
        <meta name="mymate:wall-map" content="{{ $wallMapId }}">
    @endisset
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.tsx'])
</head>
<body class="antialiased">
    <div id="app"></div>
</body>
</html>
