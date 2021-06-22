@extends('backend')
@section('page_header')
    <h1 class="page-title">
        <i class="icon voyager-people"></i> Form Batch
    </h1>
@stop
@section('js')
@endsection
@section('main')
    <div class="page-content container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="box box-info">
                                    <div class="box-header">
                                        <h3 class="box-title">
                                            Form Batch
                                        </h3>
                                    </div>
                                    {{ Form::open(['url' => url('backend/logistic/save-batch/' . (isset($batch) ? $batch->id : '')),'method' => 'post','files' => true]) }}
                                    <div class="box-body pad">

                                        @if(Session::has('status'))
                                            <p class="alert alert-{{ Session::get('alert-class', 'info') }}">{{ Session::get('status') }}</p>
                                        @endif

                                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" name="title" value="{{ (isset($batch) ? $batch->title : '') }}" required>
                                            @if($errors->has('title'))
                                                <p class="help-block">{{ $errors->first('title') }}</p>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('request_date') ? ' has-error' : '' }}">
                                            <label for="title">Request Date</label>
                                            <input type="date" class="form-control" name="request_date" value="{{ (isset($batch) ? $batch->request_date : '') }}" required style="line-height:15px;">
                                            @if($errors->has('request_date'))
                                                <p class="help-block">{{ $errors->first('request_date') }}</p>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="pending" {{ (isset($batch) AND $batch->status == 'pending') ? 'selected' : '' }}>Pending</option>
                                                <option value="sent" {{ (isset($batch) AND $batch->status == 'sent') ? 'selected' : '' }}>Sent</option>
                                            </select>
                                            @if($errors->has('status'))
                                                <p class="help-block">{{ $errors->first('status') }}</p>
                                            @endif
                                        </div>
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
