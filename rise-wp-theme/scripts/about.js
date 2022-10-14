const hideButtons = document.querySelectorAll(".about-hide-btn");
const hiddenTexts = document.querySelectorAll(".text-clip");

hideButtons.forEach((button, index) => {
  let hidden = true;
  button.addEventListener("click", () => {
    if (hidden) {
      hiddenTexts[index].classList.add("text-unclip");
      button.firstElementChild.classList.replace("block", "hidden");
      button.lastElementChild.classList.replace("hidden", "block");
    } else {
      hiddenTexts[index].classList.remove("text-unclip");
      button.firstElementChild.classList.replace("hidden", "block");
      button.lastElementChild.classList.replace("block", "hidden");
    }
    hidden = !hidden;
  });
});

const fundersHideButtons = document.querySelectorAll('.funders-hide-btn');
const fundersTextClips = document.querySelectorAll(".funders-text-clip")
fundersHideButtons.forEach((button, index) => {
  let hidden = true;
  button.addEventListener("click", () => {
    if (hidden) {
      fundersTextClips[index].classList.add("text-unclip");
      button.firstElementChild.classList.replace("block", "hidden");
      button.lastElementChild.classList.replace("hidden", "block");
    } else {
      fundersTextClips[index].classList.remove("text-unclip");
      button.firstElementChild.classList.replace("hidden", "block");
      button.lastElementChild.classList.replace("block", "hidden");
    }
    hidden = !hidden;
  });
});