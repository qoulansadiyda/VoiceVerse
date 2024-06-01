<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recording;

class RecordingController extends Controller
{
    public function create()
    {
        return view('record.create');
    }

    public function save(Request $request)
    {
        // Simpan audio yang direkam oleh pengguna
        $user = Auth::user();
        $path = $request->file('audio')->store('recordings', 'public');

        $recording = new Recording();
        $recording->user_id = $user->id;
        $recording->file_path = $path;
        $recording->save();

        return response()->json(['success' => true, 'path' => $path]);
    }
}
