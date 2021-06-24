@extends('backend')
@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h4>Dashboard</h4>
            </div>
        </div>
    </div>
@endsection
@section('main')
    <div class="page-content container-fluid">
        <dashboard-index></dashboard-index>
    </div>
@endsection