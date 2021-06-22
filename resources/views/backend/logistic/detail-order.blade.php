@extends('backend')
@section('page_header')
    <h1 class="page-title">
        <i class="icon voyager-people"></i> Detail Order
    </h1>
@stop
@section('js')
@endsection
@section('main')
    <div class="page-content container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-info">
                                    <div class="box-header">
                                        <h3 class="box-title">
                                            Order Form
                                        </h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="box-body pad">
                                                <div class="form-group{{ $errors->has('batch_token') ? ' has-error' : '' }}">
                                                    <label for="batch_token">Batch Token</label>
                                                    <input type="text" name="batch_token" class="form-control" readonly value="{{ isset($order) ? $order->batch_token : old('batch_token') }}">
                                                    @if($errors->has('batch_token'))
                                                        <p class="help-block">{{ $errors->first('batch_token') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('logistic_batch_id') ? ' has-error' : '' }}">
                                                    <label for="batch_token">Batch ID</label>
                                                    <input type="text" name="logistic_batch_id" class="form-control" readonly value="{{ isset($order) ? $order->logistic_batch_id : old('logistic_batch_id') }}">
                                                    @if($errors->has('logistic_batch_id'))
                                                        <p class="help-block">{{ $errors->first('logistic_batch_id') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('order_id') ? ' has-error' : '' }}">
                                                    <label for="order_id">Order ID</label>
                                                    <input type="text" name="order_id" class="form-control" readonly value="{{ isset($order) ? $order->order_id : old('order_id') }}">
                                                    @if($errors->has('order_id'))
                                                        <p class="help-block">{{ $errors->first('order_id') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
                                                    <label for="notes">notes</label>
                                                    <input type="text" name="notes" class="form-control" readonly value="{{ isset($order) ? $order->notes : old('notes') }}">
                                                    @if($errors->has('notes'))
                                                        <p class="help-block">{{ $errors->first('notes') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
                                                    <label for="product_name">product_name</label>
                                                    <input type="text" name="product_name" class="form-control" readonly value="{{ isset($order) ? $order->product_name : old('product_name') }}">
                                                    @if($errors->has('product_name'))
                                                        <p class="help-block">{{ $errors->first('product_name') }}</p>
                                                    @endif
                                                </div>

                                                <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                                    <label for="quantity">quantity</label>
                                                    <input type="text" name="quantity" class="form-control" readonly value="{{ isset($order) ? $order->quantityquantity : old('quantity') }}">
                                                    @if($errors->has('quantity'))
                                                        <p class="help-block">{{ $errors->first('quantity') }}</p>
                                                    @endif
                                                </div>

                                                <div class="form-group{{ $errors->has('receipt_number') ? ' has-error' : '' }}">
                                                    <label for="receipt_number"><b>RECEIPT NUMBER / RESI</b></label>
                                                    <input type="text" name="receipt_number" class="form-control" readonly value="{{ isset($order) ? $order->receipt_number : old('receipt_number') }}">
                                                    @if($errors->has('receipt_number'))
                                                        <p class="help-block">{{ $errors->first('receipt_number') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                    <label for="name">name</label>
                                                    <input type="text" name="name" class="form-control" readonly value="{{ isset($order) ? $order->name : old('name') }}">
                                                    @if($errors->has('name'))
                                                        <p class="help-block">{{ $errors->first('name') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                    <label for="email">email</label>
                                                    <input type="text" name="email" class="form-control" readonly value="{{ isset($order) ? $order->email : old('email') }}">
                                                    @if($errors->has('email'))
                                                        <p class="help-block">{{ $errors->first('email') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                                    <label for="phone">phone</label>
                                                    <input type="text" name="phone" class="form-control" readonly value="{{ isset($order) ? $order->phone : old('phone') }}">
                                                    @if($errors->has('phone'))
                                                        <p class="help-block">{{ $errors->first('phone') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('full_address') ? ' has-error' : '' }}">
                                                    <label for="content">Full Adress</label>
                                                    <textarea class="form-control" readonly name="full_address" required>{{ isset($order) ? $order->full_address : old('full_address') }}</textarea>
                                                    @if($errors->has('full_address'))
                                                        <p class="help-block">{{ $errors->first('full_address') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('province') ? ' has-error' : '' }}">
                                                    <label for="province">province</label>
                                                    <input type="text" name="province" class="form-control" readonly value="{{ isset($order) ? $order->province : old('province') }}">
                                                    @if($errors->has('province'))
                                                        <p class="help-block">{{ $errors->first('province') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                                    <label for="city">city</label>
                                                    <input type="text" name="city" class="form-control" readonly value="{{ isset($order) ? $order->city : old('city') }}">
                                                    @if($errors->has('city'))
                                                        <p class="help-block">{{ $errors->first('city') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('subdistrict') ? ' has-error' : '' }}">
                                                    <label for="subdistrict">subdistrict</label>
                                                    <input type="text" name="subdistrict" class="form-control" readonly value="{{ isset($order) ? $order->subdistrict : old('subdistrict') }}">
                                                    @if($errors->has('subdistrict'))
                                                        <p class="help-block">{{ $errors->first('subdistrict') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
                                                    <label for="zip">zip</label>
                                                    <input type="text" name="zip" class="form-control" readonly value="{{ isset($order) ? $order->zip : old('zip') }}">
                                                    @if($errors->has('zip'))
                                                        <p class="help-block">{{ $errors->first('zip') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('payment_status') ? ' has-error' : '' }}">
                                                    <label for="payment_status">payment_status</label>
                                                    <input type="text" name="payment_status" class="form-control" readonly value="{{ isset($order) ? $order->payment_status : old('payment_status') }}">
                                                    @if($errors->has('payment_status'))
                                                        <p class="help-block">{{ $errors->first('payment_status') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('payment_method') ? ' has-error' : '' }}">
                                                    <label for="payment_method">payment_method</label>
                                                    <input type="text" name="payment_method" class="form-control" readonly value="{{ isset($order) ? $order->payment_method : old('payment_method') }}">
                                                    @if($errors->has('payment_method'))
                                                        <p class="help-block">{{ $errors->first('payment_method') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('bump') ? ' has-error' : '' }}">
                                                    <label for="bump">bump</label>
                                                    <input type="text" name="bump" class="form-control" readonly value="{{ isset($order) ? $order->bump : old('bump') }}">
                                                    @if($errors->has('bump'))
                                                        <p class="help-block">{{ $errors->first('bump') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('bump_price') ? ' has-error' : '' }}">
                                                    <label for="bump_price">bump_price</label>
                                                    <input type="text" name="bump_price" class="form-control" readonly value="{{ isset($order) ? $order->bump_price : old('bump_price') }}">
                                                    @if($errors->has('bump_price'))
                                                        <p class="help-block">{{ $errors->first('bump_price') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('discount') ? ' has-error' : '' }}">
                                                    <label for="discount">discount</label>
                                                    <input type="text" name="discount" class="form-control" readonly value="{{ isset($order) ? $order->discount : old('discount') }}">
                                                    @if($errors->has('discount'))
                                                        <p class="help-block">{{ $errors->first('discount') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('product_price') ? ' has-error' : '' }}">
                                                    <label for="product_price">product_price</label>
                                                    <input type="text" name="product_price" class="form-control" readonly value="{{ isset($order) ? $order->product_price : old('product_price') }}">
                                                    @if($errors->has('product_price'))
                                                        <p class="help-block">{{ $errors->first('product_price') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('cogs') ? ' has-error' : '' }}">
                                                    <label for="cogs">cogs</label>
                                                    <input type="text" name="cogs" class="form-control" readonly value="{{ isset($order) ? $order->cogs : old('cogs') }}">
                                                    @if($errors->has('cogs'))
                                                        <p class="help-block">{{ $errors->first('cogs') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('courier') ? ' has-error' : '' }}">
                                                    <label for="courier">courier</label>
                                                    <input type="text" name="courier" class="form-control" readonly value="{{ isset($order) ? $order->courier : old('courier') }}">
                                                    @if($errors->has('courier'))
                                                        <p class="help-block">{{ $errors->first('courier') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('logistic_status') ? ' has-error' : '' }}">
                                                    <label for="logistic_status">logistic_status</label>
                                                    <input type="text" name="logistic_status" class="form-control" readonly value="{{ isset($order) ? $order->logistic_status : old('logistic_status') }}">
                                                    @if($errors->has('logistic_status'))
                                                        <p class="help-block">{{ $errors->first('logistic_status') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('shipping_cost') ? ' has-error' : '' }}">
                                                    <label for="shipping_cost">shipping_cost</label>
                                                    <input type="text" name="shipping_cost" class="form-control" readonly value="{{ isset($order) ? $order->shipping_cost : old('shipping_cost') }}">
                                                    @if($errors->has('shipping_cost'))
                                                        <p class="help-block">{{ $errors->first('shipping_cost') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('cod_cost') ? ' has-error' : '' }}">
                                                    <label for="cod_cost">cod_cost</label>
                                                    <input type="text" name="cod_cost" class="form-control" readonly value="{{ isset($order) ? $order->cod_cost : old('cod_cost') }}">
                                                    @if($errors->has('cod_cost'))
                                                        <p class="help-block">{{ $errors->first('cod_cost') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('gross_revenue') ? ' has-error' : '' }}">
                                                    <label for="gross_revenue">gross_revenue</label>
                                                    <input type="text" name="gross_revenue" class="form-control" readonly value="{{ isset($order) ? $order->gross_revenue : old('gross_revenue') }}">
                                                    @if($errors->has('gross_revenue'))
                                                        <p class="help-block">{{ $errors->first('gross_revenue') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('net_revenue') ? ' has-error' : '' }}">
                                                    <label for="net_revenue">net_revenue</label>
                                                    <input type="text" name="net_revenue" class="form-control" readonly value="{{ isset($order) ? $order->net_revenue : old('net_revenue') }}">
                                                    @if($errors->has('net_revenue'))
                                                        <p class="help-block">{{ $errors->first('net_revenue') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('order_created_at') ? ' has-error' : '' }}">
                                                    <label for="order_created_at">order_created_at</label>
                                                    <input type="text" name="order_created_at" class="form-control" readonly value="{{ isset($order) ? $order->order_created_at : old('order_created_at') }}">
                                                    @if($errors->has('order_created_at'))
                                                        <p class="help-block">{{ $errors->first('order_created_at') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('order_processed_at') ? ' has-error' : '' }}">
                                                    <label for="order_processed_at">order_processed_at</label>
                                                    <input type="text" name="order_processed_at" class="form-control" readonly value="{{ isset($order) ? $order->order_processed_at : old('order_processed_at') }}">
                                                    @if($errors->has('order_processed_at'))
                                                        <p class="help-block">{{ $errors->first('order_processed_at') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('handled_by') ? ' has-error' : '' }}">
                                                    <label for="handled_by">handled_by</label>
                                                    <input type="text" name="handled_by" class="form-control" readonly value="{{ isset($order) ? $order->handled_by : old('handled_by') }}">
                                                    @if($errors->has('handled_by'))
                                                        <p class="help-block">{{ $errors->first('handled_by') }}</p>
                                                    @endif
                                                </div>

                                                <div class="form-group{{ $errors->has('coupon') ? ' has-error' : '' }}">
                                                    <label for="coupon">coupon</label>
                                                    <input type="text" name="coupon" class="form-control" readonly value="{{ isset($order) ? $order->coupon : old('coupon') }}">
                                                    @if($errors->has('coupon'))
                                                        <p class="help-block">{{ $errors->first('coupon') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('utm_campaign') ? ' has-error' : '' }}">
                                                    <label for="utm_campaign">utm_campaign</label>
                                                    <input type="text" name="utm_campaign" class="form-control" readonly value="{{ isset($order) ? $order->utm_campaign : old('utm_campaign') }}">
                                                    @if($errors->has('utm_campaign'))
                                                        <p class="help-block">{{ $errors->first('utm_campaign') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('utm_medium') ? ' has-error' : '' }}">
                                                    <label for="utm_medium">utm_medium</label>
                                                    <input type="text" name="utm_medium" class="form-control" readonly value="{{ isset($order) ? $order->utm_medium : old('utm_medium') }}">
                                                    @if($errors->has('utm_medium'))
                                                        <p class="help-block">{{ $errors->first('utm_medium') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('utm_source') ? ' has-error' : '' }}">
                                                    <label for="utm_source">utm_source</label>
                                                    <input type="text" name="utm_source" class="form-control" readonly value="{{ isset($order) ? $order->utm_source : old('utm_source') }}">
                                                    @if($errors->has('utm_source'))
                                                        <p class="help-block">{{ $errors->first('utm_source') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('utm_content') ? ' has-error' : '' }}">
                                                    <label for="utm_content">utm_content</label>
                                                    <input type="text" name="utm_content" class="form-control" readonly value="{{ isset($order) ? $order->utm_content : old('utm_content') }}">
                                                    @if($errors->has('utm_content'))
                                                        <p class="help-block">{{ $errors->first('utm_content') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('utm_term') ? ' has-error' : '' }}">
                                                    <label for="utm_term">utm_term</label>
                                                    <input type="text" name="utm_term" class="form-control" readonly value="{{ isset($order) ? $order->utm_term : old('utm_term') }}">
                                                    @if($errors->has('utm_term'))
                                                        <p class="help-block">{{ $errors->first('utm_term') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('tags') ? ' has-error' : '' }}">
                                                    <label for="tags">tags</label>
                                                    <input type="text" name="tags" class="form-control" readonly value="{{ isset($order) ? $order->tags : old('tags') }}">
                                                    @if($errors->has('tags'))
                                                        <p class="help-block">{{ $errors->first('tags') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('comments') ? ' has-error' : '' }}">
                                                    <label for="comments">comments</label>
                                                    <input type="text" name="comments" class="form-control" readonly value="{{ isset($order) ? $order->comments : old('comments') }}" readonly="">
                                                    @if($errors->has('comments'))
                                                        <p class="help-block">{{ $errors->first('comments') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('variation') ? ' has-error' : '' }}">
                                                    <label for="variation">variation</label>
                                                    <input type="text" name="variation" class="form-control" readonly value="{{ isset($order) ? $order->variation : old('variation') }}">
                                                    @if($errors->has('variation'))
                                                        <p class="help-block">{{ $errors->first('variation') }}</p>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('pickup_address') ? ' has-error' : '' }}">
                                                    <label for="pickup_address">pickup_address</label>
                                                    <input type="text" name="pickup_address" class="form-control" readonly value="{{ isset($order) ? $order->pickup_address : old('pickup_address') }}">
                                                    @if($errors->has('pickup_address'))
                                                        <p class="help-block">{{ $errors->first('pickup_address') }}</p>
                                                    @endif
                                                </div>
                                                <div class="box-footer pull-right">
                                                    <a href="{{ url('backend/logistic/orders') }}" class="btn btn-default">
                                                        Cancel
                                                    </a>
                                                </div>
                                            </div>
                                        </div>.
                                        <div class="col-md-5">
                                            <p>
                                                Logistic Status List
                                            </p>
                                            <a href="https://api.whatsapp.com/send?phone={{ str_replace('+','',$order->phone) }}&text=https://api.whatsapp.com/send?phone=6281806423887&text=Hallo%20kak%2C%20pesanan%20kakak%20dengan%20resi%20https%3A%2F%2Fwww.ninjaxpress.co%2Fen-id%2Ftracking%3Fid%3D{{ $order->receipt_number }}%20sudah%20diantarkan%20oleh%20kurir%20logistic%20Ninja%20Express%2C%20namun%20kurir%20mengalami%20kesulitan%20menemukan%20lokasi%20atau%20tidak%20ada%20orang%20dirumah%2C%20boleh%20dikonfirmasi%20untuk%20bisa%20ready%20dirumah%20saat%20kurir%20mengantarkan%20barangnya%3F%0A%0ATerimakasih" class="btn btn-xs btn-primary" target="_blank">
                                                <i class="fa fa-star"></i> Followup Pending
                                            </a>
                                            <hr/>
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>
                                                        ID
                                                    </th>
                                                    <th>
                                                        Title
                                                    </th>
                                                    <th>
                                                        Comments
                                                    </th>
                                                    <th>
                                                        Created
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($order->logistic_statuses as $status)
                                                    <tr>
                                                        <td>
                                                            {{ $status->id }}
                                                        </td>
                                                        <td>
                                                            {{ $status->status }}
                                                        </td>
                                                        <td>
                                                            {{ $status->comments }}
                                                        </td>
                                                        <td>
                                                            {{ $status->created_at }}
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
