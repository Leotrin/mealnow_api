@extends('layouts.admin')

@section('content')
    <div class="row-fluid">
        @include('backend.shop.contact.form')
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>Shops <span class="semi-bold">list</span></h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="grid-body ">
                    <table class="table table-striped dataTableSort">
                        <thead>
                        <tr>
                            <th>Method</th>
                            <th>Contact</th>
                            <th>Priority</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($shop->contact_methods)>0)
                            @foreach($shop->contact_methods as $item)
                                <tr class="odd gradeX">
                                    <td style="text-transform: capitalize;">{{ $item->method }}</td>
                                    <td>{{ $item->contact }}</td>
                                    <td>{{ $item->priority }}</td>
                                    <td class="center">
                                        <a href="{{ url('/admin/shop/'.$item->shop_id.'/contact_methods/edit/'.$item->id) }}" class="btn btn-info">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{ url('/admin/shop/'.$item->shop_id.'/contact_methods/delete/'.$item->id) }}" class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
