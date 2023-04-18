var userid = document.currentScript.getAttribute('data');

var dragSrcEl = null;

function handleDragStart(e) {
  dragSrcEl = this;
  e.dataTransfer.effectAllowed = 'move';
  e.dataTransfer.setData('text/html', this.innerHTML);
  this.style.transform = 'scale(1.05)';
  this.children[2].style.opacity = '0.9';
  this.children[2].style.transform = 'scale(1.05)';
  this.children[3].style.opacity = '0';
}

function handleDragOver(e) {
  if (e.preventDefault) {
    e.preventDefault();
  }
  e.dataTransfer.dropEffect = 'move';
  return false;
}

function handleDragEnter(e) {
  this.classList.add('over');
}

function handleDragLeave(e) {
  this.classList.remove('over');
}

function handleDrop(e) {
  if (e.stopPropagation) {
    e.stopPropagation(); // stops the browser from redirecting.
  }
  if (dragSrcEl != this && this.id != "add-button") {
    dragSrcEl.innerHTML = this.innerHTML;
    this.innerHTML = e.dataTransfer.getData('text/html');
    updateDatabase(dragSrcEl, this);
  }
  dragSrcEl.style.transform = 'scale(1)';
  dragSrcEl.children[2].style.opacity = '0';
  dragSrcEl.children[2].style.transform = 'scale(1)';
  dragSrcEl.children[3].style.opacity = '0';
  return false;
}

function handleDragEnd(e) {
  items.forEach(function (item) {
    item.classList.remove('over');
  });
}

function handleClick(e) {
  const viewportWidth = window.innerWidth;
  if (viewportWidth > 500 || this.id == 'add-button' || this.classList[0] == 'remove-btn') {
    return false;
  }
  const clickedElement = this.children[2];
  this.children[3].style.opacity = '1';
  clickedElement.style.opacity = '0.9';
  var elements = document.querySelectorAll("." + this.children[2].classList[0]);
  elements.forEach(function(element) {
    if (clickedElement != element) {
      element.style.opacity = '0';
      element.nextElementSibling.style.opacity = '0';
    }
  });
}

let items = document.querySelectorAll('.grid-container .image-container');
items.forEach(function (item) {
  item.addEventListener('dragstart', handleDragStart, false);
  item.addEventListener('dragenter', handleDragEnter, false);
  item.addEventListener('dragover', handleDragOver, false);
  item.addEventListener('dragleave', handleDragLeave, false);
  item.addEventListener('drop', handleDrop, false);
  item.addEventListener('dragend', handleDragEnd, false);
  item.addEventListener('click',handleClick, false);
});

function updateDatabase(oldElement, newElement) {

  var oldId = getMovieFromElement(oldElement);
  var newId = getMovieFromElement(newElement);
  fetch("http://127.0.0.1/my_movie_list/php/handleDragAndDrop.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
    },
    body: `old=${oldId}&new=${newId}&user-id=${userid}`,
  })
    .then((response) => response.text());
}

function getMovieFromElement(element) {
  var div = document.createElement('div');
  div.innerHTML = element.innerHTML;
  var name = div.querySelector('[class^="remove-btn"]').name;
  return name; //the name of this element is the id of the movie in the db
}