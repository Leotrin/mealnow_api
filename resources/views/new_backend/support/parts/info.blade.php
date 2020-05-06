<div class="col-md-12 p10 boxed" id="Info">
    <h3 class="label label-success">Last Informations and responses</h3>
    <br />
    <div class="col-md-6 p0">
        <h4>
            {{ $ticket->subject }} {{ $ticket->id }}
            <br />
            <small>{{ $ticket->created_at }}</small>
        </h4>
    </div>
    <div class="col-md-12 p0">
        @if($ticket->content!=null)
            <h5>{{ $ticket->content }}</h5>
        @elseif($ticket->answer!=null)
            <h5>{{ $ticket->answer }}</h5>
        @endif
    </div>
    <div class="clearfix"></div>
    <hr />
    <strong>{!! CD::statusTicket($ticket->status) !!} </strong>
    @if($ticket->status != 2)
        <a href="{{ url('client/'.$id.'/support/'.$ticket->id.'/complete') }}" class="btn btn-success pull-right">Complete</a>
    @endif
</div>