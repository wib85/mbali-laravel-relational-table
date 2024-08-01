<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fotos = Foto::all();

        return view("foto.index", compact("fotos"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $albums = Album::all();

        return view("foto.create")->with("albums", $albums);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $album     = $request->album;
        $judul     = $request->judul;
        $deskripsi = $request->deskripsi;

        $insertFoto                 = new Foto();
        $insertFoto->album_id       = $album;
        $insertFoto->judul          = $judul;
        $insertFoto->tanggal_unggah = date("Y-m-d");

        /**
         * deskripsi opsional bisa diisi bisa tidak
         * isi deskripsi apabila user input deskripsi
         */
        if (!empty($deskripsi)) {
            $insertFoto->deskripsi = $deskripsi;
        }

        // check apakah terdapat file yang diupload oleh user?
        // pemanfaatan percabangan dapat kita lihat pada level code berikut
        if ($request->hasFile("foto"))
        {
            // ambil input file yang bernama foto
            $foto = $request->file("foto");
            // buat nama file yang benar-benar unik per detiknya
            // ambil extensi nama file yang diupload
            $namaFotoBaru = date("Y_m_d_H_i_s") . "." . $foto->getClientOriginalExtension();
            //upload file ke dalam folder foto & rename file yang sudah diupload
            $foto->storeAs("/foto", $namaFotoBaru, "public");
            // masukan nama file ke dalam field lokasi_file pada table foto
            $insertFoto->lokasi_file = "foto/{$namaFotoBaru}";
        }
        $insertFoto->save();

        return redirect()->route("foto.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $albums = Album::all();

        $foto = Foto::where("id", "=", $id)->first();

        $data = [
            "albums" => $albums,
            "foto"   => $foto
        ];

        return view("foto.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $album     = $request->album;
        $judul     = $request->judul;
        $deskripsi = $request->deskripsi;

        $updateFoto                 = [
            "album_id"       => $album,
            "judul"          => $judul,
        ];
        /**
         * deskripsi opsional bisa diisi bisa tidak
         * isi deskripsi apabila user input deskripsi
         */
        if (!empty($deskripsi)) {
            $updateFoto["deskripsi"] = $deskripsi;
        }

        // check apakah terdapat file yang diupload oleh user?
        // pemanfaatan percabangan dapat kita lihat pada level code berikut
        if ($request->hasFile("foto"))
        {
            // ambil input file yang bernama foto
            $foto = $request->file("foto");
            // check apakah benar foto tersebut diisi dan bukan file corrupt
            if ($foto->isValid()) {

                // dapat dilihat pemanfaatan method deleteFileFoto
                // salah satu manfaat anda menggunakan konsep OOP:
                // kita hanya membuat 1 method tetapi dapat dimanfaatkan berulang kali
                $this->deleteFileFoto($id); //delete file yang lama apabila terdapat file yang baru!
                // buat nama file yang benar-benar unik per detiknya
                // ambil extensi nama file yang diupload
                $namaFotoBaru = date("Y_m_d_H_i_s") . "." . $foto->getClientOriginalExtension();
                //upload file ke dalam folder foto & rename file yang sudah diupload
                $foto->storeAs("/foto", $namaFotoBaru, "public");
                // masukan nama file ke dalam field lokasi_file pada table foto
                $updateFoto["lokasi_file"]= "foto/{$namaFotoBaru}";
            }
        }

        Foto::where("id", "=", $id)->update($updateFoto);

        return redirect()->route("foto.index");
    }


    private function deleteFileFoto(string $id) {
        $foto = Foto::where("id", $id)->first();
        // check apakah ada file data folder storage
        if (Storage::disk("public")->exists($foto->lokasi_file))
        {
            // apabila file ditemukan maka hapus foto sebelum hapus data pada tabel
            Storage::disk("public")->delete($foto->lokasi_file);
        }
    }

    public function destroy(string $id)
    {
        $foto = Foto::where("id", $id)->first();

        // panggil fungsi delete file foto
        $this->deleteFileFoto($id);

        $foto->delete();

        return redirect()->route("foto.index");
    }
}
