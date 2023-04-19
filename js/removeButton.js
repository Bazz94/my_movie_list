function handleClick(e) {
  movie_id = this.id;
  window.location.href = "user.php?remove-movie=" + movie_id;
}

let removeButtons = document.querySelectorAll('.remove-btn');
removeButtons.forEach(function (element) {
  element.addEventListener('click', handleClick, false);
});