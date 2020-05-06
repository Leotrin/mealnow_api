
<div class="span12">
    <div class="grid simple ">
        <div class="grid-title">
            <h4>Contact <span class="semi-bold">Method</span></h4>
            <div class="tools">
                @if(isset($contact_method))
                    <a href="javascript:;" class="collapse"></a>
                @else
                    <button type="button" href="javascript:;" class="btn btn-success btn-small expand">
                        Add New
                    </button>
                @endif
            </div>
        </div>
        <div class="grid-body" @if(!isset($contact_method)) style="display: none;" @endif>
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

                @if(isset($contact_method))
                    {{ Form::model($contact_method, array('url' => 'admin/shop/'.$shop->id.'/contact_methods/edit/'.$contact_method->id , 'method'=>'post', 'class'=>'col-md-12', 'style'=>'padding:10px;border:1px solid #ccc;', 'enctype'=>'multipart/form-data')) }}
                    <div class="col-md-4">
                        <h3>Edit Contact Method</h3>
                    </div>
                    <div class="clearfix"></div>
                @else
                    {{ Form::open(array('url' => 'admin/shop/'.$shop->id.'/contact_methods' , 'method'=>'post', 'class'=>'col-md-12', 'style'=>'padding:10px;border:1px solid #ccc;', 'enctype'=>'multipart/form-data')) }}
                    <h3>Register Contact Method</h3>
                @endif

                <div class="col-md-4 p10">
                    <label>Method</label>
                    {{ Form::select('method', ['email'=>'E-Mail','sms'=>'SMS','fax'=>'Fax','phone'=>'Phone Call'], null, array('class'=>'form-control', 'required'=>'required')) }}
                </div>
                <div class="col-md-4 p10">
                    <label>Contact</label>
                    {{ Form::text('contact', null, array('class'=>'form-control', 'placeholder'=>'Enter : Email, SMS, Fax or Phone number', 'required'=>'required')) }}
                </div>
                    <div class="col-md-4 p10">
                        <label>Priority</label>
                        {{ Form::number('priority', null, array('class'=>'form-control', 'min'=>1,'step'=>1, 'required'=>'required')) }}
                    </div>
                <div class="clearfix"></div>
                {{Form::submit('Save', array('class'=>'btn btn-primary pull-right'))}}
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>