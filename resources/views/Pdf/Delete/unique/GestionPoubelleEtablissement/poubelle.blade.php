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
        @if($type =='plastique')
            style='background-color: rgb(216, 216, 216);'
        @elseif($type =='papier')
            style='background-color: rgb(246, 234, 176);'
        @elseif($type =='composte')
            style='background-color: rgb(190, 246, 148);'
        @elseif($type =='canette')
            style='background-color: rgb(255, 197, 197);'
        @endif
    >
        <img class="img-logo" src="{{ public_path('images/logo.png') }}" alt="logo" width="50px" height="50px"/>
        <p class='date'>{{ date('d-m-Y H:i:s') }}</p>
        <hr/>
        <br/>
        <h2 style="text-align: center;">Détails poubelle: {{ $nom }}</h2>
        <br/>
        <div>
            @if($type =='plastique')
               <img class="img-container" src="{{ public_path('storage/images/stock_poubelle/bleu.png') }}" alt="poubelle"/>
            @elseif($type =='papier')
                <img class="img-container" src="{{ public_path('storage/images/stock_poubelle/jaune.png') }}" alt="poubelle"/>
            @elseif($type =='composte')
                <img class="img-container" src="{{ public_path('storage/images/stock_poubelle/vert.png') }}" alt="poubelle"/>
            @elseif($type =='canette')
                <img class="img-container" src="{{ public_path('storage/images/stock_poubelle/rouge.png') }}" alt="poubelle"/>
            @endif
        </div>
        <div>
            <table  class="table1">
                <tr>
                    <th> </th>
                    <th>Identifiant:</th>
                    <th>Nom:</th>
                </tr>
                 <tr>
                    <th>Etablissement</th>
                    <td>{{$etablissement_id}}</td>
                    <td>{{$etablissement}}</td>
                </tr>
                <tr>
                    <th>Bloc etablissement</th>
                    <td>{{$bloc_etablissement_id}}</td>
                    <td>{{$bloc_etablissement}}</td>
                </tr>
                <tr>
                    <th>Etage établissement</th>
                    <td>{{$etage_id}}</td>
                    <td>{{$etage}}</td>
                </tr>
            </table>
            <table  class="table2">
                <tr>
                    <th> </th>
                    <th>Reschool:</th>
                    <th>Etablissement:</th>
                </tr>
                <tr>
                    <th>N° poubelle </th>
                    <td>{{ $id}}</td>
                    <td>{{$poubelle_id_resp}}</td>
                </tr>
                <tr>
                    <th>Nom </th>
                    <td>{{ $nom}}</td>
                    <td>{{$nom_poubelle_responsable}}</td>
                </tr>
                <tr>
                    <th>N° bloc poubelle </th>
                    <td>{{$bloc_poubelle_id}}</td>
                    <td>{{$bloc_poubelle_id_resp}}</td>
                </tr>
            </table>
            <table  class="table3">
                 <tr>
                    <th>Type</th>
                    <td>{{$type}}</td>
                </tr>
                 <tr>
                    <th>Etat de remplissage:</th>
                    <td>{{$Etat}}</td>
                </tr>
                 <tr>
                    <th>Quantité collecté:</th>
                    <td>{{$quantite}}</td>
                    </tr>
            </table>


            <table  class="table4">
                <tr>
                    <th>Date de création:</th>
                    <td>{{$created_at}}</td>
                </tr>
                <tr>
                    <th>Date de dernier modification: </th>
                    <td>{{$updated_at}}</td>
                </tr>
                <tr>
                    <th style='background-color:red; color:white;'>Date de suppression</th>
                    <td style='color:red;'>{{$deleted_at}}</td>
                </tr>
            </table>
        </div>

    </body>
</html>
