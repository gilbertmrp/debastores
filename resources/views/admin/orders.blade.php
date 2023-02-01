@extends('admin.layouts.master')
@section('content')
<div class="row ">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>New Order Details</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="mainTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Pesanan</th>
                                <th>Jumlah</th>
                                <th>Kode</th>
                                <th>Jumlah Harga</th>
                                <th>Tanggal</th>
                                <th>Alamat Penerima</th>
                                <th>Lihat Gambar</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach ($dataOrders as $data)
                                <tr>
                                    <td>{{ $no++; }}</td>
                                    <td>{{ $data->users->name }}</td>
                                    <td>
                                        {{ $data->barangs->nama_barang }}
                                    </td>
                                    <td>{{ $data->jumlah_pesan }} Buah</td>
                                    <td>{{ $data->kode }}</td>
                                    <td>Rp{{ number_format($data->jumlah_harga, 0, ',', '.') }}</td>
                                    <td>{{ $data->updated_at->isoFormat('dddd, D MMM Y') }}</td>
                                    <td>{{ $data->address }}</td>
                                    <td>
                                        <a href="{{ url('/result-file/'.$data->id) }}" class="nav-link">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ url('/confirm-order-process/'.$data->id) }}"><button type="submit" class="btn btn-primary">Confirm</button></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $dataOrders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
