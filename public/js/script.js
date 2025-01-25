//alert("asd")

//przyciski otwierania popupów
const user_button = document.getElementById("user-button");
const menu_button = document.getElementById("menu-button");
const mobile_menu_button = document.getElementById("mobile_menu_button");

//popupy
const user_popup = document.querySelector(".user-popup");
const mobile_menu = document.querySelector(".mobile-nav");

//nasłuchiwanie czy została wybrany przycisk otwierania popupów
user_button.addEventListener("click", open_user_popup);
menu_button.addEventListener("click", open_mobile_menu);

//logika otwierania popupów
function open_user_popup(){
    user_popup.style.display = "block";
}
function open_mobile_menu(){
    mobile_menu.style.display = "block";
}

//zamykanie popupów, kiedy klikniemy po za ich pole
document.addEventListener("click", e=>{
    //console.log(e.target);
    if (!user_popup.contains(e.target) && !user_button.contains(e.target)){
        user_popup.style.removeProperty("display");
    }
    if (!mobile_menu.contains(e.target) && !menu_button.contains(e.target) || e.target===mobile_menu_button) {
        mobile_menu.style.removeProperty("display");
    }
});
