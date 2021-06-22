@extends('backend')
@section('page_header')
    <h1 class="page-title">
        <i class="icon voyager-people"></i> Reconciliation Form Result Ninja
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
                                            Form Result Order Ninja Reconciliation Temporary
                                        </h3>
                                        <p>
                                            Total {{ count($orders) }} Orders
                                        </p>
                                    </div>
                                    {{ Form::open(['url' => url('backend/logistic/save-reconciliation-csv-ninja/'),'method' => 'post','files' => true]) }}
                                    <div class="box-body pad table-responsive">

                                        @if(Session::has('status'))
                                            <p class="alert alert-{{ Session::get('alert-class', 'info') }}">{{ Session::get('status') }}</p>
                                        @endif

                                        <input type="hidden" name="resi" value="{{ json_encode($orders) }}">
                                        <table class="table table-bordered table-striped table-highlight">
                                            <thead>
                                                <th>No Resi</th>
                                            </thead>
                                            <tbody>
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td>
                                                        {{ $order }}
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
@stop
