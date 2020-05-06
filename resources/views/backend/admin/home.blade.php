@extends('layouts.admin')


@section('content')
    @include('backend.admin.parts.orders')
    @include('backend.admin.parts.orders-list')
    <div class="col-md-6 p0">
        @include('backend.admin.parts.support')
    </div>
    <div class="col-md-6 p0">

    </div>
@endsection
