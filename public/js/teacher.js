document.addEventListener("DOMContentLoaded", function () {
    const openPopupButton = document.getElementById("openPopup");
    const popupContainer = document.getElementById("popupContainer");
    const closePopup = document.querySelector(".exitBtn");
    const classroomForm = document.querySelector(".classroom-form");
    const imagePages = [
        ['class_bg2.jpg', 'class_bg4.jpg', 'class_bg5.jpg', 'class_bg6.jpg', 'class_bg8.jpg', 'class_bg9.jpg'],
        // Add more arrays if you add more pages of images in the future
      ];
      
      let currentPage = 0;
      

    function goToStep2() {
        const selectedImage = document.querySelector('input[name="background_image"]:checked');
        if (!selectedImage) {
            alert("Please select a background image.");
            return;
        }

        document.querySelector('.step-1').style.display = 'none';
        document.querySelector('.step-2').style.display = 'flex';
    }
    window.goToStep2 = goToStep2;

    function changeImagePage(direction) {
        const newPage = currentPage + direction;
        if (newPage >= 0 && newPage < imagePages.length) {
          currentPage = newPage;
          renderImagePage();
        }
    }
    window.changeImagePage = changeImagePage;

      

    function renderImagePage() {
        const container = document.getElementById("imagePageContainer");
        const pageIndicator = document.getElementById("imagePageIndicator");
        container.innerHTML = "";
      
        imagePages[currentPage].forEach((bg, index) => {
          const label = document.createElement("label");
      
          const input = document.createElement("input");
          input.type = "radio";
          input.name = "background_image";
          input.value = bg;
          input.hidden = true;
          if (index === 0 && currentPage === 0) input.checked = true;
      
          const img = document.createElement("img");
          img.src = `/images/${bg}`;
          img.className = "bg-thumb";
          img.onclick = () => {
            input.checked = true;
          };
      
          label.appendChild(input);
          label.appendChild(img);
          container.appendChild(label);
        });
      
        pageIndicator.textContent = currentPage + 1;
      }
      

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
    if (popupContainer) {
        popupContainer.addEventListener("click", function (event) {
            if (event.target === popupContainer) {
                popupContainer.classList.remove("active");
            }
        });
    }

    // Handle form submission
    if (classroomForm) {
        classroomForm.addEventListener("submit", function (event) {
            event.preventDefault();

            const className = document.getElementById("classroomName").value.trim();
            const selectedImage = document.querySelector('input[name="background_image"]:checked')?.value;

            if (className === "") {
                alert("Please enter a classroom name.");
                return;
            }

            if (!selectedImage) {
                alert("Please select a background image.");
                return;
            }

            const classroomStoreRoute = document.querySelector('meta[name="classroom-route"]').content;

            fetch(classroomStoreRoute, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    subject: className,
                    background_image: selectedImage
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

    renderImagePage();

});
