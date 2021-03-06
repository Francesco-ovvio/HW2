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
                <strong>Commercio di latticini e cereali</strong></br>
                <a class="button" href="{{ url('products') }}">Ordina i nostri prodotti</a>
            </h1>    
        </header>

        <!--Sezione Slogan-->
        <section class="type-a" name="slogan">
            <div class="trattino"></div>
            <em>La Fattoria Kent é un’azienda agricola in conduzione biologica da sempre.<br> 
            Si estende per circa 100 ettari ed è il frutto dell’esperienza di quattro generazioni di pastori.</em>
            <div class="trattino"></div>
        </section>

        <!--Sezioni informativa Dati Ismea-->
        <section class="type-c">
            <section class="dati" name="sx">
                <div class="trattino"></div>
                <p><strong>Scarica tutti i dati aggiornati sui prezzi dei cereali.</strong></br></p>
                <h1><a class="button" href="http://www.ismeamercati.it/flex/tmp/xls/e28704c622635c49cec5ab2c3e7dd201.xlsx">Scarica i dati in formato Excel</a></h1>
                <div class="trattino"></div>
            </section>
            <section class="dati" name="dx">
                <div class="trattino"></div>
                <p><strong>Scarica tutti i dati aggiornati sui prezzi dei latticini.</strong></br></p>
                <h1><a class="button" href="http://www.ismeamercati.it/flex/tmp/xls/1bf744b9287ba216decaa7094eb9337f.xlsx">Scarica i dati in formato Excel</a></h1>
                <div class="trattino"></div>
            </section>
        </section>

        <!--Sezione notizia 1-->
        <section class="type-b" name="sheep">
            <div class="trattino"></div>
            <div class="warpflex">
                <div><img src="https://i.imgur.com/UkGHVqu.jpg"></div>
                <p>La Fattoria Kent offre tanti diversi tipi di formaggi a base di latte di pecora: una selezione di sapori e accostamenti adatti a ogni gusto. </br>
                    I nostri clienti potranno scegliere tra i formaggi aromatizzati al pepe nero, al pistacchio, al pepe rosso, alle olive, rucola e peperoncino, alla rucola, alla 'nduja, allo zafferano, alla curcuma o allo zenzero. </br>
                    I formaggi ovini di nostra produzione si dividono in primo sale, semistagionati e stagionati: sapori diversi per offrirsi a diverse esigenze.
                </p> 
            </div>
            <div class="trattino"></div>  
        </section>

        <!--Sezione notizia 2-->
        <section class="type-b" name="wheat">
            <div class="trattino"></div>
            <div class="warpflex">
                <p>L’agricoltura biologica non si limita a produrre alimenti privi di residui tossici, </br>
                    riducendo al minimo l’impatto ambientale, ma si preoccupa anche di portare sul mercato prodotti perfettamente integri nel loro valore nutritivo: sani e genuini.</p>
                <div><img src="https://i.imgur.com/F08Vacb.jpg"></div>
            </div>
            <div class="trattino"></div> 
        </section>

        @include('layouts.footer')
    </body>
</html>