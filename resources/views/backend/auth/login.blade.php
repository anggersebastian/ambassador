@extends('backend.auth.auth')

@section('main')
    <h1 style="background-color: #51a297">Ambassador</h1>
    <h2 style="background-color: #339ea2">Login</h2>

    {{ Form::open(['url' => url('backend/login/authenticate'),'method' => 'post','files' => true]) }}

        <div class="form-group">
            <label for="email"><i class="glyphicon glyphicon-user"></i></label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Email">
        </div>
        <div class="form-group">
            <label for="password"><i class="glyphicon glyphicon-asterisk"></i></label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        @if(Session::has('error'))
            <div class="alert alert-danger" role="alert">{{ Session::get('error') }}</div>
        @endif
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <div class="col-md-6">
                <a href="{{ url('backend/reset') }}" class="btn btn-block btn-warning">Forgot Password</a>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-block btn-success">Login</button>
            </div>
        </div>
    {{ Form::close() }}
@endsection