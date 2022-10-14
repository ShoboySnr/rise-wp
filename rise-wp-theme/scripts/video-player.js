function playVideo() {
  const trailer = document.querySelector('#trailer');
  // @ts-ignore
  trailer.classList.remove('hide-trailer');
  trailer.classList.add('show-trailer');
}

function stopVideo() {
  const trailer = document.querySelector('#trailer');
  // @ts-ignore
  trailer.classList.remove('show-trailer');
  trailer.classList.add('hide-trailer');
}

function addPlayVideo() {
  const playVideoBtn = document.querySelector('#play-btn');
  if (playVideoBtn) {
    playVideoBtn.addEventListener('click', playVideo);
    playVideoBtn.addEventListener('keydown', playVideo);
  }
}
function addStopVideo() {
  const stopVideoBtn = document.querySelector('#stop-btn');
  if (stopVideoBtn) {
    stopVideoBtn.addEventListener('click', stopVideo);
    stopVideoBtn.addEventListener('keydown', stopVideo);
  }
}

window.addEventListener('DOMContentLoaded', function () {
  addPlayVideo();
  addStopVideo();
});
