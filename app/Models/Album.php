<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    use HasFactory;

    public $table = "master.albums";

    protected $fillable = [
        "id",
        "nama_album",
        "deskripsi",
        "tanggal_dibuat",
    ];


    public function fotos() : HasMany {
        return $this->hasMany(Foto::class, "album_id", "id");
    }
}
