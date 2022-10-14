//onDOMContentLoaded because they are in a web component
window.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.opportunities-btn').forEach((btn) => {
      btn.addEventListener('click', () => {
        // @PaimoEmmanuel @locksiDesmond please refactor and optimise this code. It can be written without running a loop. You can refer to home-news.js to assist you in refactor this
        document.querySelectorAll('.opportunities-btn').forEach((item) => {
          if (item.classList.contains('opportunities-btn-active')) {
            item.classList.remove('opportunities-btn-active');
          }
        });
        btn.classList.add('opportunities-btn-active');
      });
      });
      document
        .querySelector('.opportunity-categories')
        .addEventListener('click', () => {
          if (
            document
              .querySelector('.opportunity-categories')
              .classList.contains('opportunity-filter-active')
          ) {
            document
              .querySelector('.opportunity-categories')
              .classList.remove('opportunity-filter-active');
            document
              .querySelector('.opportunity-categories-box')
              .classList.add('hidden');
          } else {
            document
              .querySelector('.opportunity-categories')
              .classList.add('opportunity-filter-active');
            document
              .querySelector('.opportunity-categories-box')
              .classList.remove('hidden');
          }
        });
      document.querySelector('.opportunity-types').addEventListener('click', () => {
        if (
          document
            .querySelector('.opportunity-types')
            .classList.contains('opportunity-filter-active')
        ) {
          document
            .querySelector('.opportunity-types')
            .classList.remove('opportunity-filter-active');
          document.querySelector('.opportunity-types-box').classList.add('hidden');
        } else {
          document
            .querySelector('.opportunity-types')
            .classList.add('opportunity-filter-active');
          document.querySelector('.opportunity-types-box').classList.remove('hidden');
        }
      });
});
