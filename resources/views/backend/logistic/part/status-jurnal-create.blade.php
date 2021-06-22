@extends('backend')
@section('page_header')
    <h1 class="page-title">
        Check Status Create Product
    </h1>
@stop
@section('css')
@endsection
@section('js')

@endsection
@section('main')
    <!-- Jurnal Get Last Status Proceed -->
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
                                            Last Status
                                        </h3>
                                    </div>
                                    <div class="box-body pad">
                                    <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="align-right">
                                                        Status
                                                    </th>
                                                    <th class="align-right">
                                                        Data
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-product">
                                                @if(!empty($statusProduct))
                                                    @if(array_key_exists('status', $statusProduct))
                                                        <tr>
                                                            <td>
                                                                Gagal Memuat Akun, coba periksa koneksi anda
                                                            </td>
                                                        </tr>
                                                    @else
                                                        @foreach($statusProduct as $status)
                                                            <tr>
                                                                @if($status['status'] == true)
                                                                    <td>Success</td>
                                                                    <td>{{ $status['data']->product->name }} has been created</td>
                                                                @else
                                                                    <td>Failed</td>
                                                                    <td>{{ $status['data'] }}</td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                @else
                                                    <tr>
                                                        <h4>No Data Found</h4>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="box-footer pull-right">
                                        <a href="{{url()->previous()}}" type="button" class="btn btn-danger confirm">
                                            Back    
                                        </a>
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