@extends('layouts.admin')

@section('head')

    <!-- BEGIN PLUGIN CSS -->
    <link href="{{ asset('assets/plugins/bootstrap-select2/select2.css') }}" rel="stylesheet" type="text/css" media="screen"/>
    <link href="{{ asset('assets/plugins/jquery-datatable/css/jquery.dataTables.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/datatables-responsive/css/datatables.responsive.css') }}" rel="stylesheet" type="text/css" media="screen"/>
    <!-- END PLUGIN CSS -->
@endsection

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>Group <span class="semi-bold">Functions</span> - Permissions</h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="grid-body ">
                    <div class="col-md-12" style="padding:0px;">
                        {{ Form::open(array('url' => '/admin/user/groups/function' , 'method'=>'post', 'class'=>'col-md-4', 'style'=>'padding:10px;border:1px solid #ccc;')) }}
                            <h3>Add permission</h3>
                            <br />
                            {{ Form::text('function', null, array('class'=>'form-control')) }}
                            <br />
                            {{Form::submit('Save', array('class'=>'btn btn-primary pull-right'))}}
                        {{ Form::close() }}
                    </div>
                    <table class="table table-striped" id="example1" >
                        <thead>
                        <tr>
                            <th>Function Name</th>
                            <th>Option</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($permissions as $item)
                            <tr class="odd gradeX">
                                <td><strong> {{ $item->function_name }} </strong></td>
                                <td>
                                    <a href="{{ url('admin/user/groups/function/'.$item->id.'/delete') }}" class="btn btn-danger">
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

@section('footer')
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="{{ asset('assets/plugins/jquery-block-ui/jqueryblockui.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap-select2/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/js/jquery.dataTables.min.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extra/js/dataTables.tableTools.min.js') }}" type="text/javascript" ></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/datatables-responsive/js/datatables.responsive.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/datatables-responsive/js/lodash.min.js') }}"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <script src="{{ asset('assets/js/datatables.js') }}" type="text/javascript"></script>
@endsection