@extends('layouts.new_admin')

@section('content')
    <div class="row-fluid" style="padding: 20px;">
        <div class="card">
            <div class="grid simple " style="padding:10px;">
                <div class="grid-title">
                    <h5><span class="semi-bold">Cupons</span></h5> <br>
                    <h5><a class="text-dark" data-toggle="collapse" href="#CouponAccordion" aria-expanded="true">Register new Cupon</a></h5>
                </div>
                <div class="collapse hidden grid-body" id="CouponAccordion">
                    <div class="col-md-12" style="padding:10px;">
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
                            <div class="col-md-8 col-sm-8 p0">
                                <label>Sum <small>( Fix price or % )</small></label>
                                {{ Form::number('sum', 1, array('class'=>'form-control', 'step'=>0.5,'min'=>1, 'required'=>'required')) }}
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-3 col-md-offset-1 col-sm-3 col-sm-offset-1 p0">
                                <label>Type</label>
                                {{ Form::select('type', ['Fixed'=>'Fixed', '%'=>'%'], null, array('class'=>'form-control')) }}
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-8 col-sm-8 p0">
                                <label>Key Code</label>
                                {{ Form::text('key', null, array('class'=>'form-control', 'placeholder'=>'CUPONK3YC0D3', 'required'=>'required','min'=>6)) }}
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-3 col-md-offset-1 col-sm-3 col-sm-offset-1 p0">
                                <label>Limit</label>
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
        <div class="card">
            <h6 class="card-header">Support <span class="semi-bold">Tickets</span></h6>
            <div class="card-datatable table-responsive">
                <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
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
        </div>
    </div>

@endsection
