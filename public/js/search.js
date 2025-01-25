const search = document.querySelectorAll('input[name="search-input"]');
const projectContainer = document.querySelector('.book-list');
const booksNew = document.querySelectorAll('.books-new')
const booksAlphabetical = document.querySelectorAll('.books-alphabetical')
const booksPublisher = document.querySelectorAll('.books-publisher')
const booksGenres = document.querySelectorAll('.books-genres')
const search_button = document.getElementById("search-pair");
const search_popup = document.querySelector(".search-popup");
search_button.addEventListener("click", open_search_popup);

function open_search_popup(){
    search_popup.style.display = "block";
}
document.addEventListener("click", e=>{
    //console.log(e.target);
    if (!search_popup.contains(e.target) && !search_button.contains(e.target)) {
        search_popup.style.removeProperty("display");
    }
});

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
    const category = 'b.id_book';
    booksNew[i].addEventListener('click',function () {handleClick(category);});
}

for (let i = 0; i < search.length; i++){
    const category = 'b.title';
    booksAlphabetical[i].addEventListener('click',function () {handleClick(category);});
}

for (let i = 0; i < search.length; i++){
    const category = 'p.publisher_name';
    booksPublisher[i].addEventListener('click',function () {handleClick(category);});
}

for (let i = 0; i < search.length; i++){
    const category = 'g.genre_name';
    booksGenres[i].addEventListener('click',function () {handleClick(category);});
}

function handleClick(category) {
    const data = { condition: category  };

    fetch("/orderByCondition", {
        method: "POST",
        headers: {
            'Content-type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (books) {
        projectContainer.innerHTML = "";
        loadBooks(books);
    });
}

function loadBooks(books) {
    books.forEach(book =>{
        //console.log(book);
        createBook(book);
    });
}
function createBook(book) {
    const template = document.querySelector('#book-template')
    const clone = template.content.cloneNode(true);

    const image = clone.querySelector('img');
    image.src = `/public/uploads/${book.cover}`;

    const coverLink = clone.querySelector('a');
    coverLink.href = `../book/${book.id_book}`;

    const title = clone.querySelector('#title');
    title.innerHTML = `<strong>Tytuł:</strong> <a href="../book/${book.id_book}">${book.title}</a>`;

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
