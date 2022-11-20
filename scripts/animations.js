//ELEMENTS
const nav = document.querySelector("nav");
const links = document.querySelector(".links");
const nav_links = document.querySelectorAll(".links li");
const burger = document.querySelector(".burger");
// FUNCTIONS

// NAV SCROLL FUNCITON WILL BE TRIGGERED WHEN THE USERS START SCROLLING THE PAGE
const navScroll = (nav, links) => {
  if (document.body.scrollTop > 90 || document.documentElement.scrollTop > 90) {
    nav.style.width = "100%";
    nav.style.padding = "1rem 5%";
    links.style.right = "0%";
  } else {
    nav.style.width = "90%";
    nav.style.padding = "1rem 2rem";
    links.style.right = "5%";
  }
};
// MOBILE NAV BAR
const navMobile = (burger, links, nav_links) => {
  burger.addEventListener("click", () => {
    links.classList.toggle("nav-active");

    nav_links.forEach((link, index) => {
      if (link.style.animation) link.style.animation = "";
      else link.style.animation = `linkFade 0.5s ease forwards ${index / 7}s`;
    });

    //CHANGING THE ICON OF THE NAV TOGGLE TO X
    burger.classList.toggle("toggle");
  });
};

const utitities = () => {
  window.onscroll = () => navScroll(nav, links);
  navMobile(burger, links, nav_links);
};

utitities();

let isVisible = false;
function filter_toggle() {
  if (!isVisible) {
    $(".filters").css("display", "flex");
    isVisible = true;
    $("#toggle-filter-btn").html(
      '<i class="fa-solid fa-sliders"></i> Hide Filter'
    );
  } else {
    $(".filters").css("display", "none");
    isVisible = false;
    $("#toggle-filter-btn").html(
      '<i class="fa-solid fa-sliders"></i> Show Filter'
    );
  }
}
