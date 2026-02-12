const cards = [
    {
        img: '../assets/img/categories/furnitureSofas.png',
        title: 'Furniture & Sofas'
    },
    {
        img: '../assets/img/categories/childrenFurniture.png',
        title: 'Children Furniture'
    },
    {
        img: '../assets/img/categories/bathroomSanitaryFurniture.png',
        title: 'Bathroom & Sanitary Furniture'
    },
    {
        img: '../assets/img/categories/kitchens.png',
        title: 'Kitchens'
    },
    {
        img: '../assets/img/categories/lightingMirrors.png',
        title: 'Lighting & Mirrors'
    },
    {
        img: '../assets/img/categories/doorsGlassPartitions.png',
        title: 'Doors, Glass & Partitions'
    },
    {
        img: '../assets/img/categories/decorFinishingMaterials.png',
        title: 'Decor & Finishing Materials'
    },
    {
        img: '../assets/img/categories/architectureStairs.png',
        title: 'Architecture & Stairs'
    }
]

const cardsContainer = document.querySelector('.cards');

cards.forEach(card => {
    const cardEl = document.createElement('div');
    cardEl.classList.add('card');

    const img = document.createElement('img');
    img.src = card.img;
    img.alt = card.title;

    const title = document.createElement('p');
    title.classList.add('card__title');
    title.textContent = card.title;

    cardEl.append(img, title);
    cardsContainer.append(cardEl);
})