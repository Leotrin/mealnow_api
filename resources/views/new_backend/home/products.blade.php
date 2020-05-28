@extends('layouts.new_admin')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-0">Home Products</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{!! url('/') !!}"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item" >Home Products</li>
            </ol>
        </div>
        <div id="accordion2">
            <div class="card mb-2">
                <div class="card-header">
                    <a class="d-flex justify-content-between text-dark btn btn-default collapsed" data-toggle="collapse" aria-expanded="false" href="#accordion2-1"><span><i class="fa fa-plus"></i> Add New Home Product</span><div class="collapse-icon"></div></a>
                </div>

                <div id="accordion2-1" class="collapse" data-parent="#accordion2">
                    <div class="card-body">
                        <div class="row" style="padding:10px;">
                            {{ Form::open(array('url' => '/admin/home/products' , 'method'=>'post', 'class'=>'col-md-6 col-md-offset-3', 'style'=>'padding:10px;border:1px solid #ccc;','enctype'=>'multipart/form-data')) }}

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <h4>Register new home product </h4>
                            <div class="row">
                                <div class="col-md-8 col-sm-8 p0">
                                    <label class="form-label">Select Shop </label>
                                    <select name="shop_id" class="form-control" required>
                                        <option value="">Select a shop</option>
                                        @foreach($shops as $shop)
                                            <option value="{{$shop->id}}">{{$shop->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-8 p0">
                                    <label class="form-label">Product name <small>title</small></label>
                                    <input type="text" class="form-control" required name="name"/>
                                </div>
                                <div class="col-sm-4 p0">
                                    <label class="form-label">Price</label>
                                    <input type="number" class="form-control" required name="price"/>
                                </div>

                                <div class=" col-sm-8 p0">
                                    <label class="form-label">Product feature image</label>
                                    <input type="file" name="image" required />
                                </div>
                            </div>
                            <div class="col-md-12 text-right" style="padding-top:10px;">
                                {{Form::submit('Save', array('class'=>'btn btn-primary'))}}
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="card">
            <h6 class="card-header">Products List</h6>
            <div class="card-body">
                <div class="card-datatable table-responsive">
                    <table class="table table-striped myTable" id="DataTables_Table_1" role="grid" >
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Shop</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $item)
                            <tr class="odd gradeX">
                                <td><img src="{{ $item->image }}" style="width:35px;" /></td>
                                <td>{{ $item->name }} - <small>{{ $item->price }} $</small></td>
                                <td>{{ $item->shop->name }}</td>
                                <td class="center">
                                    @if($item->status==1)
                                        <a href="{{ url('/admin/home/product/deactivate/'.$item->id) }}" class="btn btn-danger">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    @else
                                        <a href="{{ url('/admin/home/product/activate/'.$item->id) }}" class="btn btn-success">
                                            <i class="fa fa-check"></i>
                                        </a>
                                    @endif
                                    <a href="{{ url('/admin/home/product/delete/'.$item->id) }}" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
