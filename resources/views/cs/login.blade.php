@extends('cs.cs')

@section('main')
    <div class="col-md-12">
        <h1>{{ env('APP_NAME') }}</h1>
        <h2>Login CS</h2>
        <form method="post" action="{{ url('/cs-authenticate') }}">
            <div class="form-group">
                <label for="Code"><i class="glyphicon glyphicon-asterisk"></i></label>
                <input type="text" class="form-control" id="code" name="code" placeholder="Code">
            </div>
            @if(Session::has('error'))
                <div class="alert alert-danger" role="alert">{{ Session::get('error') }}</div>
            @endif
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-block btn-success">Login</button>
                </div>
            </div>
        </form>
    </div>
@endsection