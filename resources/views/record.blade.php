<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Audio Recorder</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>Audio Recorder</h1>
    </header>
    <main>
        <p><button id="btnStart">START RECORDING</button><br/>
        <button id="btnStop">STOP RECORDING</button></p>
        
        <audio controls></audio>
        
        <audio id="aud2" controls></audio>
    </main>    
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        let constraintObj = { 
            audio: true, 
            video: false
        }; 

        navigator.mediaDevices.getUserMedia(constraintObj)
        .then(function(mediaStreamObj) {
            let audio = document.querySelector('audio');
            if ("srcObject" in audio) {
                audio.srcObject = mediaStreamObj;
            } else {
                audio.src = window.URL.createObjectURL(mediaStreamObj);
            }
            
            audio.onloadedmetadata = function(ev) {
                audio.play();
            };
            
            let start = document.getElementById('btnStart');
            let stop = document.getElementById('btnStop');
            let audSave = document.getElementById('aud2');
            let mediaRecorder = new MediaRecorder(mediaStreamObj);
            let chunks = [];
            
            start.addEventListener('click', (ev) => {
                mediaRecorder.start();
                console.log(mediaRecorder.state);
            });
            stop.addEventListener('click', (ev) => {
                mediaRecorder.stop();
                console.log(mediaRecorder.state);
            });
            mediaRecorder.ondataavailable = function(ev) {
                chunks.push(ev.data);
            };
            mediaRecorder.onstop = async (ev) => {
                let blob = new Blob(chunks, { 'type' : 'audio/mp4;' });
                chunks = [];
                let audioURL = window.URL.createObjectURL(blob);
                audSave.src = audioURL;

                let formData = new FormData();
                formData.append('audio', blob);

                let response = await fetch("{{ route('record.save') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                let result = await response.json();
                if (result.success) {
                    console.log('Audio saved successfully!');
                } else {
                    console.log('Failed to save audio.');
                }
            };
        })
        .catch(function(err) { 
            console.log(err.name, err.message); 
        });
    </script>
</body>
</html>
