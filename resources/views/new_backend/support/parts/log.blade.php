<div class="col-md-12 p10 boxed hideBox" id="Log">
    <h3 class="label label-success">Action Protocol</h3>
    <br />
    <div class="col-md-12 p10">
        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <td>Changed at</td>
                    <td>Change Time</td>
                    <td>Changed by</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach($protocols as $protocol)
                    <tr>
                        <td>
                            {!! date('l', strtotime($protocol->created_at)) !!}
                        </td>
                        <td>
                            {!! date('H:i', strtotime($protocol->created_at)) !!}
                        </td>
                        <td>
                            {!! $protocol->user->name !!}
                        </td>
                        <td>
                            {!! $protocol->action !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="clearfix"></div>
</div>