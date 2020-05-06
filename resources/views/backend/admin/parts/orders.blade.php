<div class="row 2col">
    <div class="col-md-3 col-sm-6 spacing-bottom-sm spacing-bottom">
        <div class="tiles blue added-margin">
            <div class="tiles-body">
                <div class="controller">
                    <a href="javascript:;" class="reload"></a>
                </div>
                <div class="tiles-title"> Unprocessed orders</div>
                <div class="heading">
                    <span class="animate-number"
                          data-value="{{$unprocessedOrder}}"
                          data-animation-duration="1200">
                        {{$unprocessedOrder}}
                    </span>
                </div>
                <div class="progress transparent progress-small no-radius">
                    <div class="progress-bar progress-bar-white animate-progress-bar"
                         data-percentage="{{$unprocessedOrder}}%">
                    </div>
                </div>
                <div class="description">
                    <i class="icon-custom-up"></i>
                    <span class="text-white mini-description">&nbsp;
                        <a href="{{url('admin/order/unprocessed')}}" style="color:#fff;">
                            Unprocessed orders list
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 spacing-bottom-sm spacing-bottom">
        <div class="tiles green added-margin">
            <div class="tiles-body">
                <div class="controller">
                    <a href="javascript:;" class="reload"></a>
                </div>
                <div class="tiles-title"> In process orders </div>
                <div class="heading">
                    <span class="animate-number"
                          data-value="{{$inprocessOrder}}"
                          data-animation-duration="1200">
                        {{$inprocessOrder}}
                    </span>
                </div>
                <div class="progress transparent progress-small no-radius">
                    <div class="progress-bar progress-bar-white animate-progress-bar"
                         data-percentage="{{$inprocessOrder}}%">
                    </div>
                </div>
                <div class="description">
                    <i class="icon-custom-up"></i>
                    <span class="text-white mini-description">&nbsp;
                        <a href="{{url('admin/order/in_process')}}" style="color:#fff;">
                            In process orders list
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="tiles red added-margin">
            <div class="tiles-body">
                <div class="controller">
                    <a href="javascript:;" class="reload"></a>
                </div>
                <div class="tiles-title"> Not finished orders </div>
                <div class="row-fluid">
                    <div class="heading">
                        <span class="animate-number"
                              data-value="{{$notFinished}}"
                              data-animation-duration="1200">
                            {{$notFinished}}
                        </span>
                    </div>
                    <div class="progress transparent progress-white progress-small no-radius">
                        <div class="progress-bar progress-bar-white animate-progress-bar"
                             data-percentage="{{$notFinished}}%">
                        </div>
                    </div>
                </div>
                <div class="description">
                    <i class="icon-custom-up"></i>
                    <span class="text-white mini-description">&nbsp;
                        <a href="{{url('admin/order/not_finished')}}" style="color:#fff;">
                            Not Finished or Rejected orders list
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 spacing-bottom">
        <div class="tiles purple added-margin">
            <div class="tiles-body">
                <div class="controller">
                    <a href="javascript:;" class="reload"></a>
                </div>
                <div class="tiles-title"> Successfully finished orders </div>
                <div class="heading">
                    <span class="animate-number"
                          data-value="{{$finished}}"
                          data-animation-duration="1200">
                        {{$finished}}
                    </span>
                </div>
                <div class="progress transparent progress-white progress-small no-radius">
                    <div class="progress-bar progress-bar-white animate-progress-bar"
                         data-percentage="{{$finished}}%">
                    </div>
                </div>
                <div class="description">
                    <i class="icon-custom-up"></i>
                    <span class="text-white mini-description">&nbsp;
                        <a href="{{url('admin/order/finished')}}" style="color:#fff;">
                            Finished orders list
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>