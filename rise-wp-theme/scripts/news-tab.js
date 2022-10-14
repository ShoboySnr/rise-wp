const newsContainer = document.querySelectorAll(".news-card-wrapper");
const newsTabButton = document.querySelectorAll(".news-tab-btn");

newsTabButton.forEach((button, index) => {
  button.addEventListener("click", () => {
    newsTabButton.forEach((buttonItem) => {
      buttonItem.classList.replace( "border-red", "border-transparent");
      buttonItem.classList.replace("text-black", "text-gray250");
    });
    button.classList.replace("border-transparent", "border-red");
    button.classList.replace("text-gray250", "text-black");

    newsContainer.forEach((card, indexTwo) => {
     if (index === indexTwo) card.style.display = 'grid';
     else card.style.display = 'none';
    });
  });
});
