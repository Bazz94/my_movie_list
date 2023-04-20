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

function handleDrop(e) {
  if (e.stopPropagation) {
    e.stopPropagation(); // stops the browser from redirecting.
  }
  if (dragSrcEl !== this && this.id !== "add-button") {
    dragSrcEl.innerHTML = this.innerHTML;
    this.innerHTML = e.dataTransfer.getData('text/html');
    var temp = this.children[0].innerHTML;
    this.children[0].innerHTML = dragSrcEl.children[0].innerHTML;
    dragSrcEl.children[0].innerHTML = temp;
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
  var response = await fetch("http://127.0.0.1/my_movie_list/php/handleDragAndDrop.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
    },
    body: `old=${oldId}&new=${newId}&user-id=${user_id}`,
  });
  // If Request failed
  if (!response.ok) {
    window.location.href = "error.php?error=" + response.statusText;
    return false;
  }

  // Request returned ok
  var responseData = await response.text(); // Get response body as text
  var data = JSON.parse(responseData); // Parse response body as JSON

  // Check if file executed correctly
  if(data.status === "error") {
    window.location.href = "error.php?error=" + data.message;
    return false;
  }
}