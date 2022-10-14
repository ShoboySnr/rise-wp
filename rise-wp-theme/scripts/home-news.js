const rightButtons = document.querySelectorAll('.news-right');
const leftButtons = document.querySelectorAll('.news-left');

let translate = 0;

function getCarouselInfo(id) {
  const carousel = document.getElementById(id);
  const carouselItemWidth = parseFloat(
    getComputedStyle(carousel.children.item(0)).width.replace(/px/gi, () => '')
  );
  return [carousel, carouselItemWidth];
}

leftButtons.forEach((leftBtn) =>
  leftBtn.addEventListener('click', () => {
    const [carousel, itemWidth] = getCarouselInfo(
      leftBtn.getAttribute('data-carousel')
    );
    if (translate === 0 - itemWidth) {
      leftBtn.classList.add('opacity-30');
    }
    if (translate < 0) {
      leftBtn.nextElementSibling.classList.remove('opacity-30');
      translate += itemWidth;
      carousel.style.transform = `translateX(${translate}px)`;
    }
  })
);

rightButtons.forEach((rightBtn) =>
  rightBtn.addEventListener('click', () => {
    const [carousel, itemWidth] = getCarouselInfo(
      rightBtn.getAttribute('data-carousel')
    );
    if (translate === (2 - carousel.children.length) * itemWidth) {
      rightBtn.classList.add('opacity-30');
    }
    if (translate > (1 - carousel.children.length) * itemWidth) {
      rightBtn.previousElementSibling.classList.remove('opacity-30');
      translate -= itemWidth;
      carousel.style.transform = `translateX(${translate}px)`;
    }
  })
);
