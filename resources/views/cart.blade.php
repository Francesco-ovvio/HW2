<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type='text/css' href="{{ url('/css/style.css') }}">
        <meta id='tkn' name='_token' content='{{ $csrf_token }}'>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Lora:ital@1&family=Open+Sans&display=swap" rel="stylesheet"> 
        <link rel="shortcut icon" href="https://i.imgur.com/an6fSnH.png">
        <script src="{{ url('/function.js') }}" defer="true"></script>
        <script src="{{ url('/script_meteo.js') }}" defer="true"></script>
        <script src="{{ url('/script_loadCart.js') }}" defer="true"></script>
        <title> - Fattoria Kent</title>
    </head>

    <body>
        <header>  
            @include('layouts.navbar', ['username'=>$username])
            <!--logo sull'immagine di header-->
            <div class="logo">
                <img src="https://i.imgur.com/nsxYyyC.png">
            </div>

            <h1>
                <strong>Carrello</strong>
            </h1>    
        </header>

        <section class='type-b'>
            <div class='trattino'></div>
            <div id='carrello'>
                <h1>Il tuo carrello</h1>
                <div id='tabArea'>
                    <!-- qui va la tabella cart-->
                </div>
            </div>
            <div class='trattino'></div>
        </section>

        @include('layouts.footer')
    </body>
</html>