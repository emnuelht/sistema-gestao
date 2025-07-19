<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Teste de Desenvolvimento - Laravel</title>

    {{-- @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css'])
    @endif --}}

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div id="root">
        {{ $slot }}
    </div>
</body>
</html>
