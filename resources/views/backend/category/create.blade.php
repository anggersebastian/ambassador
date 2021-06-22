@extends('backend')
@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <strong><h4>Add Category</h4></strong>
            </div>
        </div>
    </div>
@endsection
@section('main')
    <div class="page-content container-fluid" id="app">
        {{-- <product-index></product-index> --}}
        <div class="panel panel-bordered">
            <div class="panel panel-body">

                <form action="/backend/category/store" method="post">
                    {{ csrf_field() }}
                    <a href="/backend/category" class="btn btn-primary"><i class="fa fa-arrow-left"> Back</i></a>
                    <br><br>
                <div class="form-group m-3">
                    <label for="name">Name :</label>
                    <input type="text" class="form-control" name="name" id="name">

                    @if ($errors->has('name'))
                        <div class="text-danger">
                            {{$errors->first('name')}}
                        </div>
                    @endif

                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Parent ID :</label>
                    <select class="form-control" name="parent">
                        <option value="" selected>Choose...</option>
                        @foreach ($category as $c)
                        <option value="{{$c->id}}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">
                        <span class="glyphicon glyphicon-floppy-disk"></span> Save
                    </button>
                </div>
                </form>

            </div>
        </div>
    </div>

@endsection