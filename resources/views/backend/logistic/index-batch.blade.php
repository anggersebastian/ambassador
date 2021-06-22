@extends('backend')
@section('page_header')
    <h4>Index Batch</h4>
    <div class="pull-right">
        <a href="{{ url('backend/logistic/form-batch') }}" class="btn btn-sm btn-success">
            <i class="fa fa-pencil"></i> Create
        </a>
    </div>
@endsection
@section('main')
    <div class="page-content container-fluid">
        <div class="panel panel-bordered">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box-body">
                            {{ Form::open(['url' => url('backend/logistic'), 'method' => 'get']) }}
                            <div class="row gutter-10">
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">Title</span>
                                        <input type="text" class="form-control" value="{{ isset($filters['title']) ? $filters['title'] : "" }}" name="title"/>
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
                                        <th>Title</th>
                                        <th>Request Date</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total Order</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($batches as $batch)
                                        <tr>
                                            <td>{{ $batch->id }}</td>
                                            <td>{{ $batch->title }}</td>
                                            <td>{{ $batch->request_date }}</td>
                                            <td>{{ $batch->status }}</td>
                                            <td>{{ $batch->logistic_orders->count() }}</td>
                                            <td>
                                                <a href="{{ url('backend/logistic/detail-batch/'. $batch->id) }}" class="btn btn-xs btn-primary">
                                                    <i class="fa fa-search"></i> Detail
                                                </a>
                                                <a href="{{ url('backend/logistic/form-batch/'. $batch->id) }}" class="btn btn-xs btn-warning">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                                <a href="{{ url('backend/logistic/delete/'. $batch->id) }}" class="btn btn-xs btn-danger delete">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                @if(isset($batches))
                                    {!! $batches->appends(Input::except('page'))->links() !!}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection