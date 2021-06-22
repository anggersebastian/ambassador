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
            line-height: 1.3em;
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
    <div style="padding:15px; max-width:500px;">
        <p>Hi kak <strong>{{ $arg['customer'] }}</strong>,</p>
        <p>Terima kasih, Orderan anda dengan nomor invoice <strong>{{$arg['invoice']}}</strong> telah berhasil di bayar, Pesanan kakak akan segera kami proses. ditunggu ya kak... :)</p>
        <div style="margin:10px auto;">
        
        </div>
        <p style="text-align:center; margin-top:1rem;">
            <a href="{{ $arg['link'] }}" class="button button2">Lihat Orderan</a>
        </p>

        <p style="text-align:center; margin-top:1rem;"><a href="{{$arg['link_invoice']}}">Download Invoice</a></p>


        <p style="text-align:center; margin-top:1rem;">
            Butuh Bantuan ? <br/>WhatsApp <a href="https://api.whatsapp.com/send?phone=6285773281087&text=Hello%20admin">085773281087</a>
        </p>
        <p style="text-align:center; margin-top:20px;">
            Terimakasih<br/><small>no-replay@dropy.id</small>
        </p>
    </div>
</body>
</html>