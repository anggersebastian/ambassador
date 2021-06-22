@extends('cs.cs')
@section('page_header')
    <h4>Index CS Order</h4>
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
                            {{ Form::open(['url' => url('cs'), 'method' => 'get']) }}
                            <div class="row gutter-10">
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">CS Name</span>
                                        <input type="text" class="form-control" value="{{ isset($filters['name']) ? $filters['name'] : "" }}" name="name" readonly=""/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">Date Start</span>
                                        <input type="date" class="form-control" value="{{ isset($filters['date_start']) ? $filters['date_start'] : "" }}" name="date_start"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
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
                                    <th>CS Name</th>
                                    <th>Success</th>
                                    <th>Pending</th>
                                    <th>Reschedule</th>
                                    <th>Failed</th>
                                    <th>All</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($cs as $c)
                                    <tr>
                                        <td>{{ $c->handled_by ? $c->handled_by : 'System' }}</td>
                                        <td>
                                            {{ $countCs->where('handled_by', $c->handled_by)->whereIn('logistic_status', ['Completed'])->count() }}

                                            <a href="{{ url('cs-order'). '?logistic_status=Completed&date_start='.(isset($filters['date_start']) ? $filters['date_start'] : '').'&date_end='.(isset($filters['date_end']) ? $filters['date_end'] : '') }}" class="btn btn-xs btn-success">
                                                <i class="fa fa-search"></i> List All
                                            </a>
                                        </td>
                                        <td>
                                            {{ $countCs->where('handled_by', $c->handled_by)->whereNotIn('logistic_status', ['Completed','Pending Reschedule','Failed','First Attempt Delivery Fail','Returned to Sender'])->count() }}

                                            <a href="{{ url('cs-order?logistic_status_not=Completed,Pending Reschedule,Failed,Returned to Sender&date_start='.(isset($filters['date_start']) ? $filters['date_start'] : '').'&date_end='.(isset($filters['date_end']) ? $filters['date_end'] : '')) }}" class="btn btn-xs btn-default">
                                                <i class="fa fa-search"></i> List All
                                            </a>
                                        </td>
                                        <td>
                                            {{ $countCs->where('handled_by', $c->handled_by)->whereIn('logistic_status', ['Pending Reschedule','First Attempt Delivery Fail'])->count() }}

                                            <a href="{{ url('cs-order?logistic_status=Pending Reschedule,First Attempt Delivery Fail&date_start='.(isset($filters['date_start']) ? $filters['date_start'] : '').'&date_end='.(isset($filters['date_end']) ? $filters['date_end'] : '')) }}" class="btn btn-xs btn-warning">
                                                <i class="fa fa-search"></i> List All
                                            </a>
                                        </td>
                                        <td>
                                            {{ $countCs->where('handled_by', $c->handled_by)->whereIn('logistic_status', ['Failed','Returned to Sender'])->count() }}

                                            <a href="{{ url('cs-order?logistic_status=Failed,Returned to Sender&date_start='.(isset($filters['date_start']) ? $filters['date_start'] : '').'&date_end='.(isset($filters['date_end']) ? $filters['date_end'] : '')) }}" class="btn btn-xs btn-danger">
                                                <i class="fa fa-search"></i> List All
                                            </a>
                                        </td>
                                        <td>
                                            {{ $countCs->where('handled_by', $c->handled_by)->count() }}

                                            <a href="{{ url('cs-order') }}" class="btn btn-xs btn-info">
                                                <i class="fa fa-search"></i> List All
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                @if(isset($cs))
                                    {!! $cs->appends(Input::except('page'))->links() !!}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection