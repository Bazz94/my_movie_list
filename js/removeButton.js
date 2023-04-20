function handleClick(e) {
  movie_id = this.id;
  console.log('flag1');
  const viewportWidth = window.innerWidth;
  if (viewportWidth > 500) {
    window.location.href = "user.php?remove-movie=" + movie_id;
  }
  if(this.style.opacity == '1') {
    console.log('flag2');
    window.location.href = "user.php?remove-movie=" + movie_id;
  }
}

let removeButtons = document.querySelectorAll('.remove-btn');
removeButtons.forEach(function (element) {
  element.addEventListener('click', handleClick, false);
});