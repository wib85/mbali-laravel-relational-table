@extends('layout')

@section('content')
<div>
    <h3>Foto</h3>
    <a href="{{ route('foto.index') }}"> Kembali</a>
    <br>
    <br>
    <form action="{{ route('foto.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="album">Album</label>
            <select name="album" id="album" required="required">
                <option value="">Pilih Album</option>
                @foreach($albums as $album)
                    <option value="{{ $album->id }}">{{ $album->nama_album }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="judul">Judul</label>
            <input type="text" id="judul" name="judul" placeholder="Judul Foto" required>
        </div>
        <div>
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" placeholder="Deskripsi Foto"></textarea>
        </div>
        <div>
            <label for="foto">Foto</label>
            <input type="file" name="foto" id="foto" accept="image/*" required>
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>
@endsection
