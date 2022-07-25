let _chat = document.querySelector('.chat');
let nav = document.querySelector('.navbar');

_chat.addEventListener('click', expandImage);

function expandImage(e) {
    if (e.target.tagName == 'IMG') {
        document.body.classList.toggle('overflow-hidden');
        e.target.parentNode.classList.toggle('expanded');
        nav.classList.toggle('fixed-top');
    }
}