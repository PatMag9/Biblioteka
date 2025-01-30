const search = document.querySelectorAll('input[name="search-input"]');
const searchButton = document.querySelectorAll('#search-button');
const projectContainer = document.querySelector('.book-list');
const booksNew = document.querySelectorAll('.books-new')
const booksAlphabetical = document.querySelectorAll('.books-alphabetical')
const booksPublisher = document.querySelectorAll('.books-publisher')
const booksGenres = document.querySelectorAll('.books-genres')
const search_button = document.getElementById("search-pair");
const search_popup = document.querySelector(".search-popup");
const prev_page = document.querySelectorAll(".prev-page");
const next_page = document.querySelectorAll(".next-page");
const page_numbers = document.querySelectorAll(".page-numbers");
search_button.addEventListener("click", open_search_popup);

document.querySelectorAll('[page-id="0"]').forEach(page =>{page.setAttribute("page-active", "true")});

// setCookie("searchString","",1);
// setCookie("orderBy","",1);
// setCookie("page","",1);
// setCookie("maxPage","",1);
setCookie("booksPerPage","10",1);

function open_search_popup(){
    search_popup.style.display = "block";
}
document.addEventListener("click", e=>{
    //console.log(e.target);
    if (!search_popup.contains(e.target) && !search_button.contains(e.target)) {
        search_popup.style.removeProperty("display");
    }
});

//filtruj po tytule (wcisniecie enter)
for (let i = 0; i < search.length; i++) {
    search[i].addEventListener('keyup',
        function (event) {
        if(event.key === "Enter") {
            event.preventDefault();
            setCookie("searchString",this.value,1);
            setCookie("page","0",1);
            fetchTotalBooks();
            FetchBooks();
        }
    }
    );
}

//filtruj po tytule (wcisniecie przycisku)
for (let i = 0; i < searchButton.length; i++) {
    searchButton[i].addEventListener('click',
        function () {
            setCookie("searchString",this.previousElementSibling.value,1);
            setCookie("page","0",1);
            fetchTotalBooks();
            FetchBooks();
        }
    );
}

//sortuj po id
for (let i = 0; i < booksNew.length; i++){
    booksNew[i].addEventListener('click',function () {
        resetPagination();
        setCookie("orderBy","b.id_book",1);
        setCookie("page","0",1);
        FetchBooks();
    });
}

//sortuj po tytule
for (let i = 0; i < booksAlphabetical.length; i++){
    booksAlphabetical[i].addEventListener('click',function () {
        resetPagination();
        setCookie("orderBy","b.title",1);
        setCookie("page","0",1);
        FetchBooks();});
}

//sortuj po wydawnictwie
for (let i = 0; i < booksPublisher.length; i++){
    booksPublisher[i].addEventListener('click',function () {
        resetPagination();
        setCookie("orderBy","p.publisher_name",1);
        setCookie("page","0",1);
        FetchBooks();});
}

//sortuj po gatunku
for (let i = 0; i < booksGenres.length; i++){
    booksGenres[i].addEventListener('click',function () {
        resetPagination();
        setCookie("orderBy","g.genre_name",1);
        setCookie("page","0",1);
        FetchBooks();});
}

//poprzednia strona
for (let i = 0; i < prev_page.length; i++) {
    prev_page[i].addEventListener('click',
        function () {
            let curr_page = getCookie("page");
            if(parseInt(curr_page)>0){
                document.querySelectorAll('[page-id="'+curr_page+'"]').forEach(page =>{page.setAttribute("page-active", "false")});
                curr_page=parseInt(curr_page)-1;
                document.querySelectorAll('[page-id="'+curr_page+'"]').forEach(page =>{page.setAttribute("page-active", "true")});
                setCookie("page",curr_page,1);
                FetchBooks();
            }
        }
    );
}

//następna strona
for (let i = 0; i < next_page.length; i++) {
    next_page[i].addEventListener('click',
        function () {
            let curr_page = getCookie("page");
            if(parseInt(curr_page)<parseInt(getCookie("maxPage"))-1){
                document.querySelectorAll('[page-id="'+curr_page+'"]').forEach(page =>{page.setAttribute("page-active", "false")});
                curr_page=parseInt(curr_page)+1;
                document.querySelectorAll('[page-id="'+curr_page+'"]').forEach(page =>{page.setAttribute("page-active", "true")});
                setCookie("page",curr_page,1);
                FetchBooks();
            }
        }
    );
}

function FetchBooks() {
    const data = {
        searchString: getCookie("searchString"),
        orderBy: getCookie("orderBy"),
        page: getCookie("page"),
        booksPerPage: getCookie("booksPerPage")
    };

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

function loadBooks(books) {
    books.forEach(book =>{
        console.log(book);
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

    const status = clone.querySelector('#status');
    status.innerHTML = `<strong>Status:</strong> ${(book.isReserved === true) ? 'Zarezerwowane' :'Dostępne'}`;

    const resAction = clone.querySelector('#res-action');
    (book.isReserved === true) ?
        (parseInt(book.isReservedBy) === parseInt(sessionID)) ?
            resAction.href=`../cancelReserveBook/${book.id_book}`
            :
            ''
        :
        resAction.href=`../reserveBook/${book.id_book}`;

    const resButton = clone.querySelector('#res-button');
    resButton.className= `${(book.isReserved === true) ? 
        (parseInt(book.isReservedBy) === parseInt(sessionID)) ? 
            'unreserve-button' 
            :
            'reserved-button' 
        :
        'reserve-button'}`;
    resButton.innerHTML= `${(book.isReserved === true) ? 
        (parseInt(book.isReservedBy) === parseInt(sessionID)) ? 
            'Anuluj Rezerwacje' 
            :
            'Zarezerwowane' 
        :
        'Zarezerwuj'}`;

    projectContainer.appendChild(clone);
}

function fetchTotalBooks(){
    const data = {
        searchString: getCookie("searchString")
    };

    fetch("/fetchPagesByCondition",{
        method: "POST",
        headers:{
            'Content-type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (pages) {
        createPagination(pages);
    });
}

function createPagination(pages){
    console.log(pages)
    setCookie("maxPage",pages.pages,1);
    page_numbers.forEach( pagination =>{
        pagination.innerHTML= '';
        for (let i = 1; i < parseInt(pages.pages)+1; i++){
            if (i==parseInt(getCookie("page"))+1){

                pagination.innerHTML+= `<button page-active="true" page-id="${i-1}">${i}</button>`;
            }
            else{
                pagination.innerHTML+= `<button page-active="false" page-id="${i-1}">${i}</button>`;
            }
        }
    });
}

function resetPagination(){
    document.querySelectorAll('[page-id="'+getCookie("page")+'"]').forEach(page =>{page.setAttribute("page-active", "false")});
    document.querySelectorAll('[page-id="0"]').forEach(page =>{page.setAttribute("page-active", "true")});
}

function setCookie(name, value, daysToLive){
    const date = new Date();
    date.setTime(date.getTime()+(daysToLive*24*60*60*1000));
    let expires = "expires="+date.toUTCString();
    document.cookie=`${name}=${value}; ${expires}; path=/`;
}

function deleteCookie(name){
    setCookie(name,null,null);
}

function getCookie(name){
    const cDecoded=decodeURIComponent(document.cookie);
    const cArray = cDecoded.split("; ");
    let result = null;
    cArray.forEach(element =>{
        if (element.indexOf(name)==0){
            result = element.substring(name.length+1);
        }
    })
    return result;
}