@extends('layout')

@section('content')
<div>
    <h3>Edit Foto</h3>
    <a href="{{ route('foto.index') }}"> Kembali</a>
    <br>
    <br>
    <form action="{{ route('foto.update', $foto->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div>
            <label for="album">Album</label>
            <select name="album" id="album" required="required">
                <option value="">Pilih Album</option>
                @foreach($albums as $album)
                    @php
                        // pemanfaatan percabanganan / operator ternary
                        $selected = $album->id == $foto->album_id ? "selected" : "";
                    @endphp
                    <option value="{{ $album->id }}" {{ $selected }}>{{ $album->nama_album }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="judul">Judul</label>
            <input type="text" id="judul" name="judul" placeholder="Judul Foto" value="{{ $foto->judul }}" required>
        </div>
        <div>
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" placeholder="Deskripsi Foto">{{ $foto->deskripsi }}</textarea>
        </div>
        <!-- Tampilkan Foto -->
        <img src="{{ asset("storage/{$foto->lokasi_file}") }}" alt="{{ $foto->judul }}" width="30%" />
        <div>
            <label for="foto">Foto</label>
            <input type="file" name="foto" id="foto" accept="image/*">
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>
@endsection
