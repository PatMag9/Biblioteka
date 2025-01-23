const search = document.querySelectorAll('input[name="search-input"]');
const projectContainer = document.querySelector('.book-list');
const booksNew = document.querySelectorAll('.books-new')
const booksAlphabetical = document.querySelectorAll('.books-alphabetical')
const booksPublisher = document.querySelectorAll('.books-publisher')
const booksGenres = document.querySelectorAll('.books-genres')

for (let i = 0; i < search.length; i++) {
    search[i].addEventListener('keyup',
        function (event) {
        if(event.key === "Enter") {
            event.preventDefault();

            const data = {search: this.value};

            fetch("/search",{
                method: "POST",
                headers:{
                    'Content-type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(function (response) {
                return response.json();
            }).then(function (books) {
                projectContainer.innerHTML= "";
                loadBooks(books);
            });

        }
    }
    );
}

for (let i = 0; i < search.length; i++){
    booksNew[i].addEventListener('click',
        function () {

            const data = {condition: 'b.id_book'};

            fetch("/orderByCondition",{
                method: "POST",
                headers:{
                    'Content-type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(function (response) {
                return response.json();
            }).then(function (books) {
                projectContainer.innerHTML= "";
                loadBooks(books);
            });

        }
    );
}

for (let i = 0; i < search.length; i++){
    booksAlphabetical[i].addEventListener('click',
        function () {

            const data = {condition: 'b.title'};

            fetch("/orderByCondition",{
                method: "POST",
                headers:{
                    'Content-type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(function (response) {
                return response.json();
            }).then(function (books) {
                projectContainer.innerHTML= "";
                loadBooks(books);
            });

        }
    );
}

for (let i = 0; i < search.length; i++){
    booksPublisher[i].addEventListener('click',
        function () {

            const data = {condition: 'p.publisher_name'};

            fetch("/orderByCondition",{
                method: "POST",
                headers:{
                    'Content-type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(function (response) {
                return response.json();
            }).then(function (books) {
                projectContainer.innerHTML= "";
                loadBooks(books);
            });

        }
    );
}

for (let i = 0; i < search.length; i++){
    booksGenres[i].addEventListener('click',
        function () {

            const data = {condition: 'g.genre_name'};

            fetch("/orderByCondition",{
                method: "POST",
                headers:{
                    'Content-type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(function (response) {
                return response.json();
            }).then(function (books) {
                projectContainer.innerHTML= "";
                loadBooks(books);
            });

        }
    );
}

function loadBooks(books) {
    books.forEach(book =>{
        console.log(book); //remove later
        createBook(book);
    });
}
function createBook(book) {
    const template = document.querySelector('#book-template')
    const clone = template.content.cloneNode(true);

    const image = clone.querySelector('img');
    image.src = `/public/uploads/${book.cover}`;

    const title = clone.querySelector('#title');
    title.innerHTML = `<strong>Tytuł:</strong> ${book.title}`;

    const authors = clone.querySelector('#authors');
    authors.innerHTML = `<strong>Autor/rzy:</strong>`;
    book['authors'].forEach(author =>{
        authors.innerHTML += ` ${author.name} ${author.surname}&nbsp&nbsp&nbsp&nbsp`;
    });

    const genre = clone.querySelector('#genre');
    genre.innerHTML = `<strong>Gatunek:</strong> ${book.genre}`;

    const publisher = clone.querySelector('#publisher');
    publisher.innerHTML = `<strong>Wydawca:</strong> ${book.publisher}`;

    projectContainer.appendChild(clone);
}
