<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cosplayer extends Model
{
    use HasFactory;

    protected $table = 'cosplayer';
    protected $primaryKey = 'id_cosplayer';

    protected $fillable = [
        'no_peserta',
        'nama_peserta',
        'nama_karakter',
        'asal_series',
        'foto',
    ];

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'id_cosplayer', 'id_cosplayer');
    }

    public function hasilSaw()
    {
        return $this->hasOne(HasilSaw::class, 'id_cosplayer', 'id_cosplayer');
    }
}
