@extends('backend')
@section('page_header')
    <h1 class="page-title">
        <i class="icon voyager-people"></i> RECONCILIATION Form Ninja Express CSV
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
                                            RECONCILIATION Form Ninja Express CSV
                                        </h3>
                                    </div>
                                    {{ Form::open(['url' => url('backend/logistic/show-reconciliation-csv-ninja'),'method' => 'post','files' => true]) }}
                                    <div class="box-body pad">
                                        <div class="form-group{{ $errors->has('csv') ? ' has-error' : '' }}">
                                            <label for="title">EXCEL DATA</label>
                                            <textarea class="form-control" data-height="400px" name="csv"></textarea>
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
