<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            .email-page{
                background-color: rgb(197, 251, 190);
                font-size: 16px;
                height: 100%;
                margin: 10px ;
                padding: 20px 8%;
                font-family: Arial, Helvetica, sans-serif;
            }

            .card{
               background-color:white;
               padding: 20px;
            }
            .button-login{
               background-color: rgb(50, 228, 50);
               width: 35%;
               height: 40px;
               font-weight: bold;
               color:white;
               font-size: 16px;
               border: none;
               border-radius: 5px;
            }
            .button-login a{
                color: white;
                text-decoration: none;
            }
            .img-logo{
                width: 60px;
                height:60px;
            }
            .header{
                display: grid;
                grid-template-columns: 20% 50%;

            }
            .title{
                font-size:25px;
                font-weight:bold;
                margin-top: 15px;
                color: rgb(52, 129, 52);
            }
        </style>
    </head>
    <body>
        <div class="email-page">
            <div class="card">
                <div class="header">
                    <img class="img-logo" src="{{ asset('images/logo.png') }}" alt="logo"/>
                    <p class="title">Oublier mot de passe</p>
                </div>
                <hr/>
                <p>Bonjour <b>{{  $body['user']->nom  }}   {{  $body['user']->prenom  }}</b> vous êtes  <b> {{ $body['type'] }}   Reschool ecology</b></p>

                <p>Vous venez de demander une réinitialisation du mot de passe du compte associé à cette adresse e-mail.
                    Si vous continuez à avoir des problèmes de connexion, veuillez
                    Contactez le support. Merci de votre utilisation de <b>Reschool ecology</b>!
                </p>

                <p> <b>Code de vérification:</b>  {{ $body['code'] }}</p>

                <button class="button-login"><a target="_blank" href="http://localhost:3000/modifier-mot-de-passe-oublier">réinitialiser le mot de passe</a></button>
            </div>
        </div>
    </body>
</html>
