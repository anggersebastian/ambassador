<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Order</title>
    <style>
        body{
            background-color: #F5F5F5;
            font-family: "Open Sans", sans-serif;
            font-size: 14px;
            text-rendering: optimizeLegibility;
            word-wrap: break-word;
        }

        p{
            padding: 0px;
            margin: 0px;
        }
        div{
            display: block;
        }
        .button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 13px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            transition-duration: 0.4s;
            cursor: pointer;
            text-align: center;
        }

        .button2 {
            background-color: white; 
            color: black; 
            border: 2px solid #008CBA;
        }

        .button2:hover {
            background-color: #008CBA;
            color: white;
        }

        .button5:hover {
            background-color: #555555;
            color: white;
        }
        .text-center{
            text-align: center;
        }

        table, td, th {  
            border: 1px solid #ddd;
            text-align: left;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 15px;
        }
    </style>
</head>
<body>
    <div style="padding:15px;">
        <p>Hi kak <strong>{{ $arg['adminName'] }}</strong>,</p>
        <p>Orderan baru dari <strong>{{$arg['customer']}}</strong> dengan nomor invoice <strong>{{$arg['invoice']}}</strong></p>
        <div style="margin-top:10px;">
            <table>
                <tr>
                    <th>Nama Produk</th>
                    <th>Type</th>
                    <th>Quantity</th>
                </tr>
                @foreach ($arg['detail'] as $value)
                    <tr>
                        <td>{{$value->product->name}}</td>
                        <td>{{$value->variations ? $value->variations->value : 'None' }}</td>
                        <td>{{$value->quantity }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" style="text-align:center;">Harga Produk Rp {{ number_format($arg['product_price']) }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:center;">Ongkos Kirim Rp {{ number_format($arg['shipping_fee']) }}</td>
                </tr>
                @if ($arg['paid_with'] == 'cod')
                    <tr>
                        <td colspan="3" style="text-align:center;">COD Fee Rp {{ number_format($arg['cod_fee']) }}</td>
                    </tr>
                @else 
                    <tr>
                        <td colspan="3" style="text-align:center;">Kode Unik Rp {{ number_format($arg['unique_fee']) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align:center;">Biaya Transfer Rp 4.400</td>
                    </tr>
                @endif
                <tr>
                    <td colspan="3" style="text-align:center; font-weight:bold;">TOTAL Rp {{ number_format($arg['total_price'] + 4400) }}</td>
                </tr>
            </table>
        </div>
        <p style="text-align:center; margin-top:1rem;">
            <a href="{{ $arg['link'] }}" class="button button2">Lihat Orderan</a>
        </p>
    </div>
</body>
</html>