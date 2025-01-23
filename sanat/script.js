let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () => {
    profile.classList.toggle('active');
    navbar.classList.remove('active');
}


let navbar = document.querySelector('.header .flex .navbar');

document.querySelector('#menu-btn').onclick = () => {
    profile.classList.remove('active');
    navbar.classList.toggle('active');
}
window.onscroll = () => {
    profile.classList.remove('active');
    navbar.classList.remove('active');
}
subImages = document.querySelectorAll('.vue-rapide .box .image-container .small-image img');
mainImage = document.querySelector('.vue-rapide .box .image-container .big-image img');

subImages.forEach(images => {
    images.onclick = () => {
        let src = images.getAttribute('src');
        mainImage.src = src;
    }
});

