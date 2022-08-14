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
                border:2px rgb(198, 106, 210) dashed;
                width: 180px;
                height: 180px;
                margin-left: 20px;
            }
            .page{
                padding:20px;
            }
            .table1{
                margin:0  0 0 240px;
                margin-top: -180px;
            }
            .table2{
                margin:0  0 0 240px;
                margin-top: 15px;
            }
            .table3{
                margin-top: -150px;
            }
            .table4{
                margin:30px 0 0 22% ;
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
    <body class="page"
        {{--  @if($type =='plastique')
            style='background-color: rgb(216, 216, 216);'
        @elseif($type =='papier')
            style='background-color: rgb(246, 234, 176);'
        @elseif($type =='composte')
            style='background-color: rgb(190, 246, 148);'
        @elseif($type =='canette')
            style='background-color: rgb(255, 197, 197);'
        @endif  --}}
    >
        <img class="img-logo" src="{{ public_path('images/logo.png') }}" alt="logo" width="50px" height="50px"/>
        <p class='date'>{{ date('d-m-Y H:i:s') }}</p>
        <hr/>
        <br/>
        <h2 style="text-align: center;">Détails poubelle: </h2>
        <br/>
        <table>
            <tr>
                <th colspan="3">Reschool</th>
                <th colspan="3">etablissement</th>
                <th colspan="3">Détails poubelle</th>
                <th colspan="3">Détails emplacement poubelle</th>
                <th colspan="2">Date</th>
            </tr>
            <tr>
                <th>N°</th>
                <th>nom</th>
                <th>N°  bloc poubelle</th>

                <th>N°</th>
                <th>nom</th>
                <th>N°  bloc poubelle</th>

                <th>Type</th>
                <th>Etat</th>
                <th>Quantité</th>

                <th>etablissement</th>
                <th>Bloc etablissement</th>
                <th>etage</th>
                <th>Crée le</th>
                <th>Modifié le</th>
            </tr>
            @foreach ($data as $l)
            <tr>
                <td> {{ $l['id'] }}</td>
                <td> {{ $l['nom'] }}</td>
                <td> {{ $l['bloc_poubelle_id'] }}</td>

                <td> {{ $l['poubelle_id_resp'] }}</td>
                <td> {{ $l['nom_poubelle_responsable'] }}</td>
                <td> {{ $l['bloc_poubelle_id_resp'] }}</td>

                <td> {{ $l['type'] }}</td>
                <td> {{ $l['Etat'] }}</td>
                <td> {{ $l['quantite'] }}</td>

                <td> {{ $l['etablissement'] }}</td>
                <td> {{ $l['bloc_etablissement'] }}</td>
                <td> {{ $l['etage'] }}</td>
                <td> {{ $l['created_at'] }}</td>
                <td> {{ $l['updated_at'] }}</td>
            </tr>
            @endforeach
        </table>

    </body>
</html>
