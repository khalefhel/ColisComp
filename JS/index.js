$(document).ready(function () {
  $(".js-nav a, .js-connect").click(function (e) {
    e.preventDefault();
    $("body, html").animate(
      {
        scrollTop: $($.attr(this, "href")).offset().top,
      },
      750
    );
  });
});
document.addEventListener("DOMContentLoaded", () => {
  const options = { duration: 2 };

  const countUp1 = new CountUp("colis-livres", 10000, options);
  const countUp2 = new CountUp("utilisateurs-actifs", 5000, options);
  const countUp3 = new CountUp("pays-desservis", 20, options);

  if (!countUp1.error) {
    countUp1.start();
    countUp2.start();
    countUp3.start();
  } else {
    console.error(countUp1.error);
  }
});
function toggleFaq(element) {
  const answer = element.nextElementSibling;
  const arrow = element.querySelector(".faq-arrow");

  if (answer.style.display === "block") {
    answer.style.display = "none";
    arrow.classList.remove("active");
  } else {
    answer.style.display = "block";
    arrow.classList.add("active");
  }

  element.classList.toggle("active");
}
