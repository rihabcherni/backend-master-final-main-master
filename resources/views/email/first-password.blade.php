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
               width: 25%;
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
    {{--  <script type="text/javascript" src="http://static.runoob.com/assets/qrcode/qrcode.min.js"></script>
    <div id="qrcode" style="height:150px;width:150px;" v-loading="PanoramaInfo.bgenerateing"></div>  --}}
    <body>
        {{--  <script type="text/javascript">
            let qrcode = new QRCode(document.getElementById("qrcode"),
            {
                    text: "http://www.runoob.com",
                    colorDark : "#000000",
                    colorLight : "#ffffff",
                    correctLevel : QRCode.CorrectLevel.H
            });
            setTimeout(
            function () {
                let dataUrl = document.querySelector('#qrcode').querySelector('img').src;
                const img = new Image(100, 100); // width, height
                img.src = dataUrl;
                document.body.appendChild(img);
            }
            ,0);
        </script>  --}}
        <div class="email-page">
            <div class="card">
                <div class="header">
                    <img class="img-logo" src="{{ asset('images/logo.png') }}" alt="logo"/>
                    <p class="title">Nouveau mot de passe</p>
                </div>
                <hr/>
                    <p>Bonjour <b>{{  $body['nom']  }}   {{  $body['prenom']  }}</b>    </p>
                    <p>
                        Nous sommes très heureux que vous ayez accepté  de devenir un membre à notre projet et nous sommes impatients de vous compter parmi nous.
                    </p>
                    <p>
                        Au nom de <b>Reschool ecology</b> , nous somme ravi de vous accueillir dans notre entreprise,
                        dans l’attente de vous connecter,
                    </p>
                     <p> <b>Mot de passe:</b>  {{ $body['password'] }}</p>
                <button class="button-login"><a target="_blank" href="https://reschoolecology.tech">Login</a></button>
            </div>
        </div>
    </body>
</html>


