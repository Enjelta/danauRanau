let menu = document.querySelector('#menu-btn');
let navbar = document.querySelector('.header .navbar');

menu.onclick = () =>{
   menu.classList.toggle('fa-times');
   navbar.classList.toggle('active');
};

window.onscroll = () =>{
   menu.classList.remove('fa-times');
   navbar.classList.remove('active');
};

var swiper = new Swiper(".home-slider", {
   loop:true,
   navigation: {
     nextEl: ".swiper-button-next",
     prevEl: ".swiper-button-prev",
   },
});

var swiper = new Swiper(".reviews-slider", {
   grabCursor:true,
   loop:true,
   autoHeight:true,
   spaceBetween: 20,
   breakpoints: {
      0: {
        slidesPerView: 1,
      },
      700: {
        slidesPerView: 2,
      },
      1000: {
        slidesPerView: 3,
      },
   },
});

let loadMoreBtn = document.querySelector('.packages .load-more .btn');
let currentItem = 2;

loadMoreBtn.onclick = () =>{
   let boxes = [...document.querySelectorAll('.packages .box-container .box')];
   for (var i = currentItem; i < currentItem + 2; i++){
      boxes[i].style.display = 'inline-block';
   };
   currentItem += 2;
   if(currentItem >= boxes.length){
      loadMoreBtn.style.display = 'none';
   }
}
chatInput.oninput = () => {
   // menghapus chat dari satu user dan satu pesan respon bot
   let userMessages = chatBox.querySelectorAll('.message.user');
   let lastUserMessage = userMessages[userMessages.length - 1];
   let botMessages = chatBox.querySelectorAll('.message.bot');
   let lastBotMessage = botMessages[botMessages.length - 1];
   if (lastUserMessage && lastBotMessage && lastUserMessage.previousSibling === lastBotMessage) {
   chatBox.removeChild(lastUserMessage);
   chatBox.removeChild(lastBotMessage);
   }
   };
