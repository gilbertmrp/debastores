@extends('admin.layouts.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tambahkan Menu Terbaik Dari Deba Store</h4>
                        <form action="{{ route('add.menu.process') }}" method="post" enctype="multipart/form-data"
                            class="forms-sample">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="nama_barang" class="form-control" placeholder="Nama Produk" value="{{ old('nama_barang') }}">
                                @error('nama_barang')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="number" name="harga" class="form-control" placeholder="Harga Produk" value="{{ old('harga') }}">
                                @error('harga')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" name="keterangan" class="form-control"
                                    placeholder="Keterangan Produk" >
                                @error('keterangan')
                                    <div class="text-danger" value="{{ old('keterangan') }}">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="number" name="stok" class="form-control"
                                    placeholder="Stok" value="{{ old('stok') }}">
                                @error('stok')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Gambar Produk</label>
                                <input type="file" name="gambar" value="{{ old('gambar') }}">
                                @error('gambar')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <a href="{{ route('menu') }}"><button type="button" class="btn btn-dark btn-icon-text" value="Save"><i class="mdi mdi-plus-box"></i> Kembali</button></a>
                            <button type="submit" class="btn btn-primary btn-icon-text" value="Save"><i class="mdi mdi-plus-box"></i> Tambahkan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection