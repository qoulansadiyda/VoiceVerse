<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4 flex justify-between items-center">
                <h1 class="text-lg font-semibold">Dashboard</h1>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded">Logout</button>
                </form>
            </div>
            <div class="p-4">
                <form action="{{ route('audio.store') }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700">Title</label>
                        <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>
                    <div class="video-container">
                        <audio id="preview" controls></audio>
                        <button type="button" id="startRecord" class="px-3 py-2 text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 my-2">Mulai Rekam</button>
                        <button type="button" id="stopRecord" class="px-3 py-2 text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 my-2" disabled>Berhenti Rekam</button>
                        <audio id="recorded" controls class="hidden mt-4"></audio>
                    </div>
                    <input type="hidden" name="audio" id="audioData">
                    <button type="submit" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded">Unggah Audio</button>
                </form>

                @if($audios->isNotEmpty())
                    <h2 class="text-md font-semibold mb-2">Audio yang Diunggah:</h2>
                    @foreach($audios as $audio)
                        <div class="mb-4">
                            <audio controls class="w-full mb-2">
                                <source src="{{ asset('storage/' . $audio->path) }}" type="audio/mp3">
                                Your browser does not support the audio element.
                            </audio>
                            <form action="{{ route('audio.destroy', $audio->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="mt-2 bg-red-500 text-white py-2 px-4 rounded">Hapus Audio</button>
                            </form>
                        </div>
                    @endforeach
                @else
                    <p>Tidak ada audio yang diunggah.</p>
                @endif

                <a href="{{ route('library') }}" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded">Go to Library</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.tailwindcss.com/"></script>
    <script>
        let mediaRecorder;
        let recordedBlobs;

        const preview = document.getElementById('preview');
        const startRecordButton = document.getElementById('startRecord');
        const stopRecordButton = document.getElementById('stopRecord');
        const recordedAudio = document.getElementById('recorded');
        const audioData = document.getElementById('audioData');

        navigator.mediaDevices.getUserMedia({ audio: true })
            .then(stream => {
                preview.srcObject = stream;
                window.stream = stream;

                startRecordButton.addEventListener('click', startRecording);
                stopRecordButton.addEventListener('click', stopRecording);
            })
            .catch(error => {
                console.error('Error accessing media devices.', error);
            });

        function startRecording() {
            recordedBlobs = [];
            const options = { mimeType: 'audio/webm' };
            try {
                mediaRecorder = new MediaRecorder(window.stream, options);
            } catch (e) {
                console.error('Exception while creating MediaRecorder:', e);
            }

            mediaRecorder.onstop = (event) => {
                const blob = new Blob(recordedBlobs, { type: 'audio/webm' });
                const url = window.URL.createObjectURL(blob);
                recordedAudio.src = url;
                recordedAudio.classList.remove('hidden');
                const reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    audioData.value = reader.result;
                }
            };

            mediaRecorder.ondataavailable = (event) => {
                if (event.data && event.data.size > 0) {
                    recordedBlobs.push(event.data);
                }
            };

            mediaRecorder.start();
            startRecordButton.disabled = true;
            stopRecordButton.disabled = false;
        }

        function stopRecording() {
            mediaRecorder.stop();
            startRecordButton.disabled = false;
            stopRecordButton.disabled = true;
        }
    </script>
</body>
</html>
