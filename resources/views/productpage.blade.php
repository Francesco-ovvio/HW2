<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta id='tkn' name='_token' content='{{ $csrf_token }}'>
        <link rel="stylesheet" type='text/css' href="{{ url('/css/style.css') }}">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Lora:ital@1&family=Open+Sans&display=swap" rel="stylesheet"> 
        <link rel="shortcut icon" href="https://i.imgur.com/an6fSnH.png">
        <script src="{{ url('/function.js') }}" defer="true"></script>
        <script src="{{ url('/script_meteo.js') }}" defer="true"></script>
        <script src="{{ url('/script_load2.js') }}" defer="true"></script>
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
                <strong>I nostri prodotti</strong>
            </h1>    
        </header>

        <!--Catalogo + Favorite-->
        <section class="type-b" name="catalogo">
            <div class="trattino"></div>
            <div class="favorite" id="favSection" >
                <h1>Preferiti</h1>
                <div class="product-grid" id="prefProd">
                    
                    <!--Qui si caricano gli elementi quando viene premuto il pulsante +-->

                </div>
            </div>

            <div class="catalogo">
                <h1>Catalogo</h1>
                
                <input type="text" id="searchBar" onkeyup="search()" placeholder="Inserisci il nome del prodotto..">

                <div class="product-grid" id='product-grid'>

                <!--Qui si caricano gli elementi in modo dinamico-->

                </div>  

                <div class="trattino"></div>
            </div>
        </section>

        <!--Footer-->
        @include('layouts.footer')
    </body>
</html>