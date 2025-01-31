<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../public/css/style.css" />
    <script type="text/javascript" src="../public/js/script.js" defer></script>
    <script type="text/javascript" src="../public/js/search.js" defer></script>
    <?php if($_SESSION["isAdmin"]===true)
        echo '<script type="text/javascript" src="../public/js/addBook.js" defer></script>';
    ?>
    <title>BiblioSolis</title>
    <meta charset="UTF-8">
</head>

<body>
    <div id="sessionID" style="display: none;">
        <?php
        echo $_SESSION['id'];
        ?>
    </div>
    <?php if($_SESSION["isAdmin"]===true): ?>
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
    <?php endif; ?>
    <header>
        <div class="menu">
            <img src="../public/img/menu.svg" class="menu-button" id="menu-button">
            <div class="mobile-nav">
                <img src="../public/img/menu.svg" class="menu-button" id="mobile_menu_button">
                <ul>
                    <li class="books-new">Nowości</li>
                    <li class="books-popular">Popularne</li>
                    <li class="books-alphabetical">Alfabetycznie</li>
                    <li class="books-publisher">Wydawnictwo</li>
                    <li class="books-genres">Gatunki</li>
                    <div class="search-component">
                        <div class="search-pair" id="search-pair">
                            <div class="search-text">Wyszukaj</div>
                            <button class="button-decoration"><img src="../public/img/search.svg"></button>
                        </div>
                        <div class="search-popup">
                            <div class="search-pair">
                                <input name="search-input" placeholder="Wyszukaj...">
                                <button class="search-button-mobile" id="search-button"><img src="../public/img/search.svg"></button>
                            </div>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
        <div class="header-logo">
            <a href="../main"><img src="../public/img/logo_outline.svg"></a>
            <div class="banner">BiblioSolis</div>
        </div>
        <div class="right-side">
            <input name="search-input" placeholder="Wyszukaj...">
            <button class="search-button" id="search-button"><img src="../public/img/search.svg"></button>
            <div class="user-component">
                <button id="user-button"><img src="../public/img/user.svg"></button>
                <div class="user-popup">
                    <ul>
                        <a href="../logout"><li>Wyloguj</li></a>
                        <?php if($_SESSION["isAdmin"]===true)
                            echo '<li id="book-add-open">Dodaj książkę</li>';
                        ?>
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
            <button class="prev-page"><</button>
            <div class="page-numbers">
                <?php for ($i = 1; $i <= $pages; $i++) :?>
                    <button page-active="false" page-id="<?php echo $i-1 ?>"><?php echo $i ?></button>
                <?php endfor; ?>
            </div>
            <button class="next-page">></button>
        </div>
        <section class="book-list">
            <?php foreach($books as $book): ?>
            <div class="book-card">
                <div class="book-cover">
                    <a href="../book/<?= $book->getID() ?>">
                        <img src="/../public/uploads/<?= $book->getCover() ?>">
                    </a>
                </div>
                <div class="book-details">
                    <p><strong>Tytuł:</strong> <a href="../book/<?= $book->getID() ?>"><?= $book->getTitle() ?></a></p>
                    <p><strong>Autor/rzy:</strong>
                        <?php
                        $authors = $book->getAuthors();
                        $authorList = [];

                        foreach($authors as $author) {
                            $authorList[] = $author->getName()." ".$author->getSurname();
                        }

                        echo implode(", ", $authorList);
                        ?>
                    </p>
                    <p><strong>Gatunek:</strong> <?= $book->getGenre() ?></p>
                    <p><strong>Wydawnictwo:</strong> <?= $book->getPublisher() ?></p>
                    <p><strong>Status:</strong> <?= $book->IsReserved() ? "Zarezerwowane" : "Dostępne"; ?></p>
                </div>
                <a class="button-href" <?= $book->IsReserved() ?
                    $book->IsReservedby()===$_SESSION['id'] ?
                        'href="../cancelReserveBook/'.$book->getID().'"'
                        :
                        ""
                    :
                    'href="../reserveBook/'.$book->getID().'"'; ?>>
                    <button class="<?= $book->IsReserved() ? $book->IsReservedby()===$_SESSION['id'] ? 'unreserve-button' : "reserved-button"  : 'reserve-button'; ?>">
                        <?= $book->IsReserved() ? $book->IsReservedby()===$_SESSION['id'] ? 'Anuluj Rezerwacje' : "Zarezerwowane"  : 'Zarezerwuj'; ?>
                    </button>
                </a>
            </div>
            <?php endforeach; ?>
        </section>
        <div class="page-nav">
            <button class="prev-page"><</button>
            <div class="page-numbers">
                <?php for ($i = 1; $i <= $pages; $i++) :?>
                    <button page-active="false" page-id="<?php echo $i-1 ?>"><?php echo $i ?></button>
                <?php endfor; ?>
            </div>
            <button class="next-page">></button>
        </div>
    </main>
</body>
<template id="book-template">
    <div class="book-card">
        <div class="book-cover">
            <a href="">
                <img src="">
            </a>
        </div>
        <div class="book-details">
            <p id="title"></p>
            <p id="authors">
            </p>
            <p id="genre"></p>
            <p id="publisher"></p>
            <p id="status"></p>
        </div>
        <a class="button-href" id="res-action">
            <button id="res-button" class="">Zarezerwuj</button>
        </a>
    </div>
</template>
<script>
    const div = document.querySelector('#sessionID');
    const sessionID = div.textContent;
    div.innerHTML = ``;
</script>
</html>