@extends('backend')
@section('page_header')
    <h1 class="page-title">
        <i class="icon voyager-people"></i> Form Landing Page
    </h1>
@stop
@section('css')
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
                                            CSV Order Form
                                        </h3>
                                    </div>
                                    {{ Form::open(['url' => url('backend/logistic/show-csv'),'method' => 'post','files' => true]) }}
                                    <div class="box-body pad">
                                        <div class="form-group{{ $errors->has('logistic_batch_id') ? ' has-error' : '' }}">
                                            <label for="logistic_batch_id">
                                                Batch ID
                                                <a href="{{ url('backend/logistic/form-batch') }}" class="btn btn-xs btn-primary">
                                                    Create New
                                                </a>
                                            </label>
                                            <select class="form-control" name="logistic_batch_id" required>
                                                @foreach($batches as $batch)
                                                    <option value="{{ $batch->id }}">
                                                        {{ $batch->title }} - {{ $batch->id }} - {{ $batch->request_date }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('csv'))
                                                <p class="help-block">{{ $errors->first('csv') }}</p>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('csv') ? ' has-error' : '' }}">
                                            <label for="title">CSV</label>
                                            <input type="file" name="csv" required>
                                            @if($errors->has('csv'))
                                                <p class="help-block">{{ $errors->first('csv') }}</p>
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
