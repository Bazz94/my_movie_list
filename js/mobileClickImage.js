function handleClick(e) {
  const viewportWidth = window.innerWidth;
  if (viewportWidth > 500) {
    return false;
  }
  const clickedElement = this;
  clickedElement.style.opacity = '0.9';
  var elements = document.querySelectorAll("." + this.classList[0]);
  elements.forEach(function (element) {
    if (clickedElement != element) {
      element.style.opacity = '0';
    }
  });
}

let clickables = document.querySelectorAll('.image-text');
clickables.forEach(function (element) {
  element.addEventListener('click', handleClick, false);
});