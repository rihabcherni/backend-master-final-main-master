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
    <body class="page"  >
        <img class="img-logo" src="{{ public_path('images/logo.png') }}" alt="logo" width="50px" height="50px"/>
        <p class='date'>{{ date('d-m-Y H:i:s') }}</p>
        <hr/>
        <br/>
        <h2 style="text-align: center;">Détails client dechets: {{ $nom }}  {{ $prenom }}</h2>
        <br/>
        <div>
            <table >
                <tr>
                    <th>Identifiant:</th>
                    <td>{{$id}}</td>
                </tr>
                <tr>
                    <th>Nom entreprise:</th>
                    <td>{{$nom_entreprise}}</td>
                </tr>
                <tr>
                    <th>Matricule fiscale: </th>
                    <td>{{ $matricule_fiscale }}</td>
                </tr>
                <tr>
                    <th>Nom: </th>
                    <td>{{ $nom }}</td>
                </tr>
                <tr>
                    <th>Prénom: </th>
                    <td>{{ $prenom }}</td>
                </tr>
                <tr>
                    <th>Numéro fixe:</th>
                    <td>{{ $numero_fixe }}</td>
                </tr>
                <tr>
                    <th>Adresse:</th>
                    <td>{{ $adresse }}</td>
                </tr>
                <tr>
                    <th>Numéro télephone:</th>
                    <td>{{ $numero_telephone }}</td>
                </tr>
                <tr>
                    <th>E-mail:</th>
                    <td style='color:blue; font-weight:bold;text-decoration:underline;'> {{ $email }}</td>
                </tr>
                <tr>
                    <th>Date de création:</th>
                    <td>{{$created_at}}</td>
                </tr>
                <tr>
                    <th>Date de dernier modification: </th>
                    <td>{{$updated_at}}</td>
                </tr>
            </table>
        </div>

    </body>
</html>
