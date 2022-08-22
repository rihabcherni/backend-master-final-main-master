<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <style>
            .date{
                margin:-20px 0 0 80%  ;
            }
            .page{
                padding:20px;
            }
            table{
                border:1px solid;
                margin: 0 auto;
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
        <h2 style="text-align: center;">Liste des blocs poubelles Reschool Ecology: </h2>
        <table>
            <tr>
                <th rowspan="2" style="width:50px;">N° bloc poubelle:</th>
                <th colspan="3">Détails localisation: </th>
                <th rowspan="2">Liste des poubelles:</th>
                <th rowspan="2">Crée le:</th>
                <th rowspan="2">Dernier modification: </th>
                <th style='background-color:red; color:white;'>Date de suppression</th>
            </tr>
            <tr>
                <th>Etage: </th>
                <th>Bloc:</th>
                <th>Etablissement:</th>
            </tr>
            @foreach ($data as $l)
            <tr>
                <td style="width:50px;"> {{ $l['id'] }}</td>
                <td> {{ $l['etage'] }}</td>
                <td> {{ $l['bloc_etabl'] }}</td>
                <td> {{ $l['etablissement'] }}</td>
                <td>
                    @foreach ( $l['poubelle'] as $p)
                    <table style="margin-bottom: 5px">
                          @if( $p['type']=== "plastique")
                              <td style="width:60px ;background-color:blue; color:white;font-weight:bold">{{ $p['type']}}</td>
                          @elseif( $p['type']=== "papier")
                              <td style="width:60px ;background-color:orange; color:white;font-weight:bold">{{ $p['type']}}</td>
                          @elseif( $p['type']=== "composte")
                              <td style="width:60px ;background-color:green; color:white;font-weight:bold">{{ $p['type']}}</td>
                          @elseif( $p['type']=== "canette")
                              <td style="width:60px ;background-color:red; color:white;font-weight:bold">{{ $p['type']}}</td>
                          @endif
                          <td>{{ $p['nom']}}</td>
                          <td  style="width:60px;">{{ $p['Etat']}} %</td>
                     </table>
                  @endforeach
                </td>
                <td  style="width:80px;">{{ $l['created_at'] }}</td>
                <td  style="width:80px;">{{ $l['updated_at'] }}</td>
                <td style='color:red; font-weight:bold;'> {{ $l['deleted_at'] }}</td>
            </tr>
            @endforeach
        </table>

    </body>
</html>
