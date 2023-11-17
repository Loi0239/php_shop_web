const btn_product = document.querySelector(".pro");
const sub_menu = document.querySelector(".sub_menu");
const dashBoard = document.querySelector("#dashBoard");
const userAccount = document.querySelector("#userAccount");
const category = document.querySelector("#category");
const productWarehouse = document.querySelector("#productWarehouse");
const cart = document.querySelector("#cart");
const order = document.querySelector("#order");
const arrElemtns = [dashBoard, userAccount, category, productWarehouse, cart, order];


btn_product.addEventListener('click', () => {
    if(sub_menu.classList.contains("show")){
        sub_menu.classList.remove("show");
    }else{
        sub_menu.classList.add("show");
    }

    if(btn_product.classList.contains("active")){
        btn_product.classList.remove("active");
    }else{
        btn_product.classList.add("active");
    }
})

const urlParams = new URLSearchParams(window.location.search);
const sign = urlParams.get('ql');

switch (sign) {
    case 'db':
        dashBoard.classList.add('keep');
        break;
    case 'qltk':
        userAccount.classList.add('keep');
        break;
    case 'cate':
        category.classList.add('keep');
        break;
    case 'pw':
        productWarehouse.classList.add('keep');
        sub_menu.classList.add("show");
        btn_product.classList.add("active");
        break;
    case 'cart':
        cart.classList.add('keep');
        sub_menu.classList.add("show");
        btn_product.classList.add("active");
        break;
    case 'order':
        order.classList.add('keep');
        sub_menu.classList.add("show");
        btn_product.classList.add("active");
        break;
    default:
        break;
}
