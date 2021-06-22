@extends('backend')
@section('page_header')
    <h1 class="page-title">
        <i class="icon voyager-people"></i> Detail Batch {{ $batch->id }}
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
                                            Detail Batch {{ $batch->title }}
                                        </h3>
                                    </div>
                                    <div class="box-body pad">
                                        <table class="table table-bordered table-responsive">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    Title
                                                </td>
                                                <td>
                                                    {{ $batch->title }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Request Date
                                                </td>
                                                <td>
                                                    {{ $batch->request_date }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Created By
                                                </td>
                                                <td>
                                                    {{ $batch->created_by }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Status
                                                </td>
                                                <td>
                                                    {{ $batch->status }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Created
                                                </td>
                                                <td>
                                                    {{ $batch->created_at }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Updated
                                                </td>
                                                <td>
                                                    {{ $batch->updated_at }}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <hr/>
                                        <h3>
                                            List Order
                                        </h3>
                                        <p>
                                            Total {{ $batch->logistic_orders->count() }} Orders,
                                            Has Receipt Number {{ $batch->logistic_orders->where('receipt_number','<>','')->count() }}, Doesn't have receipt {{ $batch->logistic_orders->where('receipt_number','')->count() }}
                                        </p>
                                        <br/>
                                        <a href="{{ url('backend/logistic/form-csv') }}" class="btn btn-xs btn-primary">
                                            <i class="fa fa-upload"></i> Upload CSV From ORDER ONLINE
                                        </a>

                                        <a href="{{ url('backend/logistic/order-export-csv/' . $batch->id) }}" class="btn btn-xs btn-success">
                                            <i class="fa fa-download"></i> Download to Nina
                                        </a>

                                        <a href="{{ url('backend/logistic/form-ninja-csv') }}" class="btn btn-xs btn-default">
                                            <i class="fa fa-upload"></i> Upload CSV From Ninja
                                        </a>

                                        <a href="{{ url('backend/logistic/jurnal/push-list-batch/' . $batch->id) }}" class="btn btn-xs btn-primary">
                                            <i class="fa fa-upload"></i> Push Jurnal
                                        </a>

                                        <a href="{{ url('backend/logistic/export-excel?batch-id='.$batch->id) }}" class="btn btn-xs btn-default">
                                            <i class="fa fa-download"></i> Export to Excel
                                        </a>

                                        <a href="{{ url('backend/logistic/order-export-csv-order/' . $batch->id) }}" class="btn btn-xs btn-info">
                                            <i class="fa fa-download"></i> Download to ORDERONLINE
                                        </a>

                                        <a href="{{ url('backend/logistic/delete-batch/' . $batch->id) }}" class="btn delete btn-xs btn-danger">
                                            <i class="fa fa-trash"></i> Delete All
                                        </a>
                                        <hr/>

                                        <div class="table-responsive">

                                            <div class="box-body">
                                                {{ Form::open(['url' => url('backend/logistic/detail-batch/' . $batch->id), 'method' => 'get']) }}
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
                                                            <input type="text" class="form-control" value="{{ isset($filters['receipt_number']) ? $filters['receipt_number'] : "" }}" name="receipt_number"/>
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
                                                            <span class="input-group-addon">Resi?</span>
                                                            <select name="has_receipt" class="form-control">
                                                                <option value=""  {{ (!isset($filters['has_receipt']) OR $filters['has_receipt'] == '') ? "selected" : "" }}>All</option>
                                                                <option value="yes" {{ (isset($filters['has_receipt']) AND $filters['has_receipt'] == 'yes') ? "selected" : "" }}>Yes</option>
                                                                <option value="no" {{ (isset($filters['has_receipt']) AND $filters['has_receipt'] == 'no') ? "selected" : "" }}>No</option>
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
                                            <table class="table table-bordered table-responsive">
                                                <thead>
                                                <tr>
                                                    <th>order_id</th>
                                                    <th>batch_id</th>
                                                    <th>resi</th>
                                                    <th>product</th>
                                                    <th>notes</th>
                                                    <th>comments</th>
                                                    <th>gross_revenue</th>
                                                    <th>name</th>
                                                    <th>phone</th>
                                                    <th>address</th>
                                                    <th>province</th>
                                                    <th>city</th>
                                                    <th>subdistrict</th>
                                                    <th>zip</th>
                                                    <th>payment_status</th>
                                                    <th>quantity</th>
                                                    <th>status</th>
                                                    <th>bump_price</th>
                                                    <th>created_at</th>
                                                    <th>handled_by</th>
                                                    <th>variation</th>
                                                    <th>#</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($orders->toArray() as $key => $order)
                                                    <tr>
                                                        <td>
                                                            {{ $order['order_id'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['logistic_batch_id'] }}
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
                                                            {{ $order['notes'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['comments'] }}
                                                        </td>
                                                        <td>
                                                            {{ number_format($order['gross_revenue'], 0) }}
                                                        </td>
                                                        <td>
                                                            {{ $order['name'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['phone'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['full_address'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['province'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['city'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['subdistrict'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['zip'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['payment_method'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['quantity'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['logistic_status'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['bump_price'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['created_at'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['handled_by'] }}
                                                        </td>
                                                        <td>
                                                            {{ $order['variation'] }}
                                                        </td>
                                                        <td>
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
@stop
