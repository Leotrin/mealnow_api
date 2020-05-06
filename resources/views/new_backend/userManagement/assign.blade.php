@extends('layouts.new_admin')

@section('content')
    <div class="row-fluid" style="padding:15px;">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>Assign <span class="semi-bold">Permissions</span></h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="grid-body ">
                    <div class="col-md-12 p10">
                        <form action="{{ url('/admin/user/assign') }}" method="post">
                            {{csrf_field()}}
                            <table class="table table-responsive table-striped">
                                <thead>
                                <tr>
                                    <td>Permission</td>
                                    @foreach($permissions as $permission)
                                        <td>{{$permission->function_name}}</td>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($groups as $gr)
                                    <tr>
                                        <td>{{$gr->name}}</td>
                                        @foreach($permissions as $permission)
                                            <td>
                                                <input type="checkbox" name="{!! str_replace(' ','_',$gr->name) !!}_{!! str_replace(' ','_',$permission->function_name) !!}" value="1"
                                                       @foreach($gr->roles as $role)
                                                       @if($role->function == $permission->function_name && $role->permission==1)
                                                       checked
                                                        @endif
                                                        @endforeach
                                                />
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <br />
                            <div class="col-md-12 p0 text-right">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection