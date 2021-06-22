@extends('backend')
@section('page_header')
    <h1 class="page-title">
        <i class="icon voyager-people"></i> Order List
    </h1>
@stop
@section('js')
    <script>
        $(document).ready(function () {
            $('.update-receipt').on('click', function (e) {
                e.preventDefault();

                $('#order-id').val($(this).data('id'));
                $('#receipt-number').val($(this).data('receipt_number'));
                $('#form-receipt').modal('toggle');
            });
        });
    </script>
@endsection
@section('main')
    <div class="page-content container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-info">
                                    <div class="box-header">
                                        <h3 class="box-title">
                                            Orders List
                                        </h3>
                                        <br/>

                                        <a href="{{ url('backend/logistic/reconciliation-form-ninja-csv') }}" class="btn btn-xs btn-primary">
                                            <i class="fa fa-upload"></i> Upload Reconciliation CSV From Ninja
                                        </a>

                                        <a href="{{ url('backend/logistic/form-bulk-receipt') }}" class="btn btn-xs btn-success">
                                            <i class="fa fa-upload"></i> Find Order by Receipt Bulk
                                        </a>

                                        @if(Session::has('status'))
                                            <p class="alert alert-{{ Session::get('alert-class', 'info') }}">{{ Session::get('status') }}</p>
                                        @endif
                                    </div>

                                    <div class="box-body">
                                        {{ Form::open(['url' => url('backend/logistic/orders'), 'method' => 'get']) }}
                                        <div class="row gutter-10">
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Order ID</span>
                                                    <input type="text" class="form-control" value="{{ isset($filters['order_id']) ? $filters['order_id'] : "" }}" name="order_id"/>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Receipt No</span>
                                                    <input type="text" class="form-control" value="{{ isset($filters['receipt']) ? $filters['receipt'] : "" }}" name="receipt"/>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Name</span>
                                                    <input type="text" class="form-control" value="{{ isset($filters['name']) ? $filters['name'] : "" }}" name="name"/>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Phone</span>
                                                    <input type="text" class="form-control" value="{{ isset($filters['phone']) ? $filters['phone'] : "" }}" name="phone"/>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon">CS</span>
                                                    <input type="text" class="form-control" value="{{ isset($filters['handled_by']) ? $filters['handled_by'] : "" }}" name="handled_by"/>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Status Not In</span>
                                                    <input type="text" class="form-control" value="{{ isset($filters['logistic_status_not']) ? $filters['logistic_status_not'] : "" }}" name="logistic_status_not"/>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Status In</span>
                                                    <input type="text" class="form-control" value="{{ isset($filters['logistic_status']) ? $filters['logistic_status'] : "" }}" name="logistic_status"/>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Resi?</span>
                                                    <select name="receipt_number" class="form-control">
                                                        <option value=""  {{ (!isset($filters['receipt_number']) OR $filters['receipt_number'] == '') ? "selected" : "" }}>All</option>
                                                        <option value="yes" {{ (isset($filters['receipt_number']) AND $filters['receipt_number'] == 'yes') ? "selected" : "" }}>Yes</option>
                                                        <option value="no" {{ (isset($filters['receipt_number']) AND $filters['receipt_number'] == 'no') ? "selected" : "" }}>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Have Status?</span>
                                                    <select name="have_status" class="form-control">
                                                        <option value=""  {{ (!isset($filters['have_status']) OR $filters['have_status'] == '') ? "selected" : "" }}>All</option>
                                                        <option value="yes" {{ (isset($filters['have_status']) AND $filters['have_status'] == 'yes') ? "selected" : "" }}>Yes</option>
                                                        <option value="no" {{ (isset($filters['have_status']) AND $filters['have_status'] == 'no') ? "selected" : "" }}>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 pull-right">
                                                <div class="pull-right input-group">
                                                    <button type="submit" class="btn btn-primary">Search</button>
                                                </div>
                                            </div>
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                                    <div class="box-body pad">
                                        <div class="table-responsive">

                                            <table class="table table-bordered table-responsive">
                                                <thead>
                                                <tr>
                                                    <th>order_id</th>
                                                    <th>batch_id</th>
                                                    <th>resi</th>
                                                    <th>product</th>
                                                    <th>comments</th>
                                                    <th>gross_revenue</th>
                                                    <th>name</th>
                                                    <th>Address</th>
                                                    <th>quantity</th>
                                                    <th>status</th>
                                                    <th>created_at</th>
                                                    <th>handled_by</th>
                                                    <th>#</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($orders as $key => $order)
                                                    @php
                                                        $order  = $order->toArray()
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <a href="{{ url('backend/logistic/order-detail/' . $order['id']) }}" class="btn btn-xs btn-primary">
                                                                <i class="fa fa-search"></i> {{ $order['order_id'] }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            {{ $order['logistic_batch_id'] }} {{ $order['logistic_batch']['request_date'] }}
                                                        </td>
                                                        <td>
                                                            <a target="_blank" href="{{ 'https://www.ninjaxpress.co/en-id/tracking?id=' . $order['receipt_number'] }}">
                                                                {{ $order['receipt_number'] }}
                                                            </a>
                                                            <button data-id="{{ $order['id'] }}" data-receipt_number="{{ $order['receipt_number'] }}" class="btn btn-xs btn-warning update-receipt">
                                                                Update
                                                            </button>
                                                        </td>
                                                        <td>
                                                            {{ $order['product_name'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['comments'] }}
                                                        </td>
                                                        <td>
                                                            {{ number_format($order['gross_revenue'], 0) }}
                                                        </td>
                                                        <td>
                                                            {{ $order['name'] }}
                                                            {{ $order['phone'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['city'] }}
                                                            {{ $order['full_address'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['quantity'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['logistic_status'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['created_at'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['handled_by'] }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ url('backend/logistic/order-detail/' . $order['id']) }}" class="btn btn-xs btn-primary">
                                                                <i class="fa fa-search"></i> Detail
                                                            </a>
                                                            <a href="{{ url('backend/logistic/order-form/' . $order['id']) }}" class="btn btn-xs btn-warning">
                                                                <i class="fa fa-pencil"></i> Edit
                                                            </a>
                                                            <a href="{{ url('backend/logistic/order-delete/' . $order['id']) }}" class="btn btn-xs btn-danger delete">
                                                                <i class="fa fa-trash"></i> Delete
                                                            </a>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>

                                            <div class="text-center">
                                                @if(isset($orders))
                                                    {!! $orders->appends(Input::except('page'))->links() !!}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="form-receipt" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Modal Header</h4>
                            </div>
                            <div class="modal-body">
                                {{ Form::open(['url' => url('backend/logistic/update-receipt'),'method' => 'post','files' => true]) }}

                                <input type="hidden" id="order-id" name="id" class="form-control" value="">
                                <div class="form-group{{ $errors->has('receipt_number') ? ' has-error' : '' }}">
                                    <label for="receipt_number">Title</label>
                                    <input type="text" id="receipt-number" name="receipt_number" class="form-control" required>
                                    @if($errors->has('receipt_number'))
                                        <p class="help-block">{{ $errors->first('receipt_number') }}</p>
                                    @endif
                                </div>
                                <div class="box-footer pull-right">
                                    <button type="submit" class="btn btn-success confirm">Save</button>
                                </div>
                                {{ Form::close() }}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
