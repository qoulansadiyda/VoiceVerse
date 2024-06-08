<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Audio;

class AudioController extends Controller
{
    public function store(Request $request)
    {
        $audioData = $request->audio;
        $title = $request->title;

        // Pastikan pengguna terotentikasi
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login')->with('error', 'You need to be logged in to upload audio.');
        }

        $audioName = time() . '.mp3';
        Storage::disk('public')->put($audioName, base64_decode(preg_replace('#^data:audio/\w+;base64,#i', '', $audioData)));

        $audio = new Audio();
        $audio->user_id = $userId;
        $audio->title = $title;
        $audio->path = $audioName;
        $audio->save();

        return redirect()->route('library');
    }

    public function index()
    {
        $audios = Audio::with('user')->get();
        return view('library', compact('audios'));
    }

    public function destroy($id)
    {
        $audio = Audio::findOrFail($id);

        // Pastikan hanya pemilik audio atau admin yang bisa menghapus
        if (Auth::id() !== $audio->user_id) {
            return redirect()->route('library')->with('error', 'You are not authorized to delete this audio.');
        }

        Storage::disk('public')->delete($audio->path);
        $audio->delete();

        return redirect()->route('library')->with('success', 'Audio deleted successfully.');
    }
}
