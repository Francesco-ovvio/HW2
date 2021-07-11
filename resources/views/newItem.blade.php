<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type='text/css' href="{{ url('/css/style.css') }}">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Lora:ital@1&family=Open+Sans&display=swap" rel="stylesheet"> 
        <link rel="shortcut icon" href="https://i.imgur.com/an6fSnH.png">
        <script src="{{ url('/function.js') }}" defer="true"></script>
        <script src="{{ url('/script_meteo.js') }}" defer="true"></script>
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
                <strong>Nuovo Prodotto</strong>
            </h1>    
        </header>

        <section class='type-b'>
            <div class="trattino"></div>

            <div class="module">
                <div class="col">
                <p class='error'>{{ $error }}</p>
                    <form action='' method='post'>
                        <input type='hidden' name='_token' value='{{ $csrf_token }}'>
                        <div class="form-group">
                            <label>Nome prodotto</label>
                            <input type="text" name="nomeProd" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tipologia</label>
                            <select id='tipologia' name='tipologia' required>
                                <option value="cereale">Cereale</option>
                                <option value='latticino'>Latticino</option>
                            <select>
                        </div>
                        <div class="form-group">
                            <label>Costo per unità</label>
                            <input type="text" name="costoPerUnita" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Descrizione </br>(max 255 caratteri)</label>
                            <input type="text" name="descrizione" class="form-control" maxlength="255" required>
                        </div>
                        <div class="form-group">
                            <label>Link immagine</label>
                            <input type="url" name="image" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nome tradotto</label>
                            <input type="text" name="nomeTrad" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn" value="Aggiungi prodotto">
                        </div>
                    </form>
                </div>
            </div>

            <div class="trattino"></div>
        </section>

        <!--Footer-->
        @include('layouts.footer')
    </body>
</html>