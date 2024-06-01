<!-- resources/views/record/create.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Merekam Audio Baru') }}
        </h2>
    </x-slot>

    <x-slot name="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <p>Klik tombol "Mulai Merekam" untuk memulai perekaman audio.</p>
                            <p><button id="btnStart" class="btn btn-primary">Mulai Merekam</button></p>
                            <audio controls id="audioPlayer"></audio>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>

@push('scripts')
    <script>
        // Kode JavaScript untuk merekam audio
    </script>
@endpush
