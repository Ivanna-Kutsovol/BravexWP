const catalogCards = document.querySelectorAll('.catalog__card');
const videos = document.querySelectorAll('.catalog__video');

catalogCards.forEach((card, index) => {
card.addEventListener('click', () => {
    catalogCards.forEach(c => c.classList.remove('catalog__active'));
    card.classList.add('catalog__active');

    videos.forEach(video => {
        video.classList.remove('block');
        video.pause();
        video.currentTime = 0;
    });

    videos[index].classList.add('block');
    videos[index].play();
    });
});