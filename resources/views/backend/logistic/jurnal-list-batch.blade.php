@extends('backend')
@section('page_header')
    <h1 class="page-title">
        <i class="icon voyager-people"></i> Jurnal Create Sales Invoice
    </h1>
@stop
@section('css')
@endsection
@section('js')
    <script>
        var counter         = 0;
        function ajaxChecking(id){
            let baseUrl = $('base').data('url');
            let save_button =   document.querySelector('#save_btn');
            let html    = '';
            let i       = 0;
            let proceed = document.querySelector('#proceed');
            let check   = document.querySelector('#check');
            $.ajax({
                url: baseUrl + '/backend/logistic/jurnal/checking-product/' + id,
                success: function(response){
                    if(typeof response.status == 'undefined'){
                        if(Object.keys(response).length === 0 && response.constructor !== Object){
                            console.log('jurnal ready');
                            let btn_jurnal  =   document.createTextNode(' to Jurnal');
                            document.querySelector('.input-jurnal').value = id;
                            html    = '\n' +
                            '<tr id="product-'+ i +'">' +
                            '   <td class="align-right">' +
                            '       <h5> Sales Invoice Jurnal dapat dibuat </h5>' +
                            '   </td>' +
                            '</tr>';
                            if(counter < 1){
                                $('#table-product').append(html);
                                proceed.appendChild(btn_jurnal);
                                counter++;
                            }
                            proceed.style.display   = proceed.style.display === 'none' ? '' : 'none';
                            check.style.display     = check.style.display === '' ? 'none' : '';
                            // bikin input type hidden untuk jurnal value (1)
                        } else {
                            console.log('success case');
                            var sku = Object.keys(response);
                            // dom
                            for(i = 0; i < sku.length; i++){
                                html    = '\n' +
                                '<tr id="product-'+ i +'">' +
                                '   <td class="align-right">' +
                                '       <input class="form-control" name="product['+ i +'][name]" ' +
                                '       placeholder="Product Name" id="name_id' + i + '" value="'+ response[sku[i]] +'" readonly/>' +
                                '   </td>' +
                                '   <td class="align-right">' +
                                '       <input class="form-control" name="product['+ i +'][sku]" ' +
                                '       placeholder="Product SKU" id="sku_id' + i + '" value="'+ sku[i] +'"/>' +
                                '   </td>' +
                                '</tr>';
                                $('#table-product').append(html);
                            }
                            proceed.style.display   = proceed.style.display === 'none' ? '' : 'none';
                            check.style.display     = check.style.display === '' ? 'none' : '';
                        }
                    } else {
                        console.log('error case');
                        html    = '\n' +
                        '<tr id="product-'+ i +'">' +
                        '   <td class="align-right">' +
                        '       <h5> Error"'+ response.data +'" </h5>' +
                        '   </td>' +
                        '</tr>';
                        if(counter < 1){
                            $('#table-product').append(html);
                            counter++;
                        }
                        if(proceed.style.display === ''){
                            proceed.style.display   === 'none';
                            check.style.display     === '';
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
    </script>
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
                                            Jurnal Product Checking
                                        </h3>
                                    </div>
                                    {{ Form::open(['url' => url('backend/logistic/jurnal/create-product'),'method' => 'post']) }}
                                    <div class="box-body pad">
                                        <input type="hidden" name="jurnal" class="input-jurnal" value="">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="align-right">
                                                        Product Name
                                                    </th>
                                                    <th class="align-right">
                                                        SKU
                                                    </th>
                                                    <th>
                                                        #
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-product">
                                                <tr></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="box-footer pull-right">
                                        <button type="submit" class="btn btn-success confirm" id="proceed" style="display: none">
                                            Proceed
                                        </button>
                                        <button type="button" onclick="ajaxChecking({{ $id }})" class="btn btn-primary" id="check">
                                            Check
                                        </button>
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
