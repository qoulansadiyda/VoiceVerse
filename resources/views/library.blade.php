<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4">
                <h1 class="text-lg font-semibold mb-4">Library</h1>
                @if($audios->isNotEmpty())
                    @foreach($audios as $audio)
                        <div class="mb-4">
                            <h2 class="text-md font-semibold">{{ $audio->title }}</h2>
                            <p>Uploaded by: {{ $audio->user->name }}</p>
                            <audio controls class="w-full mb-2">
                            <source src="{{ asset('storage/audio/' . $audio->path) }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        
                        </div>
                    @endforeach
                @else
                    <p>No audio files uploaded yet.</p>
                @endif
                <a href="{{ route('dashboard') }}" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.tailwindcss.com/"></script>
</body>
</html>
