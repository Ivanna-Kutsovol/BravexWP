const slides = document.querySelectorAll('.hero__video');
const bottom = document.getElementById('bottom');

let currentSlideIndex = 0;
const paginationCircles = [];

let autoSlide = null;
const SLIDE_DELAY = 7000;

function showSlide() {
    const video = slides[currentSlideIndex];
    video.classList.add('block');
    video.currentTime = 0;
    video.play();
}

function hideSlide(){
    const video = slides[currentSlideIndex];
    video.classList.remove('block');
    video.pause();
}

function updatePagination() {
    paginationCircles.forEach(circle =>
        circle.classList.remove('active')
    );
    paginationCircles[currentSlideIndex].classList.add('active');
}

function nextSlide() {
    hideSlide();
    currentSlideIndex ++;
    if(currentSlideIndex > slides.length - 1) {
        currentSlideIndex = 0;
    }
    showSlide();
    updatePagination();
}

function startAutoSlide() {
    stopAutoSlide();
    autoSlide = setInterval(() => {
        nextSlide();
    }, SLIDE_DELAY);
}

function stopAutoSlide() {
    if(autoSlide) {
        clearInterval(autoSlide);
        autoSlide = null;
    }
}

function createPaginationCircle() {
    const div = document.createElement('div');
    div.className = "pagination-circle";
    bottom.appendChild(div);
    paginationCircles.push(div);
}

function addPagination(){
    slides.forEach(createPaginationCircle);
    paginationCircles[0].classList.add('active');
}

addPagination();

showSlide();
startAutoSlide();

paginationCircles.forEach((circle, index) => {
    circle.addEventListener('click', () => {
        hideSlide();
        currentSlideIndex = index;
        showSlide();
        updatePagination();

        startAutoSlide();
    });
});
