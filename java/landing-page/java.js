const hamMenu = document.querySelector('.hamMenu');
console.log(hamMenu); // log the .hamMenu element

const offScreenMenu = document.querySelector('.offScreenMenu');
console.log(offScreenMenu); // log the .offScreenMenu element       (Not Logged)

const closeMenu = document.querySelector('.closeMenu');

hamMenu.addEventListener('click', () => {
    console.log("Hamburger menu clicked");
    hamMenu.classList.toggle('active');
    offScreenMenu.classList.toggle('active');
})

closeMenu.addEventListener('click', () => {
  hamMenu.classList.remove('active');
  offScreenMenu.classList.remove('active');
});

let cards = document.querySelectorAll(".card");

let stackArea = document.querySelector(".stack-area");

function rotateCards() {
  let angle = 0;
  cards.forEach((card, index) => {
    if (card.classList.contains("away")) {
      card.style.transform = `translateY(-120vh) rotate(-48deg)`;
    } else {
      card.style.transform = ` rotate(${angle}deg)`;
      angle = angle - 10;
      card.style.zIndex = cards.length - index;
    }
  });
}

rotateCards();

window.addEventListener("scroll", () => {
  let distance = window.innerHeight * 0.5;

  let topVal = stackArea.getBoundingClientRect().top;

  let index = -1 * (topVal / distance + 1);

  index = Math.floor(index);

  for (i = 0; i < cards.length; i++) {
    if (i <= index) {
      cards[i].classList.add("away");
    } else {
      cards[i].classList.remove("away");
    }
  }
  rotateCards();
});

