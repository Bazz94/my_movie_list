window.onload = function () {
  // Get the close button element
  const closeButton = document.getElementById("close-btn");

  // Get the popup container element
  const popupContainer = document.getElementById("popup-background");

  // Add an event listener to the close button
  closeButton.addEventListener("click", function () {
    // Set the display property of the popup container to "none"
    popupContainer.style.display = "none";
  });
};
