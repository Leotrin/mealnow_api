@extends('layouts.admin')


@section('content')
    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>User <span class="semi-bold">manangement</span></h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
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

                        @if(isset($user))
                            {{ Form::model($user, array('url' => '/admin/users/edit/'.$user->id , 'method'=>'post', 'class'=>'col-md-4', 'style'=>'padding:10px;border:1px solid #ccc;')) }}
                            <h3>Edit User</h3>
                        @else
                            {{ Form::open(array('url' => '/admin/users/add' , 'method'=>'post', 'class'=>'col-md-4', 'style'=>'padding:10px;border:1px solid #ccc;')) }}
                            <h3>Register User or Company </h3>
                        @endif
                            <br />
                            {{ Form::text('name', null, array('class'=>'form-control', 'placeholder'=>'Full name', 'required'=>'required')) }}
                            <br />
                            {{ Form::text('username', null, array('class'=>'form-control', 'placeholder'=>'Username or Company Name', 'required'=>'required')) }}
                            <br />
                            {{ Form::email('email', null, array('class'=>'form-control', 'placeholder'=>'E-Mail Address', 'required'=>'required')) }}
                            <br />
                            @if(!isset($user))
                                {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password', 'required'=>'required')) }}
                                <br />
                            @endif
                            {{ Form::select('gender', [null=>'Select Gender', '1'=>'Male', '2'=>'Female'], null, array('class'=>'form-control')) }}
                            <br />
                            {{ Form::date('birthday', null, array('class'=>'form-control', 'placeholder'=>'Birthday', 'required'=>'required')) }}
                            <br />
                            {{ Form::text('city', null, array('class'=>'form-control', 'placeholder'=>'City', 'required'=>'required')) }}
                            <br />
                            {{ Form::text('address', null, array('class'=>'form-control', 'placeholder'=>'Address', 'required'=>'required')) }}
                            <br />
                            {{ Form::text('zip', null, array('class'=>'form-control', 'placeholder'=>'Zip', 'required'=>'required')) }}
                            <br />
                            {{ Form::text('tel', null, array('class'=>'form-control', 'placeholder'=>'Tel', 'required'=>'required')) }}
                            <br />
                            {{ Form::select('group_id', $groups, null, array('class'=>'form-control')) }}
                            <br />
                        {{Form::submit('Save', array('class'=>'btn btn-primary pull-right'))}}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>User <span class="semi-bold">list</span></h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="grid-body ">
                    <table class="table table-striped" id="example2" >
                        <thead>
                        <tr>
                            <th>User</th>
                            <th>E-Mail</th>
                            <th>User type</th>
                            <th>Status</th>
                            <th>Options</th>
                            <th style="display: none;"></th>
                            <th style="display: none;"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $item)
                                <tr class="odd gradeX">
                                    <td>{{ $item->id }} - {{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->group->name }}</td>
                                    <td class="center">{{ CD::status($item->status) }}</td>
                                    <td class="center">
                                        <a href="{{ url('/admin/users/edit/'.$item->id) }}" class="btn btn-info">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="{{ url('/admin/users/delete/'.$item->id) }}" class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>

                                        <span class="btn btn-warning myTippy" data-toggle="modal" title="Change Password" data-target="#changePass{{$item->id}}">
                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                        </span>
                                        <div class="modal fade" id="changePass{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Change Password</h4>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <form action="{{url('admin/user/'.$item->id.'/change_password')}}" method="post">
                                                            {{csrf_field()}}
                                                            <label>New Password</label>
                                                            <input type="password" name="password" placeholder="*******************" class="form-control" required/>
                                                            <br />
                                                            <label>Confirm Password</label>
                                                            <input type="password" name="password_confirmation" placeholder="*******************" class="form-control" required/>
                                                            <br />
                                                            <br />
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Change</button>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    <td style="display: none;">
                                        Address : {{ $item->address }}, {{ $item->zip }} {{ $item->city }}
                                    </td>
                                    <td style="display: none;">
                                        Contact : {{ CD::gender($item->gender) }}- {{ $item->tel }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>Inactive <span class="semi-bold">Users</span></h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="grid-body ">
                    <table class="table table-striped" id="example2" >
                        <thead>
                        <tr>
                            <th>User</th>
                            <th>E-Mail</th>
                            <th>User type</th>
                            <th>Status</th>
                            <th>Options</th>
                            <th style="display: none;"></th>
                            <th style="display: none;"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($inActiveUsers as $item)
                                <tr class="odd gradeX">
                                    <td>{{ $item->id }} - {{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->group->name }}</td>
                                    <td class="center">{{ CD::status($item->status) }}</td>
                                    <td class="center">
                                        <a href="{{ url('/admin/users/edit/'.$item->id) }}" class="btn btn-info">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="{{ url('/admin/users/activate/'.$item->id) }}" class="btn btn-success">
                                            <i class="fa fa-check"></i>
                                        </a>

                                        <span class="btn btn-warning myTippy" data-toggle="modal" title="Change Password" data-target="#changePass{{$item->id}}">
                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                        </span>
                                        <div class="modal fade" id="changePass{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Change Password</h4>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <form action="{{url('admin/user/'.$item->id.'/change_password')}}" method="post">
                                                            {{csrf_field()}}
                                                            <label>New Password</label>
                                                            <input type="password" name="password" placeholder="*******************" class="form-control" required/>
                                                            <br />
                                                            <label>Confirm Password</label>
                                                            <input type="password" name="password_confirmation" placeholder="*******************" class="form-control" required/>
                                                            <br />
                                                            <br />
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Change</button>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    <td style="display: none;">
                                        Address : {{ $item->address }}, {{ $item->zip }} {{ $item->city }}
                                    </td>
                                    <td style="display: none;">
                                        Contact : {{ CD::gender($item->gender) }}- {{ $item->tel }}
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
