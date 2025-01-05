<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css" />
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
                    <li>Autorzy</li>
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
                        Autorzy
                    </div>
                    <div class="nav-line">

                    </div>
                </div>
            </ul>
        </nav>
        <div class="page-nav">
            <button>1</button>
            <button>2</button>
            <button>3</button>
            <button>></button>
        </div>
        <section class="book-list">
            <div class="book-card">
                <div class="book-cover" style="background-color: #d77;"></div>
                <div class="book-details">
                    <p><strong>Tytuł:</strong> Tytuł przykładowy</p>
                    <p><strong>Autor:</strong> Autor książki</p>
                    <p><strong>Gatunek:</strong> Gatunek książki</p>
                    <p><strong>Wydawca:</strong> Wydawnictwo</p>
                    <p><strong>Status:</strong> Dostępne</p>
                </div>
                <button class="borrow-button">Wypożycz</button>
            </div>
            <div class="book-card">
                <div class="book-cover" style="background-color: #d77;"></div>
                <div class="book-details">
                    <p><strong>Tytuł:</strong> Tytuł przykładowy</p>
                    <p><strong>Autor:</strong> Autor książki</p>
                    <p><strong>Gatunek:</strong> Gatunek książki</p>
                    <p><strong>Wydawca:</strong> Wydawnictwo</p>
                    <p><strong>Status:</strong> Dostępne</p>
                </div>
                <button class="borrow-button">Wypożycz</button>
            </div>
            <div class="book-card">
                <div class="book-cover" style="background-color: #d77;"></div>
                <div class="book-details">
                    <p><strong>Tytuł:</strong> Tytuł przykładowy</p>
                    <p><strong>Autor:</strong> Autor książki</p>
                    <p><strong>Gatunek:</strong> Gatunek książki</p>
                    <p><strong>Wydawca:</strong> Wydawnictwo</p>
                    <p><strong>Status:</strong> Dostępne</p>
                </div>
                <button class="borrow-button">Wypożycz</button>
            </div>
            <div class="book-card">
                <div class="book-cover" style="background-color: #d77;"></div>
                <div class="book-details">
                    <p><strong>Tytuł:</strong> Tytuł przykładowy</p>
                    <p><strong>Autor:</strong> Autor książki</p>
                    <p><strong>Gatunek:</strong> Gatunek książki</p>
                    <p><strong>Wydawca:</strong> Wydawnictwo</p>
                    <p><strong>Status:</strong> Dostępne</p>
                </div>
                <button class="borrow-button">Wypożycz</button>
            </div>
            <div class="book-card">
                <div class="book-cover" style="background-color: #d77;"></div>
                <div class="book-details">
                    <p><strong>Tytuł:</strong> Tytuł przykładowy</p>
                    <p><strong>Autor:</strong> Autor książki</p>
                    <p><strong>Gatunek:</strong> Gatunek książki</p>
                    <p><strong>Wydawca:</strong> Wydawnictwo</p>
                    <p><strong>Status:</strong> Dostępne</p>
                </div>
                <button class="borrow-button">Wypożycz</button>
            </div>
            <div class="book-card">
                <div class="book-cover" style="background-color: #d77;"></div>
                <div class="book-details">
                    <p><strong>Tytuł:</strong> Tytuł przykładowy</p>
                    <p><strong>Autor:</strong> Autor książki</p>
                    <p><strong>Gatunek:</strong> Gatunek książki</p>
                    <p><strong>Wydawca:</strong> Wydawnictwo</p>
                    <p><strong>Status:</strong> Dostępne</p>
                </div>
                <button class="borrow-button">Wypożycz</button>
            </div>
        </section>
        <div class="page-nav">
            <button>1</button>
            <button>2</button>
            <button>3</button>
            <button>></button>
        </div>
    </main>
</body>

</html>