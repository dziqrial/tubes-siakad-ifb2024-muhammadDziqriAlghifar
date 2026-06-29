<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $fillable = [
        'kode_matakuliah',
        'nidn',
        'kelas',
        'hari',
        'jam'
    ];

    public function dosen(){
        return $this->belongsTo(Dosen::class, 'nidn', 'nidn');
    }

    public function matakuliah(){
        return $this->belongsTo(Matakuliah::class, 'kode_matakuliah', 'kode_matakuliah');
    }
}
