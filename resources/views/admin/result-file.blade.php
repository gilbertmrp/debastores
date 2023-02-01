@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Detail Gambar
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <a href="productimage/{{ $dataResultFile->gambar }}" data-sub-html="Demo Description">
                      <img class="img-responsive thumbnail" src="productimage/{{ $dataResultFile->gambar }}"
                        alt="{{ $dataResultFile->gambar }}">
                    </a>
                  </div>
                <div class="card-body">
                    <a href="{{ url('/order-details') }}"><button type="button" class="btn btn-primary">Kembali</button></a>
                </div>
            </div>
        </div>
    </div>
@endsection