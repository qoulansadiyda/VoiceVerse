<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audio List</title>
</head>
<body>
    <h1>Daftar Audio</h1>
    <ul>
        @foreach($audioFiles as $audio)
            <li>
                <audio controls>
                    <source src="{{ asset('storage/' . $audio) }}" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
            </li>
        @endforeach
    </ul>
</body>
</html>
