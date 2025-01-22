//alert("asd")
//opcje otwierania/zamykania popupu książek
const bookAddOpen = document.getElementById("book-add-open");
const bookAddClose = document.getElementById("book-add-close");
const bookCancelButton = document.getElementById("book-cancel-button");

//przyciski otwierania pozostałych popupów
const user_button = document.getElementById("user-button");
const menu_button = document.getElementById("menu-button");
const mobile_menu_button = document.getElementById("mobile_menu_button");
const search_button = document.getElementById("search-pair");

//popupy
const user_popup = document.querySelector(".user-popup");
const mobile_menu = document.querySelector(".mobile-nav");
const search_popup = document.querySelector(".search-popup");
const book_add_view = document.querySelector(".book-add-view");

//rozwijane menu do wybierania autorów
const authorsDropdownHeader = document.querySelector('.authors-dropdown-header');
const authorsDropdownList = document.querySelector('.authors-dropdown-list');
const authorsSearchInput = document.getElementById('authors-search-input');
const selectedAuthors = document.getElementById('authors-dropdown-selected');

//nasłuchiwanie czy została wybrana opcja odpowiadająca za otwieranie/zamykanie popupu dodawania książek
bookAddOpen.addEventListener("click", open_book_add_view);
bookAddClose.addEventListener("click", close_book_add_view);
bookCancelButton.addEventListener("click", close_book_add_view);

//nasłuchiwanie czy została wybrany przycisk otwierania pozostałych popupów
user_button.addEventListener("click", open_user_popup);
menu_button.addEventListener("click", open_mobile_menu);
search_button.addEventListener("click", open_search_popup);

//logika otwierania/zamykania popupu dodawania ksiażek
function open_book_add_view() {
    book_add_view.style.display = "flex";
}
function close_book_add_view() {
    book_add_view.style.removeProperty("display");
}

//logika otwierania pozostałych popupów
function open_user_popup(){
    user_popup.style.display = "block";
}
function open_mobile_menu(){
    mobile_menu.style.display = "block";
}
function open_search_popup(){
    search_popup.style.display = "block";
}

//zamykanie pozostałych popupów, kiedy klikniemy po za ich pole
document.addEventListener("click", e=>{
    //console.log(e.target);
    if (!user_popup.contains(e.target) && !user_button.contains(e.target) && !book_add_view.contains(e.target)){
        user_popup.style.removeProperty("display");
    }
    if (!mobile_menu.contains(e.target) && !menu_button.contains(e.target) || e.target==mobile_menu_button) {
        mobile_menu.style.removeProperty("display");
    }
    if (!search_popup.contains(e.target) && !search_button.contains(e.target)) {
        search_popup.style.removeProperty("display");
    }
    if(!authorsDropdownList.contains(e.target) && !authorsDropdownHeader.contains(e.target)){
        authorsDropdownList.style.removeProperty("display");
    }
});

//otwieranie/chowanie rozwijanej listy autorów
authorsDropdownHeader.addEventListener('click', () => {
    if (authorsDropdownList.style.display === "none" || authorsDropdownList.style.display === "") {
        authorsDropdownList.style.display = "block";
    } else {
        authorsDropdownList.style.display = "none";
    }
});

//Wyświetlanie wybranych autorów z rozwijanej listy
authorsDropdownList.addEventListener('click', (e) => {
    if (e.target.tagName === 'INPUT') {
        const selectedOptions = Array.from(
            authorsDropdownList.querySelectorAll('input:checked')
        ).map(input => input.id);

        selectedAuthors.textContent = selectedOptions.length
            ? selectedOptions.join(', ')
            : 'Wybierz opcje';
    }
});

//Wyszukiwanie autorów z rozwijanej listy
authorsSearchInput.addEventListener('input', () => {
    const filter = authorsSearchInput.value.toLowerCase();
    const labels = authorsDropdownList.querySelectorAll('label');

    labels.forEach(label => {
        const text = label.textContent.toLowerCase();
        if (text.includes(filter)) {
            label.style.display = '';
        } else {
            label.style.display = 'none';
        }
    });
});