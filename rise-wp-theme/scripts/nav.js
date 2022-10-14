let hidden = true;
window.addEventListener("DOMContentLoaded", () => {
  document.querySelector(".nav-toggle").addEventListener("click", () => {
    if (hidden) {
      document.querySelector(".mobile-nav").classList.remove("hidden");
      document.querySelector("header").classList.add("header-fixed");
      document.querySelector(".nav-toggle").classList.add("active");
    } else {
      document.querySelector(".mobile-nav").classList.add("hidden");
      document.querySelector("header").classList.remove("header-fixed");
      document.querySelector(".nav-toggle").classList.remove("active");
    }
    hidden = !hidden;
  });
});
