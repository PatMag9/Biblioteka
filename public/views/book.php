<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css" />
    <script type="text/javascript" src="public/js/script.js" defer></script>
    <title>BiblioSolis</title>
    <meta charset="UTF-8">
</head>

<body>
    <header>
        <div class="menu">
            <img src="public/img/menu.svg">
            <div class="mobile-nav">
                <img src="public/img/menu.svg">
                <ul>
                    <li>Nowości</li>
                    <li>Popularne</li>
                    <li>Alfabetycznie</li>
                    <li>Wydawnictwo</li>
                    <li>Gatunki</li>
                    <div class="search-component">
                        <div class="search-pair">
                            <div class="search-text">Wyszukaj</div>
                            <button class="button-decoration"><img src="public/img/search.svg"></button>
                        </div>
                        <div class="search-popup">
                            <div class="search-pair">
                                <input type="search-input" placeholder="Wyszukaj...">
                                <button class="search-button-mobile"><img src="public/img/search.svg"></button>
                            </div>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
        <div class="header-logo">
            <img src="public/img/logo_outline.svg">
            <div class="banner">BiblioSolis</div>
        </div>
        <div class="right-side">
            <input type="search-input" placeholder="Wyszukaj...">
            <button class="search-button"><img src="public/img/search.svg"></button>
            <div class="user-component">
                <button><img src="public/img/user.svg"></button>
                <div class="user-popup">
                    <ul>
                        <li>Logout</li>
                        <li>option 2</li>
                        <li>option 3</li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    
    <main>
        <h2>Katalog Biblioteki BiblioSolis</h2>
        <nav>
            <ul>
                <div class="nav-element">
                    <div class="nav-text">
                        Nowości
                    </div>
                    <div class="nav-line">

                    </div>
                </div>
                <div class="nav-element">
                    <div class="nav-text">
                        Popularne
                    </div>
                    <div class="nav-line">

                    </div>
                </div>
                <div class="nav-element">
                    <div class="nav-text">
                        Alfabetycznie
                    </div>
                    <div class="nav-line">

                    </div>
                </div>
                <div class="nav-element">
                    <div class="nav-text">
                        Wydawnictwo
                    </div>
                    <div class="nav-line">

                    </div>
                </div>
                <div class="nav-element">
                    <div class="nav-text">
                        Gatunki
                    </div>
                    <div class="nav-line">

                    </div>
                </div>
            </ul>
        </nav>
        <section class="book-list">
            <div class="book-page">
                <div class="book-info">
                    <div class="book-cover" style="background-color: #d77;"></div>
                    <div class="book-details">
                        <p><strong>Tytuł:</strong> Tytuł przykładowy</p>
                        <p><strong>Autor:</strong> Autor książki</p>
                        <p><strong>Gatunek:</strong> Gatunek książki</p>
                        <p><strong>Wydawca:</strong> Wydawnictwo</p>
                        <p><strong>Status:</strong> Dostępne</p>
                    </div>
                </div>
                <div class="book-bottom">
                    <hr class="divider">
                    <button class="borrow-button">Wypożycz</button>
                </div>
            </div>
        </section>
    </main>
</body>

</html>