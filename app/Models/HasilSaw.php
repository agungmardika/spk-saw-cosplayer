<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilSaw extends Model
{
    use HasFactory;

    protected $table = 'hasil_saw';
    protected $primaryKey = 'id_hasil';

    protected $fillable = [
        'id_cosplayer',
        'total_nilai',
        'ranking',
    ];

    public function cosplayer()
    {
        return $this->belongsTo(Cosplayer::class, 'id_cosplayer', 'id_cosplayer');
    }
}
