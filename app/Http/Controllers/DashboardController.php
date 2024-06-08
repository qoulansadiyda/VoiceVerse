<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Audio; // Tambahkan baris ini untuk mengimpor model Audio

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $audios = Audio::where('user_id', Auth::id())->get();
        return view('dashboard', compact('audios'));
    }

    public function uploadAudio(Request $request)
    {
        $audioData = $request->audio;
        $title = $request->title;

        $audioName = time() . '.webm';
        Storage::disk('public')->put($audioName, base64_decode(preg_replace('#^data:audio/\w+;base64,#i', '', $audioData)));

        $audio = new Audio();
        $audio->user_id = Auth::id();
        $audio->title = $title;
        $audio->path = $audioName;
        $audio->save();

        return redirect()->route('library');
    }

    public function library()
    {
        $audios = Audio::with('user')->get();
        return view('library', compact('audios'));
    }
}

