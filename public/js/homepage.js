document.addEventListener("DOMContentLoaded", function () {
    const joinButton = document.querySelector(".Join-button"); // Join button
    const popupContainer = document.getElementById("popupContainer"); // Modal container
    const closePopup = document.querySelector(".exitBtn"); // Close button
  
    // Show modal when "Join Class" button is clicked
    joinButton.addEventListener("click", function () {
        popupContainer.classList.add("active"); // Show pop-up
    });
  
    // Hide modal when close button is clicked
    closePopup.addEventListener("click", function () {
        popupContainer.classList.remove("active"); // Hide pop-up
    });
  
    // Hide modal when clicking outside of it
    popupContainer.addEventListener("click", function (event) {
        if (event.target === popupContainer) {
            popupContainer.classList.remove("active");
        }
    });
  });
  