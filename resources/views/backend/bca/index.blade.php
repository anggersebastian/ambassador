@extends('backend')
@section('page_header')
    <h4>BCA Mutasi</h4>
    <div class="pull-right">
    </div>
@endsection
@section('main')
    <div class="page-content container-fluid">
        <div class="panel panel-bordered">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box-body">
                            {{ Form::open(['url' => url('backend/bca'), 'method' => 'get']) }}
                            <div class="row gutter-10">
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">Desc</span>
                                        <input type="text" class="form-control" value="{{ isset($filters['description']) ? $filters['description'] : "" }}" name="description"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">Amount</span>
                                        <input type="text" class="form-control" value="{{ isset($filters['amount']) ? $filters['amount'] : "" }}" name="amount"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <span class="input-group-addon">Date Start</span>
                                        <input type="date" class="form-control" value="{{ isset($filters['date_start']) ? $filters['date_start'] : "" }}" name="date_start"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <span class="input-group-addon">Date End</span>
                                        <input type="date" class="form-control" value="{{ isset($filters['date_end']) ? $filters['date_end'] : "" }}" name="date_end"/>
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
                    <div class="col-lg-12">
                        @if(Session::has('status'))
                            <p class="alert alert-{{ Session::get('alert-class', 'info') }}">{{ Session::get('status') }}</p>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Amount</th>
                                    <th>In/Out</th>
                                    <th>Desc</th>
                                    <th>Date</th>
                                    <th>Created</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($logs as $log)
                                    <tr>
                                        <td>{{ $log->id }}</td>
                                        <td>{{ number_format($log->amount, 0) }}</td>
                                        <td>
                                            @if($log->in_out == 'in')
                                                <span class="label label-success">
                                                    IN
                                                </span>
                                            @else
                                                <span class="label label-danger">
                                                    OUT
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $log->description }}</td>
                                        <td>{{ $log->date }}</td>
                                        <td>{{ $log->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                @if(isset($logs))
                                    {!! $logs->appends(Input::except('page'))->links() !!}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
