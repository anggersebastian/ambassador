@extends('backend')
@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h4>Product Manage</h4>
            </div>
        </div>
    </div>
@endsection
@section('main')
    <div class="page-content container-fluid">
        <product-form></product-form>
    </div>
@endsection