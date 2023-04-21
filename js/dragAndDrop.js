var user_id = document.currentScript.getAttribute('data');

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

async function handleDrop(e) {
  if (e.stopPropagation) {
    e.stopPropagation(); // stops the browser from redirecting.
  }
  if (this.id !== "add-button" && dragSrcEl.children[3].id !== this.children[3].id) {
    dragSrcEl.innerHTML = this.innerHTML;
    this.innerHTML = e.dataTransfer.getData('text/html');
    var temp = this.children[0].innerHTML;
    this.children[0].innerHTML = dragSrcEl.children[0].innerHTML;
    dragSrcEl.children[0].innerHTML = temp;
    await updateDatabase(dragSrcEl, this);
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
  dragSrcEl.style.transform = 'scale(1)';
  dragSrcEl.children[2].style.opacity = '0';
  dragSrcEl.children[2].style.transform = 'scale(1)';
  dragSrcEl.children[3].style.opacity = '0';
}

function handleClick(e) {
  if (e.preventDefault) {
    e.preventDefault();
  }
  const viewportWidth = window.innerWidth;
  if (viewportWidth > 500) {
    return false;
  }
  const clickedElement = this;
  clickedElement.style.opacity = '0.9';
  clickedElement.nextElementSibling.style.opacity = '1';
  clickedElement.nextElementSibling.style.zIndex = '9';
  var elements = document.querySelectorAll("." + this.classList[0]);
  elements.forEach(function(element) {
    if (clickedElement != element) {
      element.style.opacity = '0';
      element.nextElementSibling.style.opacity = '0';
      element.nextElementSibling.style.zIndex = '-1';
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
});

let clickables = document.querySelectorAll('.image-text');
clickables.forEach(function (element) {
  element.addEventListener('click', handleClick, false);
});



async function updateDatabase(oldElement, newElement)  {
  var oldId = oldElement.children[3].id;
  var newId = newElement.children[3].id;
  window.location.href = `user.php?old=${oldId}&new=${newId}`;
}