@extends('layouts.new_admin')

@section('content')
    <div class="row-fluid" style="padding: 20px;">
        <div class="card">
            <div class="grid simple " style="padding:10px;">
                <div class="grid-title">
                    <h5>Contact <span class="semi-bold">Method</span></h5>
                    @if(isset($contact_method))
                        <h5><a class="text-dark" data-toggle="collapse" href="#ContactMethodAccordion" aria-expanded="true">Edit Contact Method</a></h5>
                        <h5><a class="text-dark" href="{!! url("/admin/shop/$shop->id/contact_methods") !!}">Or Add New</a></h5>
                    @else
                        <h5><a class="text-dark" data-toggle="collapse" href="#ContactMethodAccordion" aria-expanded="true">Add New</a></h5>
                    @endif

                </div>
                <div class="collapse hidden grid-body" id="ContactMethodAccordion">
                    <div class="span12">
                        <div class="grid simple ">
                            <div class="grid-body">
                                <div class="col-md-12" style="padding:0px;">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if(isset($contact_method))
                                        {{ Form::model($contact_method, array('url' => 'admin/shop/'.$shop->id.'/contact_methods/edit/'.$contact_method->id , 'method'=>'post', 'class'=>'col-md-12', 'style'=>'padding:10px;border:1px solid #ccc;', 'enctype'=>'multipart/form-data')) }}
                                        <div class="col-md-4">
                                            <h3>Edit Contact Method</h3>
                                        </div>
                                        <div class="clearfix"></div>
                                    @else
                                        {{ Form::open(array('url' => 'admin/shop/'.$shop->id.'/contact_methods' , 'method'=>'post', 'class'=>'col-md-12', 'style'=>'padding:10px;border:1px solid #ccc;', 'enctype'=>'multipart/form-data')) }}
                                        <h3>Register Contact Method</h3>
                                    @endif

                                    <div class="col-md-4 p10">
                                        <label>Method</label>
                                        {{ Form::select('method', ['email'=>'E-Mail','sms'=>'SMS','fax'=>'Fax','phone'=>'Phone Call'], null, array('class'=>'form-control', 'required'=>'required')) }}
                                    </div>
                                    <div class="col-md-4 p10">
                                        <label>Contact</label>
                                        {{ Form::text('contact', null, array('class'=>'form-control', 'placeholder'=>'Enter : Email, SMS, Fax or Phone number', 'required'=>'required')) }}
                                    </div>
                                    <div class="col-md-4 p10">
                                        <label>Priority</label>
                                        {{ Form::number('priority', null, array('class'=>'form-control', 'min'=>1,'step'=>1, 'required'=>'required')) }}
                                    </div>
                                    <div class="clearfix"></div>
                                    {{Form::submit('Save', array('class'=>'btn btn-primary pull-right'))}}
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
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
        </div>
    </div>

@endsection
