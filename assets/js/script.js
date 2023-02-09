// const msg = 'Hello';
// console.log(msg);

/*Navaber's JS*/
const popup= document.querySelector('.full-screen');
console.log(popup);
console.log("8")

function openSideMenu(){
    document.getElementById('side-menu').style.width = '250px';
    document.getElementById('content',).style.marginLeft = '250px';
}


function closeSideMenu(){
    document.getElementById('side-menu').style.width = '0';
    document.getElementById('content').style.marginLeft = '0';
}

function togglePopUp(){
    popup.classList.toggle('hidden');
}


const swiper = new Swiper('.swiper', {
    // Optional parameters
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
    loop: true,

    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

});
