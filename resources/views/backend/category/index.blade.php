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
        <div class="row">
            <div class="box">
                <div class="box-header with-bordered">
                    <a href="/backend/category/create" class="btn btn-primary"> <i class="fa fa-plus-square"></i> Add Category</a>
                </div>
                <div class="box-body">
                <table>
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="bg-primary">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Parent ID</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0; ?>
                            <tr>
                                @foreach ($category as $c)
                                <?php $no++ ?>
                                <td> {{ $no }} </td>
                                <td> {{ $c->name }} </td>
                                <td> {{ $c->parent ? $c->parent->name : '' }} </td>
                                <td>
                                    <a href="/backend/category/edit/{{ $c->id }}" class="btn btn-warning btn-sm"> <span class="glyphicon glyphicon-edit"></span> Edit</a>
                                    <a href="/backend/category/delete/{{$c->id}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')" ><span class="glyphicon glyphicon-trash"></span> Delete</a>
                                </td>
                            </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    <table>
                        <tr>
                        <div class="jumlah-category pull-left"><strong>Jumlah Category : {{$jumlah_category}}</strong></div>
                        </tr>
                    </table>
                    <hr>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection