@extends('backend')
@section('page_header')
    <h1 class="page-title">
        <i class="icon voyager-people"></i> Form Landing Page
    </h1>
@stop
@section('js')
@endsection
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
                                        <h3>Landing Page Pre Save</h3>
                                    </div>
                                    @if(isset($landing))
                                        {{ Form::open(['url' => url('backend/landing/form-save/' . $landing->id)]) }}
                                    @else
                                        {{ Form::open(['url' => url('backend/landing/form-save')]) }}
                                    @endif
                                    <div class="box-body pad">
                                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                            <label for="title">Title</label>
                                            <input type="text" name="title" class="form-control" placeholder="Title" value="{{ isset($content) ? $content->title : old('title') }}" required>
                                            @if($errors->has('title'))
                                                <p class="help-block">{{ $errors->first('title') }}</p>
                                            @endif
                                        </div>
                                        <div class="box-footer pull-right">
                                            <a href="{{ url('backend/landing') }}" class="btn btn-default confirm">
                                                Cancel
                                            </a>
                                            <button type="submit" class="btn btn-success">Save</button>
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
    </div>
@stop
