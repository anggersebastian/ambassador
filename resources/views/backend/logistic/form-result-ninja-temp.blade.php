@extends('backend')
@section('page_header')
    <h1 class="page-title">
        <i class="icon voyager-people"></i> Form Result Ninja
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
                                            Form Result Order Ninja Temporary
                                        </h3>
                                        <p>
                                            Total {{ count($orders) }} Orders
                                        </p>
                                    </div>
                                    {{ Form::open(['url' => url('backend/logistic/save-order-ninja-csv/'),'method' => 'post','files' => true]) }}
                                    <div class="box-body pad table-responsive">

                                        @if(Session::has('status'))
                                            <p class="alert alert-{{ Session::get('alert-class', 'info') }}">{{ Session::get('status') }}</p>
                                        @endif

                                        <input type="hidden" name="orders" value="{{ json_encode($orders) }}">
                                        <table class="table table-bordered table-striped table-highlight">
                                            {{--<thead>
                                                <th>No</th>
                                                @foreach($orders[0] as $key => $value)
                                                    <th>{{ $key }}</th>
                                                @endforeach
                                            </thead>--}}
                                            @foreach($orders as $key => $order)
                                                <tbody>
                                                    <td>
                                                        {{ $key+1 }}
                                                    </td>
                                                    <td>
                                                        {{ $order['kontak'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['id_pelacakan'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['nama'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['alamat_penerima'] }}
                                                    </td>
                                                    {{--<td>
                                                        {{ $order['province'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['city'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['subdistrict'] }}
                                                    </td>--}}
                                                    <td>
                                                        {{ $order['kode_pos'] }}
                                                    </td>
                                                    <td>
                                                        {{ $order['cod'] }}
                                                    </td>
                                                    <td>
                                                        {{ isset($order['comments']) ? $order['comments'] : '' }}
                                                    </td>
                                                </tbody>
                                            @endforeach
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
@stop
