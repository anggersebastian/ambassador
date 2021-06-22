@extends('backend')
@section('tag_create')
<div class="container-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <form class="form-inline" action="tag/store" method="post" enctype="multipart/form-data">
                            {{@csrf_field()}}
                            <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success">Input</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->slug}}</td>
                            <td style="width: 5px;">
                                <a href="tag/edit/{{$item->id}}" class="btn btn-sm btn-info" data-toggle="modal" data-target="#staticBackdrop">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <form class="form-inline" action="tag/update/{{$item->id}}" method="post" enctype="multipart/form-data">
                                            {{@csrf_field()}}
                                            {{method_field('PUT')}}
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Edit Data</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card text-center">
                                                    <div class="card-body border-top-0">
                                                        <div class="row">
                                                            <div class="col">
                                                                <input type="text" name="name" class="form-control" placeholder="Name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-success">Input</button>
                                            </div>
                                        </div>
                                    </form>
                                </div> 
                            </td>
                            <td>
                                <form class="d-md-inline" action="tag/delete/{{$item->id}}" method="post">
                                    {{@csrf_field()}}
                                    {{method_field('DELETE')}}
                                    <button class="btn btn-sm btn-danger" name="button">
                                    <i class="fa fa-trash"></i>
                                    </button>
                                </form> 
                            </td>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
   