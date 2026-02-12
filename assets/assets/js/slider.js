initSlider({
    sectionSelector: '.newItems',
    containerId: 'newItemsCards',
    cardsData: null,
    type: 'item'
});

initSlider({
    sectionSelector: '.insights',
    containerId: 'insightsCards',
    cardsData: null,
    type: 'insight'
});

function initSlider(config) {
    const { sectionSelector, containerId, cardsData, type } = config;

    const section = document.querySelector(sectionSelector);
    if (!section) return;

    const container = section.querySelector(`#${containerId}`);
    if (!container) return;

    const btnLeft = section.querySelector('.block__arrow.left');
    const btnRight = section.querySelector('.block__arrow.right');

    const slides = Array.isArray(cardsData) && cardsData.length > 0
        ? cardsData.map(card => createCard(card, type))
        : Array.from(container.children);

    if (slides.length === 0) {
        return;
    }

    if (Array.isArray(cardsData) && cardsData.length > 0) {
        slides.forEach(card => container.append(card));
    }

    slides.forEach(card => container.append(card.cloneNode(true)));
    slides.forEach(card => container.prepend(card.cloneNode(true)));

    let currentSlide = slides.length;
    const cardWidth = slides[0].offsetWidth + 20;
    container.style.transform = `translateX(-${cardWidth * currentSlide}px)`;

    let isAnimating = false;

    const goToSlide = (slide) => {
        container.style.transition = 'transform 0.5s';
        container.style.transform = `translateX(-${cardWidth * slide}px)`;
    };

    const resetSlide = (slide) => {
        container.style.transition = 'none';
        currentSlide = slide;
        container.style.transform = `translateX(-${cardWidth * currentSlide}px)`;
    };

    const nextSlide = () => {
        if (isAnimating) return;
        isAnimating = true;

        currentSlide++;
        goToSlide(currentSlide);
    };

    const prevSlide = () => {
        if (isAnimating) return;
        isAnimating = true;

        if (currentSlide === slides.length) {
            container.style.transition = 'none';
            currentSlide = slides.length * 2;
            container.style.transform = `translateX(-${cardWidth * currentSlide}px)`;
        }

        requestAnimationFrame(() => {
            currentSlide--;
            goToSlide(currentSlide);
        });
    };

    if (btnRight) {
        btnRight.addEventListener('click', () => {
            setActiveArrow(btnRight);
            nextSlide();
        });
    }

    if (btnLeft) {
        btnLeft.addEventListener('click', () => {
            setActiveArrow(btnLeft);
            prevSlide();
        });
    }

    function setActiveArrow(activeBtn) {
        if (btnLeft) btnLeft.classList.remove('block__active');
        if (btnRight) btnRight.classList.remove('block__active');
        activeBtn.classList.add('block__active');
    }

    container.addEventListener('transitionend', () => {
        if (currentSlide >= slides.length * 2) {
            resetSlide(slides.length);
        }
        if (currentSlide < slides.length) {
            resetSlide(slides.length * 2 - 1);
        }
        isAnimating = false;
    });
}

function createActionIcon(type, link = '#') {
    if (type === 'item') {
        const plus = document.createElement('span');
        plus.classList.add('newItems__plus');
        plus.textContent = '+';
        return plus;
    }

    if (type === 'insight') {
        const arrowLink = document.createElement('a');
        arrowLink.href = link;
        arrowLink.classList.add('insights__arrow');
        arrowLink.textContent = '->';
        return arrowLink;
    }

    return null;
}

function createCard(card, type) {
    const cardEl = document.createElement('div');
    cardEl.classList.add(type === 'item' ? 'newItems__card' : 'insights__card');

    const img = document.createElement('img');
    img.src = card.img;
    img.alt = card.title || 'image';
    img.classList.add(type === 'item' ? 'newItems__img' : 'insights__img');
    cardEl.append(img);

    const content = document.createElement('div');
    content.classList.add(type === 'item' ? 'newItems__content' : 'insights__content');
    cardEl.append(content);

    if (type === 'insight') {
        content.innerHTML = `
            <span class="insights__title">${card.title}</span>
            <span class="insights__description">${card.description}</span>
        `;
        const arrow = createActionIcon('insight', card.link || '#');
        cardEl.append(arrow);
    }

    if (type === 'item') {
        content.innerHTML = `
            <p class="newItems__description">${card.description}</p>
            <div class="newItems__titleWrapper">
                <p class="newItems__title">${card.title}</p>
                <p class="newItems__price">${card.price}</p>
            </div>
        `;
        const plus = createActionIcon('item');
        cardEl.append(plus);
    }

    return cardEl;
}
