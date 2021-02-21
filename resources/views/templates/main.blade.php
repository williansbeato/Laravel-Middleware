<html>
    <head>
        <title>SISAR @yield('titulo')</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <style>
            body{ padding:40px;}
            .navbar{margin-bottom:30px;}
            .card{margin:20px;}
            .card-header{color: #000;}
        </style>
    </head>

    <body>
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ url('/') }}"><b>SISAR</b></a>
            <div class="collapse navbar-collapse flex-row-reverse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                   

                    <li class="nav-item active" class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            <b>Home</b>
                        </a>
                    </li>

                    
                                     
                </ul>
            </div>

        </nav>

        <div class="card">
            <div class="card-header bg-dark">
                <h3><b style="color: white";>{{ $titulo }}</b></h2>
            </div>
            <div class="card-body">
                @yield("conteudo")
            </div>
        </div>

    </body>
    <footer>
        <b>&copy;2021 - Willians Beato.</b>
    </footer>

    <script src="{{asset('js/app.js')}}" type="text/javascript"></script>

    @yield('script')


</html>