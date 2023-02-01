@extends('admin.layouts.master')
@section('content')
<div class="section-body">
    <div class="row">
      <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
          <form action="{{ url('/add-gallery-process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
              <h4>Tambah Gallery</h4>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label>Tile</label>
                <input type="text" class="form-control" name="title" required="">
              </div>
              <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="img" class="form-control" required="">
              </div>
            </div>
            <div class="card-footer text-right">
              <a href="{{ route('gallerys') }}"><button type="button" class="btn btn-secondary text-dark">Kembali</button></a>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection