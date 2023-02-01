@extends('admin.layouts.master')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">User Not Activated</h4>
            <a href="{{ route('user.role') }}"><button type="button" class="btn btn-primary">Kembali</button></a>
            <a href="{{ route('restore.all.user') }}" style="float: right;"><button type="button" class="btn btn-danger">Restore All</button></a>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($trashesUser as $index => $data)
                        @if($data->usertype == '1')
                            <tr class="text-center text-muted">
                                <td class="text-center"><h5>{{ $index + $trashesUser->firstItem() }}</h5></td>
                                <td class="text-center"><h5>{{ $data->name }}</h5></td>
                                <td class="text-center"><h6>{{ $data->email }}</h6></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-danger" disabled>Not-Activated</button>
                                    <a href="{{ url('/restore/'.$data->id) }}"  data-id={{ $data->id }} data-nama={{ $data->name }}><button type="button" class="btn btn-success btn-icon-text"><i class="mdi mdi-delete"></i>Restore</button></a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                {{ $trashesUser->links() }}
            </div>
        </div>
    </div>
</div>
@endsection