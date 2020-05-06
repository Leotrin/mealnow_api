@extends('layouts.new_admin')


@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-0">Dashboard</h4>
    <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
        </ol>
    </div>
    @include('new_backend.admin.parts.orders')
    @include('new_backend.admin.parts.orders-list')
    <div class="col-md-6" style="margin-top:25px;">
        @include('new_backend.admin.parts.support')
    </div>
    <div class="col-md-6 p0">

    </div>
</div>
@endsection
