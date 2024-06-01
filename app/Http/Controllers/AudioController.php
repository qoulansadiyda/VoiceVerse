<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AudioController extends Controller
{
    public function uploadAudio(Request $request)
    {
        $request->validate([
            'audio' => 'required|mimes:mp3,wav,aac|max:20000', // Adjust the validation rules as needed
        ]);

        if ($request->file('audio')->isValid()) {
            $path = $request->file('audio')->store('audio');

            return redirect()->route('dashboard')->with('audio', $path);
        }

        return back()->withErrors(['audio' => 'There was a problem uploading the audio file.']);
    }
}
