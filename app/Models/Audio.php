<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    use HasFactory;

    protected $table = 'audios'; // Jika tabel Anda memiliki nama lain, ubah di sini


    protected $fillable = ['user_id', 'title', 'path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
