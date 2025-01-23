<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css" />
    <script type="text/javascript" src="public/js/script.js" defer></script>
    <script type="text/javascript" src="public/js/search.js" defer></script>
    <title>BiblioSolis</title>
    <meta charset="UTF-8">
</head>

<body>
    <div class="book-add-view" id="book-add-view">
        <div class="book-add-popup">
            <div class="book-add-header">
                <div>Dodaj książkę</div>
                <div class="book-add-close" id="book-add-close">x</div>
            </div>
            <div class="book-add-main">
                <?php
                if(isset($messages)) {
                    foreach($messages as $message) {
                        echo $message;
                    }
                } ?>
                <form action="addBook" method="POST" ENCTYPE="multipart/form-data">
                    <input name="title" type="text" placeholder="Tytuł" class="book-add-component">
                    <div class="authors-dropdown">
                        <div class="authors-dropdown-header">
                            <span id="authors-dropdown-selected">Dodaj autora</span>
                        </div>
                        <div class="authors-dropdown-list">
                            <div class="authors-dropdown-search">
                                <input type="text" id="authors-search-input" placeholder="Szukaj...">
                            </div>
                            <?php foreach($authors as $author): ?>
                                <label>
                                    <input id="<?= $author->getName()." ".$author->getSurname() ?>" type="checkbox" name="author[]" value="<?= $author->getID() ?>">
                                    <?= $author->getName()." ".$author->getSurname() ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    </select>
                    <select name="genre" class="book-add-component">
                        <?php foreach($genres as $genre): ?>
                            <option value="<?= $genre->getID() ?>"><?= $genre->getGenreName() ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="publisher" class="book-add-component">
                        <?php foreach($publishers as $publisher): ?>
                            <option value="<?= $publisher->getID() ?>"><?= $publisher->getPublisherName() ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input name="cover" type="file" placeholder="Okładka" class="book-add-component">
                    <div class="book-add-buttons">
                        <button type="submit" class="book-add-button">Dodaj</button>
                        <div class="book-add-button" id="book-cancel-button">Anuluj</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <header>
        <div class="menu">
            <img src="public/img/menu.svg" class="menu-button" id="menu-button">
            <div class="mobile-nav">
                <img src="public/img/menu.svg" class="menu-button" id="mobile_menu_button">
                <ul>
                    <li class="books-new">Nowości</li>
                    <li class="books-popular">Popularne</li>
                    <li class="books-alphabetical">Alfabetycznie</li>
                    <li class="books-publisher">Wydawnictwo</li>
                    <li class="books-genres">Gatunki</li>
                    <div class="search-component">
                        <div class="search-pair" id="search-pair">
                            <div class="search-text">Wyszukaj</div>
                            <button class="button-decoration"><img src="public/img/search.svg"></button>
                        </div>
                        <div class="search-popup">
                            <div class="search-pair">
                                <input name="search-input" placeholder="Wyszukaj...">
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
            <input name="search-input" placeholder="Wyszukaj...">
            <button class="search-button"><img src="public/img/search.svg"></button>
            <div class="user-component">
                <button id="user-button"><img src="public/img/user.svg"></button>
                <div class="user-popup">
                    <ul>
                        <li>Logout</li>
                        <li id="book-add-open">Dodaj książkę</li>
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
                <div class="nav-element books-new">
                    <div class="nav-text">
                        Nowości
                    </div>
                    <div class="nav-line">

                    </div>
                </div>
                <div class="nav-element books-popular">
                    <div class="nav-text">
                        Popularne
                    </div>
                    <div class="nav-line">

                    </div>
                </div>
                <div class="nav-element books-alphabetical">
                    <div class="nav-text">
                        Alfabetycznie
                    </div>
                    <div class="nav-line">

                    </div>
                </div>
                <div class="nav-element books-publisher">
                    <div class="nav-text">
                        Wydawnictwo
                    </div>
                    <div class="nav-line">

                    </div>
                </div>
                <div class="nav-element books-genres">
                    <div class="nav-text">
                        Gatunki
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
            <?php foreach($books as $book): ?>
            <div class="book-card">
                <div class="book-cover">
                    <img src="/public/uploads/<?= $book->getCover() ?>">
                </div>
                <div class="book-details">
                    <p><strong>Tytuł:</strong> <?= $book->getTitle() ?></p>
                    <p><strong>Autor/rzy:</strong>
                        <?php foreach($book->getAuthors() as $author): ?>
                            <?= $author->getName()." ".$author->getSurname()."&nbsp&nbsp&nbsp&nbsp" ?>
                        <?php endforeach; ?>
                    </p>
                    <p><strong>Gatunek:</strong> <?= $book->getGenre() ?></p>
                    <p><strong>Wydawca:</strong> <?= $book->getPublisher() ?></p>
                    <p><strong>Status:</strong> Dostępne</p>
                </div>
                <button class="borrow-button">Wypożycz</button>
            </div>
            <?php endforeach; ?>
        </section>
        <div class="page-nav">
            <button>1</button>
            <button>2</button>
            <button>3</button>
            <button>></button>
        </div>
    </main>
</body>
<template id="book-template">
    <div class="book-card">
        <div class="book-cover">
            <img src="">
        </div>
        <div class="book-details">
            <p id="title"></p>
            <p id="authors">
            </p>
            <p id="genre"></p>
            <p id="publisher"></p>
            <p><strong>Status:</strong> Dostępne</p>
        </div>
        <button class="borrow-button">Wypożycz</button>
    </div>
</template>
</html>