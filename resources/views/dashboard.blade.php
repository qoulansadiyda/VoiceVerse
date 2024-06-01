<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-slot name="content">
        <div class="container mx-auto px-4">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4">
                    <h1 class="text-lg font-semibold mb-4">Dashboard</h1>
                    <form action="{{ route('upload.audio') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="audio" accept="audio/*" class="mb-4" id="audio-upload">
                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Unggah Audio</button>
                    </form>
                    @if (session('audio'))
                        <h2>Audio yang diunggah:</h2>
                        <div id="waveform" class="w-full mb-4"></div>
                        <audio id="audioPlayer" controls class="w-full mb-4">
                            <source src="{{ Storage::url(session('audio')) }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                        <div class="mt-4">
                            <button id="playButton" class="bg-green-500 text-white py-2 px-4 rounded">Putar</button>
                            <button id="stopButton" class="bg-red-500 text-white py-2 px-4 rounded">Stop</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>

@push('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const playButton = document.getElementById('playButton');
            const stopButton = document.getElementById('stopButton');
            
            const audioPlayer = document.getElementById('audioPlayer');
            const audioFilePath = "{{ Storage::url(session('audio')) }}";

            if (audioFilePath) {
                const wavesurfer = WaveSurfer.create({
                    container: '#waveform',
                    waveColor: 'violet',
                    progressColor: 'purple'
                });

                wavesurfer.load(audioFilePath);

                playButton.addEventListener('click', () => {
                    wavesurfer.play();
                });

                stopButton.addEventListener('click', () => {
                    wavesurfer.stop();
                });
            }
        });
    </script>
@endpush
