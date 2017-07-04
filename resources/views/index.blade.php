<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

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

        th, td {
            border:  1px solid #000;
        }

        tr:hover{
            background-color: #bce8f1;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content" >
        <table cellspacing="0" border="1">
            <tr>
                <th>id</th>
                <th>Name</th>
                <th>Price</th>
                <th>Original Price</th>
                <th>Discount</th>
                <th>Buy it ?</th>
            </tr>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->getDiscountPrice() }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->getTotalDiscount()*100 }}%</td>
                    <td>
                        <button type="button" data-product="{{ $product->id }}" data-name="{{ $product->name }}" onclick="return buy( {{ $product->id }}, this);">Buy!</button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <script>
        var log = console.log.bind(console);

        function buy(product_id, elem) {
            var $elem = $(elem);

            if(!confirm('Buy product "' + $elem.data('name') + '"?')) {
                return false;
            }

            $.ajax({
                url: '/buy/' + product_id,
                method: 'POST',
                dataType: 'json'
            }).done(function (response) {
                alert('Success!');
                //$elem.closest('tr').remove();

                location.reload();

            }).fail(function (xhr, msg, errorThrown ) {
                alert('Error: ' + errorThrown);
            });

            return false;
        }

    </script>
</div>
</body>
</html>