document.addEventListener("DOMContentLoaded", function () {
  const openPopupButton = document.getElementById("openPopup"); // Corrected ID
  const popupContainer = document.getElementById("popupContainer"); 
  const closePopup = document.querySelector(".exitBtn"); 
  const classroomForm = document.querySelector(".classroom-form");

  // Open modal when "Add Classroom" button is clicked
  if (openPopupButton) {
      openPopupButton.addEventListener("click", function () {
          popupContainer.classList.add("active");
      });
  }

  // Close modal when "X" button is clicked
  if (closePopup) {
      closePopup.addEventListener("click", function () {
          popupContainer.classList.remove("active");
      });
  }

  // Hide modal when clicking outside of it
  popupContainer.addEventListener("click", function (event) {
      if (event.target === popupContainer) {
          popupContainer.classList.remove("active");
      }
  });

  // Handle form submission
  if (classroomForm) {
      classroomForm.addEventListener("submit", function (event) {
          event.preventDefault(); // Prevent page reload

          const className = document.getElementById("classroomName").value.trim();
          

          if (className === "") {
            alert("Please enter a classroom name.");
            return;
        }
        

          // Fetch classroom route from a meta tag
          const classroomStoreRoute = document.querySelector('meta[name="classroom-route"]').content;

          // Send data to Laravel backend
          fetch(classroomStoreRoute, {
              method: "POST",
              headers: {
                  "Content-Type": "application/json",
                  "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
              },
              body: JSON.stringify({
                subject: className // 
            })
            
          })
          .then(response => response.json())
          .then(data => {
              alert("Classroom Created Successfully!");
              popupContainer.classList.remove("active");
              window.location.reload();
          })
          .catch(error => console.error("Error:", error));
      });
  }
});
