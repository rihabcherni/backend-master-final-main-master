<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <style>
            .date{
                margin:-20px 0 0 75%  ;
            }
            .page{
                padding:20px;
            }
            table{
                border:1px solid;
            }
             td , th{
                border:1px solid;
                font-size:14px;
                padding:10px;
                text-align: left;
            }
        </style>
    </head>
    <body class="page">
        <img class="img-logo" src="{{ public_path('images/logo.png') }}" alt="logo" width="50px" height="50px"/>
        <p class='date'>{{ date('d-m-Y H:i:s') }}</p>
        <hr/>
        <br/>
        <h2 style="text-align: center;">Liste des dechets Reschool Ecology: </h2>        <br/>
        <table>
            <tr>
                <th>Id:</th>
                <th>Photo:</th>
                <th>Type dechet:</th>
                <th>Prix unitaire:</th>
                <th>Pourcentage remise:</th>
                <th>Date de création:</th>
                <th>Date de dernier modification: </th>
            </tr>
            @foreach ($data as $l)
            <tr>
                <td> {{ $l['id'] }}</td>
                <td>
                    <?php $url = 'storage/images/dechet/'.$l['photo'];
                    $path= public_path($url);
                    if(! file_exists($path) || $l['photo'] === null){
                        $path= public_path('storage/images/dechet/default.jpeg');
                    }
                    ?>
                    <img class="img-container" src="{{$path }}" alt="dechet"/>
                </td>
                <td>{{ $l['type_dechet'] }}</td>
                <td>{{ $l['prix_unitaire'] }} DT</td>
                <td>{{ $l['pourcentage_remise'] }} %</td>
                <td>{{ $l['created_at'] }}</td>
                <td>{{ $l['updated_at'] }}</td>
            </tr>
            @endforeach
        </table>

    </body>
</html>
