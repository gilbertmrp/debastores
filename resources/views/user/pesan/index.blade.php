@extends('user.layouts.app')
@section('title')
    Pesan Menu
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ url('list-menu') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="col-md-12 mt-2">
                <div class="container-fluid">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('list-menu') }}">Menu</a></li>
                            <li class="breadcrumb-item">Check Out</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ url('productimage') }}/{{ $barang->gambar }}" width="445px" alt="">
                            </div>
                            <div class="col-md-6 mt-4">
                                <h3>{{ $barang->nama_barang }}</h3>
                                <table class="table table-borderless">
                                    <form action="{{ url('/pesan-process/'.$barang->id) }}" method="POST">
                                    <tr>
                                        <td>Harga</td>
                                        <td>:</td>
                                        <td>Rp. {{ number_format($barang->harga) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Stok</td>
                                        <td>:</td>
                                        <td>{{ $barang->stok }}</td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan</td>
                                        <td>:</td>
                                        <td>{{ $barang->keterangan }}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat Pengirim</td>
                                        <td>:</td>
                                        <td>
                                            <textarea name="address" id="" cols="40" rows="7" style="resize: none" required value={{ old('address') }}></textarea>    
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Pesan</td>
                                        <td>:</td>
                                        <td>
                                                @csrf
                                                <input type="number" name="jumlah_pesan" class="form-control" required min="1" value="{{ old('jumlah_pesan') }}">
                                                <button type="submit" class="btn btn-primary mt-2"><i
                                                        class="fas fa-shopping-cart"></i> add cart</button>
                                            
                                        </td>
                                    </tr>
                                    </form>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
