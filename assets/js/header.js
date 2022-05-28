// Định nghĩa phương thức truy vấn 1 phần tử mới
const a = document.querySelector.bind(document); 
// Định nghĩa phương thức truy vấn nhiều phần tử mới
const s = document.querySelectorAll.bind(document); 

/******************** Header ********************/
/* Hiện menu trên mobile */
const menuList = a('.menu-list');
const loginMobile = a('.login__mobile');
const menuMobile = a('.menu__mobile-click');
menuMobile.onclick = () => {
    menuList.classList.toggle('display-on-mobile');
    loginMobile.classList.toggle('display-on-mobile');
}

/* Hiện submenu trên mobile */
const subMenus = s('.subMenu-list');
const products = s('.menu-list__products > a');
for (let i = 0; i < products.length; i++) {
    products[i].addEventListener('click', function(e) {
        subMenus[i].classList.toggle('display-on-mobile');
        (subMenus[i].previousElementSibling).lastElementChild.classList.toggle('rotate');
    })
}

/* Vô hiệu hóa đường dẫn danh mục sản phẩm trên mobile và tablet */
// if (document.documentElement.clientWidth <= 1023) {
//     products.forEach(function (product) {
//         product.href = '#';
//     })
// }

/* Chỉnh background header khi scroll */
window.addEventListener("scroll", function() {
    let y = window.pageYOffset;
    if (y > 0) {
        a("#main-header").style.backgroundColor = "rgba(255,255,255,1)";
    } else
        a("#main-header").style.backgroundColor = "rgba(255,255,255,0.5)";
})


