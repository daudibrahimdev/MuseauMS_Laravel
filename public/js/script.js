// Toggle class active untuk navbr jadi sidebar

const navbarNav = document.querySelector('.navbar-nav');
// ketika hamburger di klik
document.querySelector('#hamburger-menu').onclick = () => {
  navbarNav.classList.toggle('active');
};


// toggle class active untuk search form

const searchForm = document.querySelector('.search-form');
const searchBox = document.querySelector('#search-box');

document.querySelector('#search-button').onclick = (e) => {
  searchForm.classList.toggle('active');
  searchBox.focus(); // biar langsung active ngetik pas di klik
  e.preventDefault(); // biar gak scroll ke# pas klik
}

//toggle class active untuk shopping cart
const shoppingCart = document.querySelector('.shopping-cart');

document.querySelector('#shopping-cart-button').onclick = (e) => {
  shoppingCart.classList.toggle('active');
  e.preventDefault();
}


// fungsi untuk hilangin sidebar tanpa harus klik hamburger (klik selain hambur = closed sidebar)
// dan untuk elemen lainnya ditampung disini

const hamburger = document.querySelector('#hamburger-menu');
const searchButton = document.querySelector('#search-button');
const SCB = document.querySelector('#shopping-cart-button');
 
document.addEventListener('click', function(e){
  if(!hamburger.contains(e.target) && !navbarNav.contains(e.target)) {
    navbarNav.classList.remove('active');
  }

  if(!searchButton.contains(e.target) && !searchForm.contains(e.target)) {
    searchForm.classList.remove('active');
  }

  if(!SCB.contains(e.target) && !shoppingCart.contains(e.target)) {
    shoppingCart.classList.remove('active');
  }

})

