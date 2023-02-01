@extends('user.layouts.app')
@section('title')
    List Menu
@endsection
@section('content')
    <div class="container">
        <div class="row">
            @foreach ($dataMenu as $barang)
            <div class="card col-sm-4" style="border: 1px solid blue; margin:5px; width:350px; height:auto;justify-content:center; align-items:center;">
                <img src="{{ url('productimage') }}/{{ $barang->gambar }}"  class="card-img-top" alt="{{ $barang->gambar }}" style="width:300px; height:200px;"/>
                <div class="card-body">
                  <h5 class="card-title">{{ $barang->nama_barang }}</h5>
                  <p class="card-text">
                    <strong>Harga :</strong> Rp.{{ number_format($barang->harga) }} <br>
                    <strong>Stok :</strong> {{ $barang->stok }} <br>
                    <hr>
                    <strong>Keterangan : {{ $barang->keterangan }}</strong> <br>
                  </p>
                  @if($barang->stok <= 0)
                    <p class="text-danger">*Maaf, stok sudah habis.</p>
                    <a href="{{ url('pesan') }}/{{ $barang->id }}" class="btn btn-primary disabled"><i class="fas fa-shopping-cart"></i> Pesan</a>
                  @else
                  <a href="{{ url('pesan') }}/{{ $barang->id }}" class="btn btn-primary"><i class="fas fa-shopping-cart"></i> Pesan</a>
                  @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
