<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>

        <style>
            td {
                padding: 2px 10px;
                margin: 0;
            }

            tr:nth-child(odd) {
                background-color: #eee;
            }
        </style>
    </head>
    <body>
        <table>
            @foreach ($answers as $answer)
                <tr>
                    <td>{{ $answer->id }}</td>
                    <td>{{ $answer->image }}</td>
                    <td>{{ $answer->answer }}</td>
                </tr>
            @endforeach
        </table>
    </body>
</html>
