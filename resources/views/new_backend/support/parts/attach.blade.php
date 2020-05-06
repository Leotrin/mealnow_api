<div class="col-md-12 p10 boxed hideBox" id="Attach">
    <h3 class="label label-success">Attachments</h3>
    <br />
    <div class="col-md-12 p10">
        <?php
            $filesPdf = json_decode($ticketFiles->files);
        ?>
        @foreach($filesPdf as $file)
            <p class="text text-primary">
                <i class="fa fa-circle"></i>
                <a href="{{ url('tickets/'.$ticketFiles->id.'/'.$file) }}" target="_blank">{{ $file }}</a>
            </p>
        @endforeach
    </div>
</div>