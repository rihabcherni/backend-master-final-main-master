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
        <h2 style="text-align: center;">Détails bloc poubelle:</h2>
        <br/>
        <div>
            <table>
                <tr>
                    <th>Identifiant:</th>
                    <td  colspan="4">{{$id}}</td>
                </tr>
                <tr>
                    <th>etage:</th>
                    <td  colspan="4">{{$etage}}</td>
                </tr>
                <tr>
                    <th>bloc_etabl:</th>
                    <td  colspan="4">{{$bloc_etabl}}</td>
                </tr>
                <tr>
                    <th>etablissement:</th>
                    <td  colspan="4">{{$etablissement}}</td>
                </tr>
                <tr>
                    <th rowspan={{ count($poubelle)+1 }}>poubelle:</th>
                    <th>ID:</th>
                    <th>Nom:</th>
                    <th>Type:</th>
                    <th>Etat remplissage:</th>
                </tr>
                @for ($i=0; $i<count($poubelle);$i++)
                    <tr>
                        <td>{{$poubelle[$i]->id}}</td>
                        <td>{{$poubelle[$i]->nom}}</td>
                        <td>{{$poubelle[$i]->type}}</td>
                        <td>{{$poubelle[$i]->Etat}} %</td>
                    </tr>
                @endfor
                <tr>
                    <th>Date de création:</th>
                    <td  colspan="4">{{$created_at}}</td>
                </tr>
                <tr>
                    <th>Date de dernier modification: </th>
                    <td  colspan="4">{{$updated_at}}</td>
                </tr>
            </table>
        </div>

    </body>
</html>
