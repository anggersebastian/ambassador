@extends('backend')
@section('page_header')
    <h1 class="page-title">
        <i class="icon voyager-people"></i> Form Result Order
    </h1>
@stop
@section('css')
    <style>
        input.form-control {
            width: auto;
        }
    </style>
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
                                            Form Result Order Temporary
                                        </h3>
                                    </div>
                                    {{ Form::open(['url' => url('backend/logistic/save-order-csv/' . (isset($batch) ? $batch->id : '')),'method' => 'post','files' => true]) }}
                                    <div class="box-body pad table-responsive">

                                        @if(Session::has('status'))
                                            <p class="alert alert-{{ Session::get('alert-class', 'info') }}">{{ Session::get('status') }}</p>
                                        @endif

                                        <input type="hidden" name="orders" value="{{ json_encode($orders) }}">
                                        <table class="table table-bordered table-striped table-highlight">
                                            <thead>
                                                <th>No</th>
                                                @foreach($orders[0] as $key => $value)
                                                    <th>{{ $key }}</th>
                                                @endforeach
                                            </thead>
                                            <tbody>
                                            @foreach($orders as $key => $order)
                                                <tr>
                                                    <td>
                                                        {{ $key+1 }}
                                                    </td>
                                                    <td>
                                                        {{ $order['order_id'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['product'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['name'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['email'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['phone'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['address'] }}
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
                                                        {{ $order['status'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['payment_status'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['payment_method'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['product_price'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['cogs'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['discount'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['quantity'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['bump'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['bump_price'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['notes'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['courier'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['shipping_cost'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['cod_cost'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['receipt_number'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['gross_revenue'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['net_revenue'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['created_at'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['processing_at'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['completed_at'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['handled_by'] }}
                                                    </td>
                                                    <td>
                                                        {{ !empty($order['coupon']) ? $order['coupon'] : "" }}
                                                    </td>
                                                    <td>
                                                        {{ preg_replace('/[^A-Za-z0-9\-]/', '', (!empty($order['utm_campaign']) ? $order['utm_campaign'] : "")) }}
                                                    </td>
                                                    
                                                    <td>
                                                        {{ preg_replace('/[^A-Za-z0-9\-]/', '', (!empty($order['utm_medium']) ? $order['utm_medium'] : "")) }}
                                                        
                                                    </td>
                                                    <td>
                                                        {{ !empty($order['utm_source']) ? $order['utm_source'] : "" }}
                                                    </td>
                                                    <td>
                                                        {{ preg_replace('/[^A-Za-z0-9\-]/', '', (!empty($order['utm_content']) ? $order['utm_content'] : "")) }}
                                                    </td>
                                                    <td>
                                                        {{ !empty($order['utm_term']) ? $order['utm_term'] : '' }}
                                                    </td>
                                                    <td>
                                                        {{ !empty($order['tags']) ? $order['tags'] : "" }}
                                                    </td>
                                                    <td>
                                                        {{ !empty($order['variation']) ? $order['variation'] : "" }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <div class="box-footer pull-right">
                                            <a href="{{ url('backend/logistic') }}" class="btn btn-default confirm">
                                                Cancel
                                            </a>
                                            <button type="submit" class="btn btn-success confirm">Save</button>
                                        </div>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
