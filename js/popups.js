const popupBackground = document.getElementById("popup-background");

const closeButton = document.getElementById("close-btn");
if (closeButton != null) {
  closeButton.addEventListener("click", function () {
    // Set the display property of the popup container to "none"
    popupBackground.style.display = "none";
  });
}
const addNewButton = document.getElementById("add-new-btn");
if (addNewButton != null) {
  addNewButton.addEventListener("click", function () {
    // Set the display property of the popup container to "none"
    popupBackground.style.display = "flex";
  });
}


