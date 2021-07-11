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
            <!--Qui ci sta la navbar-->
            @include('layouts.navbar', ['username'=>$username])
            <!--logo sull'immagine di header-->
            <div class="logo">
                <img src="https://i.imgur.com/nsxYyyC.png">
            </div>

            <h1>
                <strong>Login</strong>
            </h1>    
        </header>

        <section class="type-b">
            <div class="trattino"></div>
            <div class="module">
                <div class="col">
                    <p>Inserisci email e password</p>
                    @if($error != '')
                    <p>{{ $error }}</p>
                    @endif
                    <!--Qui ci stava $error-->
                    <form method="post">
                        <input type='hidden' name='_token' value='{{ $csrf_token }}'>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="username" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn" value="Accedi">
                        </div>
                        <p>Non hai un account?</br><a href="{{ url('register') }}"> Registrati qui</a></p>
                    </form>
                </div>
            </div>
            <div class="trattino"></div>
        </section>

        <!--Qui ci sta il footer-->
        @include('layouts.footer')
    </body>
</html>