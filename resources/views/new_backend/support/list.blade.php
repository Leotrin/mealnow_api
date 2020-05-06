@extends('layouts.new_admin')

@section('head')
    <!-- BEGIN PLUGIN CSS -->
    <link href="{{ asset('assets/plugins/bootstrap-select2/select2.css') }}" rel="stylesheet" type="text/css" media="screen"/>
{{--    <link href="{{ asset('assets/plugins/jquery-datatable/css/jquery.dataTables.css') }}" rel="stylesheet" type="text/css"/>--}}
{{--    <link href="{{ asset('assets/plugins/datatables-responsive/css/datatables.responsive.css') }}" rel="stylesheet" type="text/css" media="screen"/>--}}
    <!-- END PLUGIN CSS -->
@endsection

@section('content')

    <style>
        .table-tools-actions {
            display: none !important;
        }
    </style>
    <div class="row-fluid" style="padding: 20px;">
        <div class="card">
            <div class="grid simple " style="padding: 10px;">
                <div class="grid-title">
                    <h5><a class="text-dark" data-toggle="collapse" href="#SupportAccordion" aria-expanded="true">New Support <span class="semi-bold">Request</span></a></h5>
                </div>
                <div  class="collapse hidden grid-body" id="SupportAccordion">
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
                            <div class="col-md-12 p10" >
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
                                <div class="col-md-12 p0" style="margin: 10px;">
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
        <div class="card">
            <h6 class="card-header">Support <span class="semi-bold">Tickets</span></h6>
            <div class="card-datatable table-responsive">
                <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
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