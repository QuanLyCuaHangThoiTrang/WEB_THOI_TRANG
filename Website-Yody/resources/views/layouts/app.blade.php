<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, follow" />
    @vite('resources/css/app.css')
    <title>YODY</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Albert+Sans:ital,wght@0,100..900;1,100..900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Oswald:wght@200..700&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Quicksand:wght@300..700&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class=" font-plus-jakara">
        @include('layouts.header')
        @yield('content')
        @include('layouts.footer')
        <div>
            @include('home.components.notification')
        </div>
    </div>

    <script src="https://sf-cdn.coze.com/obj/unpkg-va/flow-platform/chat-app-sdk/0.1.0-beta.7/libs/oversea/index.js">
    </script>
    <script>
        new CozeWebSDK.WebChatClient({
            config: {
                bot_id: '7428863222696525831',
            },
            componentProps: {
                title: 'Coze',
            },
        });
    </script>
</body>

</html>
