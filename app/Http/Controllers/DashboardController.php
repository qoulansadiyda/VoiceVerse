<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $audio = session('audio', null);
        return view('dashboard', compact('audio'));
    }

    public function uploadAudio(Request $request)
    {
        $request->validate([
            'audio' => 'required|mimes:mp3,wav|max:20480',
        ]);

        $path = $request->file('audio')->store('audios');

        return redirect()->route('dashboard')->with('audio', $path);
    }
}
