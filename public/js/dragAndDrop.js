var userid = document.currentScript.getAttribute('data');
  
  var dragSrcEl = null;

  function handleDragStart(e) {
    dragSrcEl = this;
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/html', this.innerHTML);
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
      updateDatabase(dragSrcEl,this);
    }
    return false;
  }

  function handleDragEnd(e) {
    items.forEach(function (item) {
      item.classList.remove('over');
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

  function updateDatabase(oldElement, newElement) {

    oldId = getMovieFromElement(oldElement);
    newId = getMovieFromElement(newElement);
    fetch("http://127.0.0.1/my_movie_list/public/php/handleDragAndDrop.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
      },
      body: `old=${oldId}&new=${newId}&userid=${userid}`,
    })
      .then((response) => response.text());
  }

  function getMovieFromElement(element) {
    var div = document.createElement('div');
    div.innerHTML = element.innerHTML;
    var name = div.querySelector('[class^="remove-btn"]').name;
    return name; //the name of this element is the id of the movie in the db
  }