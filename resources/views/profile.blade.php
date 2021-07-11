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
        <script src="{{ url('/script_loadOrders.js') }}" defer="true"></script>
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
                <strong>Profilo</strong>
            </h1>    
        </header>
        
        
        <section class = 'type-b'>
            <div class='trattino'></div>

            <div class='profileinfo'>
                <p>Il tuo profilo</p>
                <h1>Partita IVA: <span id="userData">{{session('cliente_id')}}</span></h1>
                <h1>Nome: <span id="userData">{{session('nome')}}</span></h1>
                <h1>Cognome: <span id="userData">{{session('cognome')}}</span></h1>
                <h1>E-Mail: <span id="userData">{{session('email')}}</span></h1>
                <h1>Indirizzo: <span id="userData">{{session('indirizzo')}}</span></h1>
            </div>
            @if($privileges == 1)
                <h1>
                    <a class='button' href="{{ url('admin/newItem') }}">Nuovo prodotto</a>
                    <a class='button' href="{{ url('admin/regProd') }}">Registra produzione</a>
                </h1>
            @endif
            <div class='trattino'></div>
        </section>

        <section class='type-b'>
            <div class='trattino'></div>

            <div class='profileinfo' id='ordini'>
                <p>I tuoi ordini</p>
                <input id='searchBar' onkeyup='searchTable()' type='text'>
                <div id='tabellaOrdini'>
                    <table id='cartTable'>
                        <tr id='tableHeader'>
                            <th>ID Ordine</th>
                            <th>Nome</th>
                            <th>Quantità</th>
                            <th>Data</th>
                            <th>Costo totale</th>
                            <th>Evaso</th>
                            @if($privileges == 1)
                            <th id='idcli'>ID Cliente</th>
                            @endif
                        </tr>
                    </table>
                </div>
            </div>
                
            <div class='trattino'></div>
        </section>

        <!--Footer-->
        @include('layouts.footer')
    </body>
</html>