@extends('layouts.new_admin')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-0">Coupons</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{!! url('/') !!}"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item" >Coupons</li>
            </ol>
        </div>
        <div id="accordion2">
            <div class="card mb-2">
                <div class="card-header">
                    <a class="d-flex justify-content-between text-dark btn btn-default collapsed" data-toggle="collapse" aria-expanded="false" href="#accordion2-1"><span><i class="fa fa-plus"></i>Add New Coupon</span><div class="collapse-icon"></div></a>
                </div>

                <div id="accordion2-1" class="collapse" data-parent="#accordion2">
                    <div class="card-body">
                        <div class="row" style="padding:10px;">
                            {{ Form::open(array('url' => '/admin/cupons' , 'method'=>'post', 'class'=>'col-md-6 col-md-offset-3', 'style'=>'padding:10px;border:1px solid #ccc;')) }}

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <h4>Register new cupon </h4>
                            <div class="col-md-12">
                                <div class="col-md-8 col-sm-8 p0 form-group">
                                    <label class="form-label">Sum <small>( Fix price or % )</small></label>
                                    {{ Form::number('sum', 1, array('class'=>'form-control', 'step'=>0.5,'min'=>1, 'required'=>'required')) }}
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-3 col-md-offset-1 col-sm-3 col-sm-offset-1 p0 form-group">
                                    <label class="form-label">Type</label>
                                    {{ Form::select('type', ['Fixed'=>'Fixed', '%'=>'%'], null, array('class'=>'form-control')) }}
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-8 col-sm-8 p0 form-group">
                                    <label class="form-label">Key Code</label>
                                    {{ Form::text('key', null, array('class'=>'form-control', 'placeholder'=>'CUPONK3YC0D3', 'required'=>'required','min'=>6)) }}
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-3 col-md-offset-1 col-sm-3 col-sm-offset-1 p0 form-group">
                                    <label class="form-label">Limit</label>
                                    {{ Form::number('limit', 1, array('class'=>'form-control', 'min'=>1,'max'=>10, 'required'=>'required','step'=>1)) }}
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-12 text-right" style="padding-top:10px;">
                                {{Form::submit('Save', array('class'=>'btn btn-primary'))}}
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="card">
            <h6 class="card-header">Coupons List</h6>
            <div class="card-body">
                <div class="card-datatable table-responsive">
                    <table class="table table-striped myTable" id="DataTables_Table_1" role="grid" >
                        <thead>
                        <tr>
                            <th>Sum</th>
                            <th>Key Code</th>
                            <th>Limit</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cupons as $item)
                            <tr class="odd gradeX">
                                <td>{{ $item->sum }} - <small>{{ $item->type }}</small></td>
                                <td>{{ $item->key }}</td>
                                <td>{{ $item->limit }}</td>
                                <td class="center">
                                    <a href="{{ url('/admin/cupons/delete/'.$item->id) }}" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
