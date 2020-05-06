@extends('layouts.admin')

@section('head')
    <!-- BEGIN PLUGIN CSS -->
    <link href="{{ asset('assets/plugins/bootstrap-select2/select2.css') }}" rel="stylesheet" type="text/css" media="screen"/>
    <link href="{{ asset('assets/plugins/jquery-datatable/css/jquery.dataTables.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/datatables-responsive/css/datatables.responsive.css') }}" rel="stylesheet" type="text/css" media="screen"/>
    <!-- END PLUGIN CSS -->
@endsection

@section('content')

    <style>
        .table-tools-actions {
            display: none !important;
        }
    </style>
    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>New Support <span class="semi-bold">Request</span></h4>
                    <div class="tools">
                        <a href="javascript:;" class="expand"></a>
                    </div>
                </div>
                <div class="grid-body" style="display: none;">
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
                            <div class="col-md-12 p10">
                                <label>To User</label>
                                <select name="to_user" class="form-control">
                                    <option value="0">All</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 p10">
                                <label>Subject</label>
                                <input type="text" name="subject" id="subject" value="" required class="form-control"/>
                            </div>
                            <div class="col-md-12 p10">
                                <label>Content</label>
                                <textarea name="content" required class="form-control"></textarea>
                            </div>
                            <div class="col-md-12 p10">
                                <div class="col-md-2 p0">
                                    <label>&nbsp;</label>
                                    <button type="button" onclick="addPriority('Low')" class="btn btn-info">Low</button>
                                    <button type="button" onclick="addPriority('Medium')" class="btn btn-primary">Medium</button>
                                    <button type="button" onclick="addPriority('High')" class="btn btn-danger">High</button>
                                </div>
                                <div class="col-md-4 p0">
                                    <label>Priority</label>
                                    <input type="text" name="priority" id="priority" value="" readonly required class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-12 p10 text-right">
                                <input type="hidden" name="filesToDelete" id="filesToDelete" />
                                <hr />
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    <h4>Support <span class="semi-bold">Tickets</span></h4>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"></a>
                    </div>
                </div>
                <div class="grid-body ">
                    <table class="table table-striped dataTableExample">
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
    <script src="{{ asset('assets/plugins/jquery-datatable/js/jquery.dataTables.min.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('assets/plugins/jquery-datatable/extra/js/dataTables.tableTools.min.js') }}" type="text/javascript" ></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/datatables-responsive/js/datatables.responsive.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/datatables-responsive/js/lodash.min.js') }}"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <script src="{{ asset('assets/js/datatables.js') }}" type="text/javascript"></script>
    <script>

        function addPriority(topic){
            $('#priority').val(topic);
        }
    </script>
@endsection