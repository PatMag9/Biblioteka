<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="../public/css/style.css" />
    <script type="text/javascript" src="../public/js/script.js" defer></script>
    <?php if($_SESSION["isAdmin"]===true)
        echo '<script type="text/javascript" src="../public/js/addBook.js" defer></script>';
    ?>
    <title>BiblioSolis</title>
    <meta charset="UTF-8">
</head>

<body>
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
                    <a href="../main/new"><li>Nowości</li></a>
                    <a href=""><li>Popularne</li></a>
                    <a href="../main/alphabetical"><li>Alfabetycznie</li></a>
                    <a href="../main/publisher"><li>Wydawnictwo</li></a>
                    <a href="../main/genre"><li>Gatunki</li></a>
                </ul>
            </div>
        </div>
        <div class="header-logo">
            <a href="../main"><img src="../public/img/logo_outline.svg"></a>
            <div class="banner">BiblioSolis</div>
        </div>
        <div class="right-side">
            <div class="user-component">
                <button id="user-button"><img src="../public/img/user.svg"></button>
                <div class="user-popup">
                    <ul>
                        <li>Wyloguj</li>
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
                <a href="../main/new">
                    <div class="nav-element">
                        <div class="nav-text">
                            Nowości
                        </div>
                        <div class="nav-line">

                        </div>
                    </div>
                </a>
                <a href="">
                    <div class="nav-element">
                        <div class="nav-text">
                            Popularne
                        </div>
                        <div class="nav-line">

                        </div>
                    </div>
                </a>
                <a href="../main/alphabetical">
                    <div class="nav-element">
                        <div class="nav-text">
                            Alfabetycznie
                        </div>
                        <div class="nav-line">

                        </div>
                    </div>
                </a>
                <a href="../main/publisher">
                    <div class="nav-element">
                        <div class="nav-text">
                            Wydawnictwo
                        </div>
                        <div class="nav-line">

                        </div>
                    </div>
                </a>
                <a href="../main/genre">
                    <div class="nav-element">
                        <div class="nav-text">
                            Gatunki
                        </div>
                        <div class="nav-line">

                        </div>
                    </div>
                </a>
            </ul>
        </nav>
        <section class="book-list">
            <?php if (isset($book)): ?>
            <div class="book-page">
                <div class="book-info">
                    <div class="book-cover"><img src="/../public/uploads/<?= $book->getCover() ?>"></div>
                    <div class="book-details">
                        <p><strong>Tytuł:</strong> <?= $book->getTitle() ?></p>
                        <p><strong>Autor:</strong>
                            <?php foreach($book->getAuthors() as $author): ?>
                                <?= $author->getName()." ".$author->getSurname()."&nbsp&nbsp&nbsp&nbsp" ?>
                            <?php endforeach; ?>
                        </p>
                        <p><strong>Gatunek:</strong> <?= $book->getGenre() ?></p>
                        <p><strong>Wydawca:</strong> <?= $book->getPublisher() ?></p>
                        <p><strong>Status:</strong> <?= $book->IsReserved() ? "Zarezerwowane" : "Dostępne"; ?></p>
                    </div>
                </div>
                <div class="book-bottom">
                    <hr class="divider">
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
            </div>
            <?php endif; ?>
        </section>
    </main>
</body>

</html>