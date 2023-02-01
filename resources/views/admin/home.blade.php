@extends('admin.layouts.master')
@section('content')
    <div class="row ">
        <div class="card">
            <div class="card-header" style="margin:5%">
                <h1>Hello, {{ Auth::user()->name }}</h1>
            </div>
            <div class="card-body" style="border-top: 1px solid rgb(168, 166, 166)">
                <p>You're logged in as an</p><span>Admin</span>
            </div>
        </div>
    </div>
@endsection
