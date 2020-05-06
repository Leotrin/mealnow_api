@extends('layouts.admin')

@section('head')

    <!-- BEGIN PLUGIN CSS -->
    <link href="{{ asset('assets/plugins/bootstrap-select2/select2.css') }}" rel="stylesheet" type="text/css" media="screen"/>
    <!-- END PLUGIN CSS -->
@endsection

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>Group <span class="semi-bold">{{ $group->name }}</span> Permission</h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="grid-body ">
                    <div class="col-md-12" style="padding:0px;">
                        {{ Form::open(array('url' => '/admin/user/group/'.$group->id , 'method'=>'post', 'class'=>'col-md-4', 'style'=>'padding:10px;border:1px solid #ccc;')) }}
                            <h3>Add permission</h3>
                            <br />
                            {{ Form::select('function', $functions, null, array('class'=>'form-control')) }}
                            <br />
                            {{ Form::label('permission', 'Allowed', array('class' => 'awesome')) }}
                            {{ Form::checkbox('permission', null, false) }}
                            {{Form::submit('Save', array('class'=>'btn btn-primary pull-right'))}}
                        {{ Form::close() }}
                    </div>
                    <table class="table table-striped myTable" id="example1" >
                        <thead>
                        <tr>
                            <th>Function</th>
                            <th>Permission</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($group->roles as $role)
                            <tr class="odd gradeX">
                                <td><strong> {{ $role->function }} </strong></td>
                                <td><strong> {{ CD::perm($role->permission) }} </strong></td>
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
@endsection