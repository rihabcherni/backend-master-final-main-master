<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <style>
            .date{
                margin:-20px 0 0 85%  ;
            }
            .img-container{
                border-radius: 20px;
                width: 50px;
                height: 50px;
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
        <h2 style="text-align: center;">Liste des gestionnaires Reschool Ecology: </h2>
        <table>
            <tr>
                <th>Id:</th>
                <th>Information fournisseur:</th>
                <th>Liste des materiaux primaires:</th>
                <th>Date de création:</th>
                <th>Date de dernier modification:</th>
            </tr>
            @foreach ($data as $l)
            <tr>
                <td> {{ $l['id'] }}</td>
                <td width='410px'>
                    <table width='400px'>
                            <tr>
                                <td>
                                    <?php $url = 'storage/images/fournisseur/'.$l['photo'];
                                    $path= public_path($url);
                                    if(! file_exists($path) || $l['photo'] === null){
                                        $path= public_path('storage/images/fournisseur/default.jpeg');
                                    }
                                    ?>
                                    <img class="img-container" src="{{$path }}" alt="gestionnaire"/>
                                </td>
                                <td>
                                    <b>Nom et prénom: </b>{{ $l['nom']." ".$l['prenom'] }} <br/>
                                    <b>Carte identité national: </b>{{ $l['CIN'] }} <br/>
                                    <b>Adresse: </b>{{ $l['adresse'] }} <br/>
                                    <b>Numéro télephone: </b>{{ $l['numero_telephone'] }} <br/>
                                    <b>E-mail: </b> <span style='color:blue; font-weight:bold;text-decoration:underline;'> {{ $l['email'] }}</span> <br/>
                                </td>
                            </tr>
                    </table>
                </td>
                <td>
                    @if (count($l['Liste_matieres']) !==0)
                        <table>
                            @foreach ($l['Liste_matieres'] as $matiere)
                                <tr>
                                    <td>
                                        <b>N°: </b> {{$matiere['id'] }} <br/>
                                        <b>Nom prduit: </b> {{$matiere['nom_materiel']}} <br/>
                                        <b>Prix unitaire: </b> {{$matiere['prix_unitaire']}} <br/>
                                        <b>Quantité: </b> {{$matiere['quantite']}} <br/>
                                        <b>Prix total: </b> {{$matiere['prix_total']}} <br/>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </td>
                <td> {{ $l['created_at'] }}</td>
                <td> {{ $l['updated_at'] }}</td>
            </tr>
            @endforeach
        </table>

    </body>
</html>
