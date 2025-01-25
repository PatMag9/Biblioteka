//opcje otwierania/zamykania okna dodawania książek
const bookAddOpen = document.getElementById("book-add-open");
const bookAddClose = document.getElementById("book-add-close");
const bookCancelButton = document.getElementById("book-cancel-button");

//okno dodawnia książek
const book_add_view = document.querySelector(".book-add-view");

//rozwijane menu do wybierania autorów
const authorsDropdownHeader = document.querySelector('.authors-dropdown-header');
const authorsDropdownList = document.querySelector('.authors-dropdown-list');
const authorsSearchInput = document.getElementById('authors-search-input');
const selectedAuthors = document.getElementById('authors-dropdown-selected');

//nasłuchiwanie czy została wybrana opcja odpowiadająca za otwieranie/zamykanie okna dodawania książek
bookAddOpen.addEventListener("click", open_book_add_view);
bookAddClose.addEventListener("click", close_book_add_view);
bookCancelButton.addEventListener("click", close_book_add_view);

//logika otwierania/zamykania okna dodawania ksiażek
function open_book_add_view() {
    book_add_view.style.display = "flex";
}
function close_book_add_view() {
    book_add_view.style.removeProperty("display");
}

//zamykanie rozwijanej listy autorów, kiedy klikniemy po za ich pole
document.addEventListener("click", e=>{
    //console.log(e.target);
    if (!user_popup.contains(e.target) && !user_button.contains(e.target) && !book_add_view.contains(e.target)){
        user_popup.style.removeProperty("display");
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