<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <table>
            <tr>
                <th>id</th>
                <th>Name</th>
                <th>Price</th>
                <th>Original Price</th>
                <th>Discount</th>
                <th>-</th>
            </tr>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->getDiscountPrice() }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->getTotalDiscount() }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
</body>
</html>