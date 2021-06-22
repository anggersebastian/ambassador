@extends('backend')
@section('page_header')
    <h1 class="page-title">
        <i class="icon voyager-people"></i> Result Bulk Receipt
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
                                            Result Bulk Receipt
                                        </h3>
                                        <p>
                                            Total {{ $orders ? $orders->count() : 0 }} Orders
                                        </p>
                                    </div>

                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>
                                                Receipt
                                            </th>
                                            <th>
                                                Batch
                                            </th>
                                            <th>
                                                Product Name
                                            </th>
                                            <th>
                                                User / Phone
                                            </th>
                                            <th>
                                                Payment
                                            </th>
                                            <th>
                                                Product
                                            </th>
                                            <th>
                                                Shipping
                                            </th>
                                            <th>
                                                Cod Fee
                                            </th>
                                            <th>
                                                Gross
                                            </th>
                                            <th>
                                                Nett
                                            </th>
                                            <th>
                                                #
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $gross      = 0;
                                            $nett       = 0;
                                            $product    = 0;
                                            $cod        = 0;
                                            $codPercent = 0;
                                            $shipping   = 0;
                                            $cogs       = 0;
                                        @endphp
                                        @foreach($orders as $order)
                                            @php
                                            $gross      += is_numeric($order->gross_revenue) ? $order->gross_revenue : 0;
                                            $nett       += is_numeric($order->net_revenue) ? $order->net_revenue : 0;
                                            $product    += is_numeric($order->product_price) ? $order->product_price : 0;
                                            $cod        += is_numeric($order->cod_cost) ? $order->cod_cost : 0;
                                            if(is_numeric($order->cod_cost)){
                                                $codPercent += $order->cod_cost - $order->shipping_cost - $order->product_price;
                                            }
                                            $shipping   += is_numeric($order->shipping_cost) ? $order->shipping_cost : 0;
                                            if(is_numeric($order->cogs)){
                                                $qtyReal    = $order->quantity_real * $order->cogs;
                                                $cogs       += $qtyReal;
                                            }
                                            @endphp
                                            <tr>
                                                <td>
                                                    {{ $order->receipt_number }}
                                                </td>
                                                <td>
                                                    {{ $order->logistic_batch->id }} - {{ $order->logistic_batch->request_date }}
                                                </td>
                                                <td>
                                                    {{ $order->product_name }}
                                                </td>
                                                <td>
                                                    {{ $order->name }} / {{ $order->phone }}
                                                </td>
                                                <td>
                                                    {{ $order->payment_method }}
                                                </td>
                                                <td>
                                                    {{ $order->product_price }}
                                                </td>
                                                <td>
                                                    {{ $order->shipping_cost }}
                                                </td>
                                                <td>
                                                    {{ $order->cod_cost }}
                                                </td>
                                                <td>
                                                    {{ $order->gross_revenue }}
                                                </td>
                                                <td>
                                                    {{ $order->net_revenue }}
                                                </td>
                                                <td>
                                                    <a href="{{ url('backend/logistic/order-detail/' . $order->id) }}" class="btn btn-xs btn-primary">
                                                        <i class="fa fa-search"></i> Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <hr/>

                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <td>
                                                Gross {{ number_format($gross,0) }}
                                            </td>
                                            <td>
                                                Net {{ number_format($nett,0) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Product {{ number_format($product,0) }}
                                            </td>
                                            <td>
                                                COGS {{ number_format($cogs,0) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Shipping {{ number_format($shipping,0) }}
                                            </td>
                                            <td>
                                                COD Request / Fee Only {{ number_format($cod,0) }} / {{ number_format($codPercent,0) }}
                                            </td>
                                        </tr>
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
@stop
