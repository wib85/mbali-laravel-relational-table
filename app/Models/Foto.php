<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Foto extends Model
{
    use HasFactory;

    public $table = "master.fotos";

    protected $fillable = [
        "id",
        "judul",
        "deskripsi",
        "tanggal_unggah",
        "lokasi_file",
        "album_id",
    ];


    public function album() : BelongsTo {
        return $this->belongsTo(Album::class, "album_id", "id");
    }
}
