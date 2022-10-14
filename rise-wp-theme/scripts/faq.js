const questions = document.querySelectorAll(".faq-question__container");
for (let i = 0; i < questions.length; i++) {
	questions[i].addEventListener('click', function (e) {
    e.currentTarget.classList.toggle('open');
  });
}