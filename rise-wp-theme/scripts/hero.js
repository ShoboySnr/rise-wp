/* eslint-disable no-undef */
// import gsap from 'gsap';

gsap.registerPlugin(ScrollTrigger);

const tl = new gsap.timeline({
  paused: true,
});
// letter animation
tl.fromTo(
  '#typewriter1',
  1.5,
  {
    width: '0',
  },
  {
    width: '11.18em' /* animate line 2 */,
    ease: SteppedEase.config(37),
  },
  'start'
)
  .fromTo(
    '#typewriter2',
    1.5,
    {
      width: '0',
    },
    {
      width: '10.18em' /* animate line 2 */,
      ease: SteppedEase.config(37),
    }
  )
  .fromTo(
    '#circle-img',
    0.25,
    {
      top: '-10000px' /* show the line image */,
      right: '-10000px',
    },
    {
      top: '8rem',
      right: '1rem',
    },
    'start'
  )
  .fromTo(
    '.hero-text',
    0.27,
    {
      opacity: '0',
    },
    {
      opacity: '1',
    }
  )
  .fromTo(
    '.forward-link',
    0.15,
    {
      opacity: '0',
    },
    {
      opacity: '1',
    }
  );
tl.play();

const mql = window.matchMedia('(min-width: 769px)');
const mql2 = window.matchMedia('(max-width: 768px)');

if (mql2.matches) {
  gsap.to('#circle-img', {
    scrollTrigger: {
      trigger: '.circle-img',
      start: 'top top',
      scrub: 0.2,
      toggleActions: 'restart none reverse none',
    },
    rotation: 65,
    duration: 10,
  });
}
if (mql.matches) {
  gsap.to('#circle-img', {
    scrollTrigger: {
      trigger: '#first-view',
      start: 'top top',
      scrub: 0.2,
      toggleActions: 'restart none reverse none',
    },
    rotation: 75,
    duration: 1,
  });
}
