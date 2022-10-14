//Tabs
const tabs = document.querySelectorAll(".connect-tab");
const buttons = document.querySelectorAll(".connect-buttons");

buttons.forEach((button, index) => {
  button.addEventListener("click", () => {
    buttons.forEach((button) => {
      button.classList.replace("border-red", "border-transparent");
      button.classList.replace("text-black", "text-gray400");
      button.classList.remove("font-semibold");
    });
    button.classList.replace("border-transparent", "border-red");
    button.classList.replace("text-gray400", "text-black");
    button.classList.add("font-semibold");
    tabs.forEach((tab) => {
      tab.classList.add("hidden");
    });
    tabs[index].classList.replace("hidden", "block");
  });
});

// Input Buttons
const categoryButtons = document.querySelectorAll(".member-category-btn");
const categoryCheckboxes = document.querySelectorAll(
  ".member-category-checkboxes"
);

let categoryButtonsState = [];
categoryButtons.forEach((button, index) => {
  categoryButtonsState = [...categoryButtonsState, false];
});
categoryButtons.forEach((button, index) => {
  button.addEventListener("click", () => {
    if (categoryButtonsState[index] === false) {
      button.style.transform = "rotate(-90deg)";
      categoryButtonsState[index] = !categoryButtonsState[index];
      categoryCheckboxes[index].classList.replace("block", "hidden");
    } else {
      button.style.transform = "rotate(0deg)";
      categoryButtonsState[index] = !categoryButtonsState[index];
      categoryCheckboxes[index].classList.replace("hidden", "block");
    }
  });
});
