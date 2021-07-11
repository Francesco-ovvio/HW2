<nav>
                <!--NavBar Desktop-->
                <div class="menu" name="sx">
                    <a class="button" href="{{ url('home') }}">HomePage</a>
                    <a class="button" href="#">Cereali</a>
                    <a class="button" href="#">Latticini</a>
                    <a class="button" href="#">About</a>
                </div>

                <div class="dx">
                    
                    <div class="menu">
                        <!--qui ci stava il checklog-->
                        @if($username != '')
                            <h1>Benvenuto {{ $username }} </h1>
                            <a class="button" href="{{ url('logout') }}">Logout</a>
                            <a class="button" href="{{ url('profile') }}">Profilo</a>
                            <a class="button" href="{{ url('cart') }}">Carrello</a>  
                        @else
                            <a class="button" href="{{ url('login') }}">Login</a>
                        @endif
                    </div>
                    <div class="logopicc">
                        <img src="https://i.imgur.com/muJjK01.png">
                    </div>
                </div>

                <!--NavBar Mobile v2-->
                <div id="mobile">
                    <div id="MySidenav" class="sidenav">
                        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                        @if($username != '')
                            <h1><br><br>Benvenuto {{ $username }}</h1>
                            <a href="{{ url('profile') }}">Profilo</a>
                            <a href="{{ url('cart') }}">Carrello</a>
                            <a href="{{ url('products') }}">Shop</a>
                            <a href="{{ url('logout') }}">Logout</a>
                        @else
                            <a href="{{ url('login') }}">Login</a>
                        @endif
                        <a href="{{ url('home') }}">HomePage</a>
                        <a href="#">Cereali</a>
                        <a href="#">Latticini</a>
                        <a href="#">About</a>
                    </div>
                    <span id="burger" onclick="openNav()">&#9776; Menu</span>
                </div>
            </nav>