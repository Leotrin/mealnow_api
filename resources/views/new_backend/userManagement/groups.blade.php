@extends('layouts.new_admin')


@section('content')
    <div class="row-fluid" style="padding: 15px;">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>Group <span class="semi-bold">management</span></h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="grid-body ">

                    <div class="col-md-12" style="padding:0px;">
                        @if(isset($group))
                            {{ Form::model($group, array('url' => '/admin/user/groups/edit/'.$group->id , 'method'=>'post', 'class'=>'col-md-4', 'style'=>'padding:10px;border:1px solid #ccc;')) }}
                        @else
                            {{ Form::open(array('url' => '/admin/user/groups' , 'method'=>'post', 'class'=>'col-md-4', 'style'=>'padding:10px;border:1px solid #ccc;')) }}
                            <h3>Create Group</h3>
                        @endif
                        <br />
                        {{ Form::text('name', null, array('class'=>'form-control','placeholder'=>'Group name')) }}
                        <br />
                        {{ Form::label('status', 'Active', array('class' => 'awesome')) }}
                        {{ Form::checkbox('status', null) }}

                        {{Form::submit('Save', array('class'=>'btn btn-primary pull-right'))}}
                        {{ Form::close() }}
                    </div>
                    <div class="clearfix"></div>
                    <hr />
                    <table class="table table-striped myTable" id="example2" >
                        <thead>
                        <tr>
                            <th>Group Name</th>
                            <th>Status</th>
                            <th>Options</th>
                            <th style="display: none;"></th>
                            <th style="display: none;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($groups as $item)
                            <tr class="odd gradeX">
                                <td>{{ $item->name }}</td>
                                <td class="center">{{ CD::status($item->status) }}</td>
                                <td class="center">
                                    <a href="{{ url('/admin/user/assign') }}" class="btn btn-warning">
                                        <i class="fa fa-unlock-alt fa-lg"></i>
                                    </a>
                                    <a href="{{ url('/admin/user/groups/edit/'.$item->id) }}" class="btn btn-info">
                                        <i class="fa fa-pencil-alt fa-lg"></i>
                                    </a>
                                    <a href="{{ url('/admin/user/groups/delete/'.$item->id) }}" class="btn btn-danger">
                                        <i class="fa fa-trash fa-lg"></i>
                                    </a>
                                </td>
                                <td style="display: none;">
                                    @foreach($item->roles as $role)
                                        <p>
                                            <strong> {{ $role->function }} </strong>
                                            - {{ CD::perm($role->permission) }}
                                        </p>
                                    @endforeach
                                </td>
                                <td style="display: none;"></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
