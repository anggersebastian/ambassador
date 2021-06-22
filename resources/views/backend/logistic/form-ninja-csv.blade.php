@extends('backend')
@section('page_header')
    <h1 class="page-title">
        <i class="icon voyager-people"></i> Form Ninja Express CSV
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
                                        @if(Session::has('status'))
                                            <p class="alert alert-{{ Session::get('alert-class', 'info') }}"
                                               style="margin: 0 10px 20px 10px">{{ Session::get('status') }}
                                            </p>
                                        @endif
                                        <h3 class="box-title">
                                            Form Ninja Express CSV
                                        </h3>
                                    </div>
                                    {{ Form::open(['url' => url('backend/logistic/show-csv-ninja'),'method' => 'post','files' => true]) }}
                                    <div class="box-body pad">
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
                                            <button type="submit" id="save_btn" class="btn btn-success confirm">Save</button>
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
