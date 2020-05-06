<div class="col-md-12 p10 boxed hideBox" id="Msg">
    <h3 class="label label-success">Communication</h3>
    <br />
    <br />
    <div class="col-md-12 p10" style="background: #efefef;border:1px solid #ccc;">
        @foreach($ticketMessages as $msg)
            <div class="col-md-12 p10" style="border-left:1px solid #4778b5;margin-bottom:2px;">
                @if($msg->content != null)
                    <div class="col-md-12 p0">
                        <strong>{{ $msg->user->name }}</strong>
                        <br />
                        <p class="label label-info">{{ $msg->content }}</p>
                    </div>
                @elseif($msg->answer != null)
                    <div class="col-md-12 p0">
                        <strong>{{ $msg->user->name }}</strong>
                        <br />
                        <p class="label label-inverse">{{ $msg->answer }}</p>
                    </div>
                @endif
            </div>
            <div class="clearfix"></div>
        @endforeach
    </div>
    <div class="clearfix"></div>
    <br />
    <form action="{{ url('/admin/support/replay/'.$id) }}" method="post"
            style="padding:10px;background:#efefef;border:1px solid #ccc;">
        {{csrf_field()}}
        <input type="hidden" name="subject" value="{{$ticket->subject}}" />
        <div class="col-md-12 p0">
            <textarea name="msg" class="form-control" required style="max-width:100%;min-width:100%;min-height:120px;"></textarea>
        </div>
        <div class="clearfix"></div>
        <br />
        <div class="col-md-12 text-right p0">
            <button class="btn btn-primary" >Send</button>
        </div>
        <div class="clearfix"></div>
    </form>

    <div class="clearfix"></div>
</div>