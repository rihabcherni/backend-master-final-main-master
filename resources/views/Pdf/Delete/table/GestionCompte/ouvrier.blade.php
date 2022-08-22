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
            .img-container{
                border-radius: 20px;
                width: 40px;
                height: 40px;
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
        <h2 style="text-align: center;">Liste des ouvriers Reschool Ecology: </h2>
        <br/>
        <table>
            <tr>
                <th>Id</th>
                <th>Photo</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Carte identité</th>
                <th>Adresse</th>
                <th>Numéro télephone</th>
                <th>E-mail</th>
                <th>poste</th>
                <th colspan="2">camion</th>
                <th>Date de création</th>
                <th>Date de modification</th>
                <th style='background-color:red; color:white;'>Date de suppression</th>
            </tr>
            @foreach ($data as $l)
            <tr>
                <td> {{ $l['id'] }}</td>
                <td>
                    <?php $url = 'storage/trashImages/ouvrier/'.$l['photo'];
                    $path= public_path($url);
                    if(! file_exists($path) || $l['photo'] === null){
                        $path= public_path('storage/trashImages/ouvrier/default.jpeg');
                    }
                    ?>
                    <img class="img-container" src="{{$path }}" alt="ouvrier"/>
                </td>
                <td> {{ $l['nom'] }}</td>
                <td> {{ $l['prenom'] }}</td>
                <td> {{ $l['CIN'] }}</td>
                <td> {{ $l['adresse'] }}</td>
                <td> {{ $l['numero_telephone'] }}</td>
                <td style='color:blue; font-weight:bold;text-decoration:underline;'> {{ $l['email'] }}</td>
                <td> {{ $l['poste'] }}</td>
                <td> {{ $l['camion_id'] }}</td>
                <td> {{ $l['matricule'] }}</td>
                <td> {{ $l['created_at'] }}</td>
                <td> {{ $l['updated_at'] }}</td>
                <td style='color:red; font-weight:bold;'> {{ $l['deleted_at'] }}</td>
            </tr>
            @endforeach
        </table>

    </body>
</html>
