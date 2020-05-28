@extends('layouts.new_admin')

@section('head')
    <link href="{{ asset('assets/plugins/bootstrap-select2/select2.css') }}" rel="stylesheet" type="text/css" media="screen"/>
@endsection

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-0">Support Tickets</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{!! url('/') !!}"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item" >Support Tickets</li>
            </ol>
        </div>

        <div id="accordion2">
            <div class="card mb-2">
                <div class="card-header">
                    <a class="d-flex justify-content-between text-dark btn btn-default" data-toggle="collapse" aria-expanded="false" href="#accordion2-1"> <span><i class="fa fa-plus"></i>Add Support Ticket</span><div class="collapse-icon"></div></a>
                </div>

                <div id="accordion2-1" class="collapse" data-parent="#accordion2">
                    <div class="card-body">
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
                            <form action="{{ url('admin/support') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-12 p10 form-group" >
                                        <label class="form-label">To User</label>
                                        <select name="to_user" class="form-control">
                                            <option value="0">All</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 p10 form-group">
                                        <label class="form-label">Subject</label>
                                        <input type="text" name="subject" id="subject" value="" required class="form-control"/>
                                    </div>
                                    <div class="col-12 p10 form-group">
                                        <label class="form-label">Content</label>
                                        <textarea name="content" required class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-12 p10 form-group">

                                        <div class="col-md-4 p0 form-group">
                                            <label class="form-label">Priority</label>
                                            <input type="text" name="priority" id="priority" onkeydown="return false;" value="" readonly required class="form-control"/>
                                        </div>
                                        <div class="col-md-12 p0" style="margin: 10px;">
                                            <label class="form-label">&nbsp;</label>
                                            <button type="button" onclick="addPriority('Low')" class="btn btn-info">Low</button>
                                            <button type="button" onclick="addPriority('Medium')" class="btn btn-primary">Medium</button>
                                            <button type="button" onclick="addPriority('High')" class="btn btn-danger">High</button>
                                        </div>
                                    </div>
                                    <div class="col-md-12 p10 text-right">
                                        <input type="hidden" name="filesToDelete" id="filesToDelete" />
                                        <hr />
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <h6 class="card-header">Tickets List</h6>
            <div class="card-body">
                <div class="card-datatable table-responsive">
                    <table class="table  myTable" id="DataTables_Table_1" role="grid" >
                        <thead>
                        <tr>
                            <th>Client</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th class="center"><i class="fa fa-search"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($tickets->count() > 0)
                            @foreach($tickets as $item)
                                <tr class="odd gradeX">
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->subject }} {{ $item->id }}</td>
                                    <td>{!! CD::statusTicket($item->status) !!} </td>
                                    <td class="center">
                                        <a href="{{ url('admin/support/view/'.$item->id) }}" class="btn btn-primary">
                                            <i class="fa fa-search"></i>
                                        </a>
                                        @if($item->status == 0)
                                            <span class="btn btn-info" data-toggle="modal" data-target="#ticket{{$item->id}}">
                                    <i class="fa fa-reply" aria-hidden="true"></i>
                                </span>
                                            <div class="modal fade" id="ticket{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">Answer</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ url('/admin/support/replay/'.$item->id) }}" method="post">
                                                                {{ csrf_field() }}
                                                                <label>Replay message</label>
                                                                <textarea name="replay" class="form-control" style="min-height:300px;max-height:500px;min-width:100%;max-width:100%;"></textarea>
                                                                <hr />
                                                                <button type="submit" name="submit" class="btn btn-success">Answer</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
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

@section('footer')
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="{{ asset('assets/plugins/jquery-block-ui/jqueryblockui.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap-select2/select2.min.js') }}" type="text/javascript"></script>
    <script>

        function addPriority(topic){
            $('#priority').val(topic);
        }
    </script>
@endsection
