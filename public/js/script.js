window.onload = function () {
  // Get the close button element
  const closeButton = document.getElementById("close-btn");

  const okButton = document.getElementById("ok-btn");

  const addNewButton = document.getElementById("add-new-btn");

  // Get the popup container element
  const popupBackground = document.getElementById("popup-background");

  // Add an event listener to the close button
  closeButton.addEventListener("click", function () {
    // Set the display property of the popup container to "none"
    popupBackground.style.display = "none";
  });

  addNewButton.addEventListener("click", function () {
    // Set the display property of the popup container to "none"
    okBackground.style.display = "none";
  });

  addNewButton.addEventListener("click", function () {
    // Set the display property of the popup container to "none"
    popupBackground.style.display = "flex";
  });
};

