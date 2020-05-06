
<div class="row">
    <!-- 2nd row Start -->
    <div class="col-md-12">
        <div class="card d-flex w-100 mb-4">
            <div class="row no-gutters row-bordered row-border-light h-100">
                <div class="d-flex col-md-6 col-lg-3 align-items-center">
                    <div class="card-body">
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="lnr lnr-earth text-primary display-4"></i>
                            </div>
                            <div class="col">
                                <h6 class="mb-0 text-muted"><span class="text-primary">Unprocessed</span> orders</h6>
                                <h4 class="mt-3 mb-0">{{$unprocessedOrder}}</h4>
                            </div>
                        </div>
                        <a href="{{url('admin/order/unprocessed')}}" style="color:#a3a5b4;">
                            Unprocessed orders list
                        </a>
                    </div>
                </div>
                <div class="d-flex col-md-6 col-lg-3 align-items-center">
                    <div class="card-body">
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="lnr lnr-cart text-primary display-4"></i>
                            </div>
                            <div class="col">
                                <h6 class="mb-0 text-muted"><span class="text-primary">In process</span> orders</h6>
                                <h4 class="mt-3 mb-0">{{$inprocessOrder}}</h4>
                            </div>
                        </div>
                        <a href="{{url('admin/order/in_process')}}" style="color:#a3a5b4;">
                            In process orders list
                        </a>
                    </div>
                </div>
                <div class="d-flex col-md-6 col-lg-3 align-items-center">
                    <div class="card-body">
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="lnr lnr-indent-increase text-primary display-4"></i>
                            </div>
                            <div class="col">
                                <h6 class="mb-0 text-muted"><span class="text-primary">Not finished  </span>orders</h6>
                                <h4 class="mt-3 mb-0">{{$notFinished}}</h4>
                            </div>
                        </div>
                        <a href="{{url('admin/order/not_finished')}}" style="color:#a3a5b4;">
                            Not Finished or Rejected orders list
                        </a>
                    </div>
                </div>
                <div class="d-flex col-md-6 col-lg-3 align-items-center">
                    <div class="card-body">
                        <div class="row align-items-center mb-3">
                            <div class="col-auto">
                                <i class="lnr lnr-magic-wand text-primary display-4"></i>
                            </div>
                            <div class="col">
                                <h6 class="mb-0 text-muted"><span class="text-primary">Successfully finished </span>orders</h6>
                                <h4 class="mt-3 mb-0">{{$finished}}</h4>
                            </div>
                        </div>
                        <a href="{{url('admin/order/finished')}}" style="color:#a3a5b4;">
                            Finished orders list
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Staustic card 3 Start -->
    </div>
    <!-- 2nd row Start -->
</div>