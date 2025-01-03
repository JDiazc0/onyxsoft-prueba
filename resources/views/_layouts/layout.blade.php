<header class="site-header">
    <div class="site-identity">
        <h1><a href="#">Prueba OnyxSoft</a></h1>
    </div>
    <nav class="site-navigation">
        <ul class="nav">
            <li><a href="/books">Libros</a></li>
            <li><a href="/authors">Autores</a></li>
        </ul>
    </nav>
</header>

<body>
    <main>
        @yield('content')
    </main>
</body>
<style>
    body {
        font-family: Helvetica;
        margin: 0;
    }

    a {
        text-decoration: none;
        color: #000;
    }

    .site-header {
        border-bottom: 1px solid #ccc;
        padding: .5em 1em;
        display: flex;
        justify-content: space-between;
        background-color: white;
    }

    .site-identity h1 {
        font-size: 1.5em;
        margin: .6em 0;
        display: inline-block;
    }


    .site-navigation ul,
    .site-navigation li {
        margin: 0;
        padding: 0;
    }

    .site-navigation li {
        display: inline-block;
        margin: 1.4em 1em 1em 1em;
    }

    main {
        padding-top: 1em;
    }
</style>