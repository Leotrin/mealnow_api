<div class="card row">
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
